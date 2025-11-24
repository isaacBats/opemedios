<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2021
  * @version 1.0.0
  * @package App\
  * Type: Export
  * Description: Description
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
    private $init_row = 40; // Se mantiene, pero se recalcula de forma más limpia.
    private $notes; // Se mantiene para DataTableSheet

    public function __construct(Request $request) // Tipado para claridad
    {
        $this->request = $request;
        $this->client = Company::find($this->request->input('company'));

        // 1. Obtener IDs de notas/noticias de forma eficiente
        // Se asume que AssignedNewsFilter::filter() devuelve un Query Builder
        $this->notesIds = AssignedNewsFilter::filter($this->request, ['company' => $this->client])
                            ->pluck('news_id');

        // Si no hay notas, salir temprano
        if ($this->notesIds->isEmpty()) {
            $this->initializeEmptyData();
            return;
        }

        // 2. Establecer Rango de Fechas
        $from = $this->request->input('start_date') ? Carbon::create($this->request->input('start_date')) : Carbon::now()->subDays(10);
        $to = $this->request->input('end_date') ? Carbon::create($this->request->input('end_date')) : Carbon::now();

        // Asegurar que las fechas estén en la request (para filtros posteriores)
        $this->request->merge([
            'start_date' => $from->format('Y-m-d'),
            'end_date' => $to->format('Y-m-d')
        ]);

        // 3. Obtener datos de Tendencias y Medios (Optimizado)
        $this->getMetricsData();

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
        
        // Si no hay temas, salir temprano (debería ser redundante si no hay notas, pero es una buena verificación)
        if ($this->themes->isEmpty()) {
            $this->initializeEmptyData();
            return;
        }

        // 5. ¡El gran ahorro de tiempo! Una sola consulta para todos los datos del gráfico
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

        // 6. Procesar los datos de la consulta para el formato del gráfico (en memoria)
        $this->processGraphData($report_data, $from, $to);

        // 7. Generar encabezados de columna y recalcular fila inicial
        $this->columnas_generadas = $this->generaColumnasExcel();
        $this->init_row = max(40, count(CarbonPeriod::create($from, $to)) + 6); // Más legible

        // 8. Notas para la segunda hoja de exportación
        $this->notes = NewsFilter::filter($this->request, ['ids' => $this->notesIds]);
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
    }

    /**
     * Calcula las métricas de Tendencias y Medios.
     * (Separado para limpieza, manteniendo la lógica original)
     */
    private function getMetricsData(): void
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

        // MEDIOS (NOTA: el filtro de Request se eliminó aquí por seguir la lógica de su código original: `NewsFilter::filter((new Request)`)
        $medios = NewsFilter::filter(new Request(), ['ids' => $this->notesIds]) 
            ->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->with('mean') // Cargar la relación para obtener el nombre del medio
            ->get();

        foreach($medios as $itm) {
             // Verificar si la relación 'mean' existe
            if ($itm->mean) { 
                $obj['mean_lbl'][] = $itm->mean->name . ' (' . $itm->total .')';
                $obj['mean'][] = $itm->total;
            }
        }
        $this->count_mean = count($obj['mean_lbl'] ?? []);
    }

    /**
     * Procesa los datos crudos de la BD en el formato requerido para el gráfico.
     * @param \Illuminate\Support\Collection $report_data
     * @param Carbon $from
     * @param Carbon $to
     */
    private function processGraphData($report_data, Carbon $from, Carbon $to): void
    {
        $fechas = CarbonPeriod::create($from, $to)->toArray(); // Obtener todas las fechas del periodo
        $theme_totals = $this->themes->keyBy('id')->map(fn() => 0)->toArray();
        $formatted_data = [];

        // Agrupar los resultados de la consulta por fecha y tema para fácil acceso (O(N) de la colección)
        $grouped_data = $report_data->groupBy('dt')->map(fn($date_group) => 
            $date_group->keyBy('theme_id')->map(fn($item) => $item->total)
        );

        // Inicializar la estructura con la fila de encabezados de temas
        $graph_obj = [0 => array_merge([''], $this->themes->pluck('name')->toArray())];

        // Iterar sobre el periodo (O(D) donde D es el número de días)
        foreach ($fechas as $date) {
            $dt_key = $date->format('Y-m-d');
            $date_data = $grouped_data[$dt_key] ?? collect(); // Obtener datos del día o un array vacío
            $row = [$dt_key]; // Iniciar la fila con la fecha

            // Iterar sobre los temas (O(T) donde T es el número de temas)
            foreach ($this->themes as $theme) {
                $total_count = $date_data[$theme->id] ?? 0;
                $row[] = $total_count;
                $theme_totals[$theme->id] += $total_count; // Sumar para el total por tema
            }

            $graph_obj[$dt_key] = $row;
        }

        // 3. Recalcular la fila de encabezados con el total
        foreach ($this->themes as $i => $theme) {
            // El índice en la fila 0 es $i + 1 porque el primer elemento es la cadena vacía ''
            $graph_obj[0][$i + 1] = $theme->name . ' (' . $theme_totals[$theme->id] . ')';
        }

        $this->count_news = count($graph_obj);
        $this->data_graph = $graph_obj;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        // Se mantiene igual, pero los datos ahora se generaron más rápido.
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

    /**
     * Genera las columnas de Excel (Se mantiene igual ya que es una función de utilería)
     * @return array
     */
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