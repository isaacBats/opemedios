<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Rate;
use App\Models\SocialNetworks;
use App\Models\Source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RateSeeder extends Seeder
{
    private int $imported = 0;
    private int $updated = 0;
    private int $skipped = 0;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filepath = base_path('tarifario/master_tarifario_opemedios.csv');

        if (!file_exists($filepath)) {
            $this->command->error('Archivo no encontrado: tarifario/master_tarifario_opemedios.csv');
            return;
        }

        $this->command->info('Iniciando importación desde master_tarifario_opemedios.csv...');

        $handle = fopen($filepath, 'r');
        if ($handle === false) {
            $this->command->error('No se pudo abrir el archivo CSV');
            return;
        }

        DB::beginTransaction();

        try {
            // Read header row
            $header = fgetcsv($handle);
            $this->command->info('Columnas: ' . implode(', ', $header));

            $lineNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $lineNumber++;

                if (count($row) < 7) {
                    $this->skipped++;
                    continue;
                }

                $data = array_combine($header, $row);

                $this->processRow($data, $lineNumber);
            }

            DB::commit();

            $this->command->newLine();
            $this->command->info('=== Resumen de Importación ===');
            $this->command->info("✓ Nuevos registros: {$this->imported}");
            $this->command->info("✓ Actualizados: {$this->updated}");
            $this->command->warn("⚠ Saltados: {$this->skipped}");
            $this->command->info('Total procesados: ' . ($this->imported + $this->updated));

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error en línea: ' . $e->getMessage());
            Log::error('RateSeeder Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        } finally {
            fclose($handle);
        }
    }

    private function processRow(array $data, int $lineNumber): void
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
            $this->skipped++;
            return;
        }

        // Validate type
        $validTypes = ['social', 'internet', 'radio', 'tv', 'print'];
        if (!in_array($type, $validTypes)) {
            $this->skipped++;
            return;
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

        if ($exists) {
            $this->updated++;
        } else {
            $this->imported++;
        }

        // Progress indicator every 500 rows
        if (($this->imported + $this->updated) % 500 === 0) {
            $this->command->info("Procesados: " . ($this->imported + $this->updated) . " registros...");
        }
    }
}
