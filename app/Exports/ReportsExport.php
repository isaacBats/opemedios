<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2021
  * @version 1.0.1 (Optimized and Corrected)
  * @package App\
  * Type: Export
  * Description: Optimized Report Export with all graph data
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Exports;

use App\Models\{Company, Theme};
use App\Exports\Sheets\{DashboardSheet, DataTableSheet};
use App\Filters\{AssignedNewsFilter, NewsFilter};
use Carbon\{Carbon, CarbonPeriod};
use DB;
use Maatwebsite\Excel\Concerns\{Exportable, WithMultipleSheets};
use Illuminate\Http\Request;


class ReportsExport implements WithMultipleSheets
{
    use Exportable;

    private $request;
    private $client;
    private $notesIds;
    private $themes;
    private $data_graph;
    private $count_news;
    private $count_trend;
    private $count_mean;
    private $columnas_generadas;
    private $init_row = 40; 
    private $notes; 
    private $metrics_data; // Propiedad para almacenar las métricas

    public function __construct(Request $request) 
    {
        $this->request = $request;
        $this->client = Company::find($this->request->input('company'));

        // 1. Establecer Rango de Fechas
        $from = $this->request->input('start_date') ? Carbon::create($this->request->input('start_date')) : Carbon::now()->subDays(10);
        $to = $this->request->input('end_date') ? Carbon::create($this->request->input('end_date')) : Carbon::now();

        // Asegurar que las fechas estén en el request
        $this->request->merge([
            'start_date' => $from->format('Y-m-d'),
            'end_date' => $to->format('Y-m-d')
        ]);
        
        // 2. Obtener IDs de notas/noticias de forma eficiente
        $this->notesIds = AssignedNewsFilter::filter($this->request, ['company' => $this->client])
                            ->pluck('news_id');

        // Si no hay notas, inicializar y salir temprano (Optimización)
        if ($this->notesIds->isEmpty()) {
            $this->initializeEmptyData();
            return;
        }

        // 3. Obtener datos de Tendencias y Medios
        $this->metrics_data = $this->getMetricsData(); // Llama y guarda las métricas

        // 4. Obtener la lista de Temas (solo los usados)
        $this->themes = DB::table('assigned_news')
            ->join('news', 'assigned_news.news_id', '=', 'news.id')
            ->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
            ->select('themes.id', 'themes.name')
            ->whereIn('news.id', $this->notesIds)
            ->whereBetween(DB::raw('date(news.created_at)'), [$from->format('Y-m-d'), $to->format('Y-m-d')])
            ->groupBy('themes.id', 'themes.name')
            ->orderBy('themes.name', 'desc')
            ->get();
        
        // 5. Una sola consulta para todos los datos del gráfico de temas (Optimización Crítica)
        $report_data = DB::table('assigned_news')
            ->join('news', 'assigned_news.news_id', '=', 'news.id')
            ->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
            ->select(
                DB::raw('DATE(news.created_at) as dt'),
                'themes.id as theme_id',
                'themes.name as theme_name',
                DB::raw('COUNT(*) as total')
            )
            ->whereIn('news.id', $this->notesIds)
            ->whereBetween(DB::raw('DATE(news.created_at)'), [$from->format('Y-m-d'), $to->format('Y-m-d')])
            ->groupBy(DB::raw('DATE(news.created_at)'), 'themes.id', 'themes.name')
            ->orderBy(DB::raw('DATE(news.created_at)'), 'desc')
            ->get();

        // 6. Procesar los datos y armar la matriz $this->data_graph (CORRECCIÓN CRÍTICA)
        $this->processGraphData($report_data, $from, $to, $this->metrics_data);

        // 7. Generar encabezados de columna y recalcular fila inicial
        $this->columnas_generadas = $this->generaColumnasExcel();
        $this->init_row = max(40, count(CarbonPeriod::create($from, $to)) + 6); 

        // 8. Notas para la segunda hoja de exportación (EAGER LOADING)
        $this->notes = NewsFilter::filter($this->request, ['ids' => $this->notesIds])
            ->with([
                'source',
                'mean',
                'assignedNews' => function ($query) {
                    $query->where('company_id', $this->client->id)
                          ->with('theme'); 
                },
            ]);
    }

    /**
     * Inicializa las propiedades para evitar errores si no hay datos.
     */
    private function initializeEmptyData(): void
    {
        $this->themes = collect();
        $this->data_graph = [];
        $this->count_news = 0;
        $this->count_trend = 0;
        $this->count_mean = 0;
        $this->columnas_generadas = ['A'];
        $this->init_row = 40;
        $this->notes = NewsFilter::filter($this->request, ['ids' => []]);
        $this->metrics_data = [];
    }

    /**
     * Calcula las métricas de Tendencias y Medios y las devuelve.
     */
    private function getMetricsData(): array
    {
        $obj = [];

        // TENDENCIAS
        $tendencias = NewsFilter::filter($this->request, ['ids' => $this->notesIds])
            ->select('trend', DB::raw('count(*) as total'))
            ->groupBy('trend')
            ->get();

        foreach($tendencias as $itm) {
            $label = match((int)$itm->trend) {
                1 => 'Positiva',
                2 => 'Neutral',
                default => 'Negativa',
            };
            $obj['trend_lbl'][] = $label . ' (' . $itm->total .')';
            $obj['trend'][] = $itm->total;
        }
        $this->count_trend = count($obj['trend_lbl'] ?? []);

        // MEDIOS
        $medios = NewsFilter::filter(new Request(), ['ids' => $this->notesIds]) 
            ->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->with('mean')
            ->get();

        foreach($medios as $itm) {
            if ($itm->mean) { 
                $obj['mean_lbl'][] = $itm->mean->name . ' (' . $itm->total .')';
                $obj['mean'][] = $itm->total;
            }
        }
        $this->count_mean = count($obj['mean_lbl'] ?? []);
        
        return $obj;
    }

    /**
     * Procesa los datos crudos de la BD en el formato requerido para el gráfico.
     * Incluye datos de Tendencia, Medios y Temas/Fechas.
     */
    private function processGraphData($report_data, Carbon $from, Carbon $to, array $metrics_data): void
    {
        // 1. Inicialización de datos para el gráfico de Temas
        $fechas = CarbonPeriod::create($from, $to)->toArray(); 
        $theme_totals = $this->themes->keyBy('id')->map(fn() => 0)->toArray();
        $obj = []; // Array que se convertirá en $this->data_graph

        // Agrupar los resultados de la consulta por fecha y tema
        $grouped_data = $report_data->groupBy('dt')->map(fn($date_group) => 
            $date_group->keyBy('theme_id')->map(fn($item) => $item->total)
        );

        // =======================================================
        // 1. INTEGRAR DATOS DE TENDENCIA Y MEDIOS (FILAS 1 a 4) - FIX para el 0%
        // =======================================================
        
        // FILA 1: Etiquetas de Tendencias
        $obj[1] = array_merge([''], $metrics_data['trend_lbl'] ?? []);
        
        // FILA 2: Valores de Tendencias
        $obj[2] = array_merge([''], $metrics_data['trend'] ?? []);

        // FILA 3: Etiquetas de Medios
        $obj[3] = array_merge([''], $metrics_data['mean_lbl'] ?? []);
        
        // FILA 4: Valores de Medios
        $obj[4] = array_merge([''], $metrics_data['mean'] ?? []);

        // =======================================================
        // 2. INTEGRAR DATOS DE TEMAS/FECHAS (FILA 5 en adelante)
        // =======================================================

        // FILA 5 (Encabezado de la tabla de Temas/Fechas)
        $header_row = ['']; 
        foreach ($this->themes as $theme) {
            $header_row[] = $theme->name; // Nombre del tema (sin total inicial)
        }
        $obj[5] = $header_row;

        // FILA 6 en adelante: Datos por fecha/tema
        foreach ($fechas as $date) {
            $dt_key = $date->format('Y-m-d');
            $date_data = $grouped_data[$dt_key] ?? collect();
            $row = [$dt_key]; // Columna A: Fecha

            // Iterar sobre los temas
            foreach ($this->themes as $theme) {
                $total_count = $date_data[$theme->id] ?? 0;
                $row[] = $total_count;
                $theme_totals[$theme->id] += $total_count; 
            }

            // Usamos un índice numérico secuencial a partir de 6 para asegurar el orden
            $obj[] = $row; 
        }

        // 3. Actualizar el encabezado de la tabla de Temas/Fechas (FILA 5) con los totales
        $col_index = 1;
        foreach ($this->themes as $theme) {
            $obj[5][$col_index] = $theme->name . ' (' . $theme_totals[$theme->id] . ')';
            $col_index++;
        }
        
        $this->count_news = count($fechas); 
        
        $this->data_graph = $obj;
    }


    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
                new DashboardSheet(
                    $this->init_row,
                    $this->columnas_generadas,
                    $this->themes,
                    $this->count_news,
                    $this->count_trend,
                    $this->count_mean,
                    $this->data_graph),
                new DataTableSheet(
                    $this->notes, 
                    $this->client)
            ];
    }

    public function generaColumnasExcel()
    {
        $columns_excel = [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' ];//count 26

        $dt = array();
        $ind = -1;
        $ind_ = 0;
        $ind__ = -1;

        foreach($this->themes as $key => $itm)
        {
            if($key == 0)
            {
                $dt[] = $columns_excel[$ind_];
                $ind_++;
            }

            if($ind == -1 && $key < count($columns_excel))
                $dt[] = $columns_excel[$ind_];
            elseif($ind__ == -1 && $ind < count($columns_excel))
                $dt[] = $columns_excel[$ind] . $columns_excel[$ind_];
            else
                $dt[] = $columns_excel[$ind__] . $columns_excel[$ind] . $columns_excel[$ind_];

            $ind_++;
            if($ind_ == (count($columns_excel)))
            {
                $ind_ = 0;
                $ind++;
                if($ind == (count($columns_excel)))
                {
                    $ind = 0;
                    $ind__++;
                }

            }
        }

        return $dt;
    }

}