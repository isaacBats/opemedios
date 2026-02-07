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

            // Store skip reasons in session if any
            if (!empty($result['skip_reasons'])) {
                $reasonsPreview = array_slice($result['skip_reasons'], 0, 10);
                $remaining = count($result['skip_reasons']) - 10;

                $skipMessage = implode(' | ', $reasonsPreview);
                if ($remaining > 0) {
                    $skipMessage .= " (y {$remaining} más...)";
                }

                return redirect()->route('rates')
                    ->with('status', $message)
                    ->with('warning', 'Razones de omisión: ' . $skipMessage);
            }

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
     * @return array{imported: int, updated: int, skipped: int, skip_reasons: array<string>}
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
        $skipReasons = [];

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
                    $skipReasons[] = "Línea {$lineNumber}: Columnas insuficientes";
                    continue;
                }

                $data = array_combine($header, $row);
                $result = $this->processRow($data, $lineNumber);

                if ($result['status'] === 'imported') {
                    $imported++;
                } elseif ($result['status'] === 'updated') {
                    $updated++;
                } else {
                    $skipped++;
                    if ($result['reason']) {
                        $skipReasons[] = $result['reason'];
                    }
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
            'skip_reasons' => $skipReasons,
        ];
    }

    /**
     * Process a single row from the CSV.
     *
     * @return array{status: string, reason: string|null}
     */
    private function processRow(array $data, int $lineNumber): array
    {
        $sourceName = trim($data['source_name'] ?? '');
        $sectionName = trim($data['section_name'] ?? '');
        $contentType = trim($data['content_type'] ?? '');
        $minValue = (int) ($data['min_value'] ?? 0);
        $maxValue = !empty($data['max_value']) ? (int) $data['max_value'] : null;
        $price = (float) ($data['price'] ?? 0);
        $type = trim($data['type'] ?? '');

        // Validate required fields
        if (empty($sourceName)) {
            return ['status' => 'skipped', 'reason' => "Línea {$lineNumber}: Nombre de fuente vacío"];
        }

        if ($price <= 0) {
            return ['status' => 'skipped', 'reason' => "Línea {$lineNumber}: Precio inválido ({$price})"];
        }

        if (empty($type)) {
            return ['status' => 'skipped', 'reason' => "Línea {$lineNumber}: Tipo vacío"];
        }

        // Validate type
        $validTypes = ['social', 'internet', 'radio', 'tv', 'print'];
        if (!in_array($type, $validTypes)) {
            return ['status' => 'skipped', 'reason' => "Línea {$lineNumber}: Tipo inválido '{$type}'"];
        }

        // Validate min_value <= max_value
        if ($maxValue !== null && $minValue > $maxValue) {
            return ['status' => 'skipped', 'reason' => "Línea {$lineNumber}: min_value ({$minValue}) > max_value ({$maxValue})"];
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

        return ['status' => $exists ? 'updated' : 'imported', 'reason' => null];
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

    /**
     * Generate and download a dynamic CSV template with current source-section combinations.
     */
    public function downloadDynamicTemplate(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'plantilla_tarifas_dinamica_' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($handle, [
                'source_name',
                'section_name',
                'content_type',
                'min_value',
                'max_value',
                'price',
                'type',
            ]);

            // Get all sources with their sections, grouped by mean type
            $sources = Source::with(['sections', 'mean'])
                ->where('status', 1)
                ->orderBy('name')
                ->get();

            foreach ($sources as $source) {
                // Determine rate type based on mean
                $rateType = match ($source->mean?->id) {
                    1 => 'tv',
                    2 => 'radio',
                    3, 4 => 'print',
                    5 => 'internet',
                    default => 'internet',
                };

                // If source has sections, create row for each section
                if ($source->sections->isNotEmpty()) {
                    foreach ($source->sections as $section) {
                        // Check if rate already exists
                        $existingRate = Rate::where('source_id', $source->id)
                            ->where('section_id', $section->id)
                            ->first();

                        fputcsv($handle, [
                            $source->name,
                            $section->name,
                            '', // content_type
                            $existingRate?->min_value ?? 0,
                            $existingRate?->max_value ?? '',
                            $existingRate?->price ?? '',
                            $rateType,
                        ]);
                    }
                } else {
                    // No sections, create row for source only
                    $existingRate = Rate::where('source_id', $source->id)
                        ->whereNull('section_id')
                        ->first();

                    fputcsv($handle, [
                        $source->name,
                        '',
                        '',
                        $existingRate?->min_value ?? 0,
                        $existingRate?->max_value ?? '',
                        $existingRate?->price ?? '',
                        $rateType,
                    ]);
                }
            }

            // Add social networks
            $socialNetworks = SocialNetworks::orderBy('name')->get();
            $contentTypes = ['post', 'story', 'reel', 'video'];

            foreach ($socialNetworks as $network) {
                foreach ($contentTypes as $contentType) {
                    $existingRate = Rate::where('social_network_id', $network->id)
                        ->where('content_type', $contentType)
                        ->first();

                    fputcsv($handle, [
                        $network->name,
                        '',
                        $contentType,
                        $existingRate?->min_value ?? 0,
                        $existingRate?->max_value ?? '',
                        $existingRate?->price ?? '',
                        'social',
                    ]);
                }
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
