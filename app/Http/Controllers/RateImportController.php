<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\SocialNetworks;
use App\Models\Source;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RateImportController extends Controller
{
    /**
     * Show the import form.
     */
    public function showForm(): View
    {
        $breadcrumb = [
            ['label' => 'Tarifas', 'url' => route('rates')],
            ['label' => 'Importar CSV'],
        ];

        return view('admin.rates.import', compact('breadcrumb'));
    }

    /**
     * Upload and process the CSV file.
     */
    public function upload(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ], [
            'csv_file.required' => 'El archivo CSV es requerido.',
            'csv_file.mimes' => 'El archivo debe ser un CSV válido.',
            'csv_file.max' => 'El archivo no puede superar los 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('csv_file');
        $filepath = $file->getPathname();

        try {
            $result = $this->processCSV($filepath);

            $message = sprintf(
                '¡Importación exitosa! Nuevos: %d, Actualizados: %d, Saltados: %d',
                $result['imported'],
                $result['updated'],
                $result['skipped']
            );

            return redirect()->route('rates')->with('status', $message);

        } catch (\Exception $e) {
            Log::error('Rate CSV Import Error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Process the CSV file and import rates.
     *
     * @return array{imported: int, updated: int, skipped: int}
     */
    private function processCSV(string $filepath): array
    {
        $handle = fopen($filepath, 'r');

        if ($handle === false) {
            throw new \RuntimeException('No se pudo abrir el archivo CSV');
        }

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            // Read and validate header
            $header = fgetcsv($handle);

            $requiredColumns = ['source_name', 'content_type', 'min_value', 'price', 'type'];
            $missingColumns = array_diff($requiredColumns, $header);

            if (!empty($missingColumns)) {
                throw new \RuntimeException(
                    'Columnas faltantes en el CSV: ' . implode(', ', $missingColumns)
                );
            }

            $lineNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $lineNumber++;

                if (count($row) < count($header)) {
                    $skipped++;
                    continue;
                }

                $data = array_combine($header, $row);
                $result = $this->processRow($data);

                if ($result === 'imported') {
                    $imported++;
                } elseif ($result === 'updated') {
                    $updated++;
                } else {
                    $skipped++;
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            fclose($handle);
        }

        return [
            'imported' => $imported,
            'updated' => $updated,
            'skipped' => $skipped,
        ];
    }

    /**
     * Process a single row from the CSV.
     *
     * @return string 'imported'|'updated'|'skipped'
     */
    private function processRow(array $data): string
    {
        $sourceName = trim($data['source_name'] ?? '');
        $sectionName = trim($data['section_name'] ?? '');
        $contentType = trim($data['content_type'] ?? '');
        $minValue = (int) ($data['min_value'] ?? 0);
        $maxValue = !empty($data['max_value']) ? (int) $data['max_value'] : null;
        $price = (float) ($data['price'] ?? 0);
        $type = trim($data['type'] ?? '');

        // Validate required fields
        if (empty($sourceName) || $price <= 0 || empty($type)) {
            return 'skipped';
        }

        // Validate type
        $validTypes = ['social', 'internet', 'radio', 'tv', 'print'];
        if (!in_array($type, $validTypes)) {
            return 'skipped';
        }

        $sourceId = null;
        $sectionId = null;
        $socialNetworkId = null;

        // For social media rates
        if ($type === 'social') {
            $socialNetwork = SocialNetworks::firstOrCreate(
                ['name' => $sourceName],
                ['name' => $sourceName]
            );
            $socialNetworkId = $socialNetwork->id;
        } else {
            // For internet/radio/tv/print, try to find the source
            $source = Source::where('name', $sourceName)->first();
            $sourceId = $source?->id;

            // If section is provided, try to find it
            if (!empty($sectionName) && $source) {
                $section = $source->sections()->where('name', $sectionName)->first();
                $sectionId = $section?->id;
            }
        }

        // Build the unique key for updateOrCreate
        $uniqueKey = [
            'type' => $type,
            'min_value' => $minValue,
        ];

        if ($socialNetworkId) {
            $uniqueKey['social_network_id'] = $socialNetworkId;
            $uniqueKey['content_type'] = $contentType ?: null;
        } else {
            $uniqueKey['source_id'] = $sourceId;
            $uniqueKey['section_id'] = $sectionId;
        }

        // Check if record exists
        $exists = Rate::where($uniqueKey)->exists();

        // Create or update
        Rate::updateOrCreate(
            $uniqueKey,
            [
                'max_value' => $maxValue,
                'price' => $price,
                'metadata' => [
                    'source_name' => $sourceName,
                    'section_name' => $sectionName,
                    'imported_at' => now()->toDateTimeString(),
                ],
            ]
        );

        return $exists ? 'updated' : 'imported';
    }

    /**
     * Download a sample CSV template.
     */
    public function downloadTemplate(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $templatePath = base_path('tarifario/master_tarifario_opemedios.csv');

        if (!file_exists($templatePath)) {
            abort(404, 'Plantilla no encontrada');
        }

        return response()->download($templatePath, 'plantilla_tarifas.csv');
    }
}
