<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\SocialNetworks;
use App\Models\Source;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class RateController extends Controller
{
    public function index(Request $request): View
    {
        $paginate = $request->input('paginate', 25);

        $breadcrumb = [
            ['label' => 'Tarifas'],
        ];

        $rates = Rate::with(['source', 'section', 'socialNetwork'])
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('source_id'), fn ($q) => $q->where('source_id', $request->source_id))
            ->when($request->filled('social_network_id'), fn ($q) => $q->where('social_network_id', $request->social_network_id))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function ($query) use ($search) {
                    $query->whereHas('source', fn ($sq) => $sq->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('socialNetwork', fn ($sq) => $sq->where('name', 'like', "%{$search}%"))
                        ->orWhere('metadata->source_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($paginate)
            ->appends($request->only(['type', 'source_id', 'social_network_id', 'search', 'paginate']));

        $types = Rate::getTypes();
        $socialNetworks = SocialNetworks::orderBy('name')->get();

        return view('admin.rates.index', compact('rates', 'paginate', 'breadcrumb', 'types', 'socialNetworks'));
    }

    public function showForm(): View
    {
        $breadcrumb = [
            ['label' => 'Tarifas', 'url' => route('rates')],
            ['label' => 'Nueva Tarifa'],
        ];

        $types = Rate::getTypes();
        $contentTypes = Rate::getContentTypes();
        $socialNetworks = SocialNetworks::orderBy('name')->get();

        return view('admin.rates.create', compact('breadcrumb', 'types', 'contentTypes', 'socialNetworks'));
    }

    public function create(Request $request): RedirectResponse
    {
        $inputs = $request->all();

        Validator::make($inputs, [
            'type' => 'required|in:social,internet,radio,tv,print',
            'price' => 'required|numeric|min:0',
            'min_value' => 'required|integer|min:0',
            'max_value' => 'nullable|integer|min:0|gte:min_value',
        ], [
            'type.required' => 'El tipo de tarifa es requerido.',
            'price.required' => 'El precio es requerido.',
            'min_value.required' => 'El valor mínimo es requerido.',
            'max_value.gte' => 'El valor máximo debe ser mayor o igual al mínimo.',
        ])->validate();

        Rate::create([
            'source_id' => $inputs['source_id'] ?? null,
            'section_id' => $inputs['section_id'] ?? null,
            'social_network_id' => $inputs['social_network_id'] ?? null,
            'content_type' => $inputs['content_type'] ?? null,
            'min_value' => $inputs['min_value'],
            'max_value' => $inputs['max_value'] ?? null,
            'price' => $inputs['price'],
            'type' => $inputs['type'],
            'metadata' => $inputs['metadata'] ?? null,
        ]);

        return redirect()->route('rates')->with('status', '¡Éxito! La tarifa se ha creado correctamente.');
    }

    public function show(int $id): View
    {
        $rate = Rate::with(['source', 'section', 'socialNetwork'])->findOrFail($id);

        $breadcrumb = [
            ['label' => 'Tarifas', 'url' => route('rates')],
            ['label' => "Tarifa #{$rate->id}"],
        ];

        $types = Rate::getTypes();
        $contentTypes = Rate::getContentTypes();
        $socialNetworks = SocialNetworks::orderBy('name')->get();

        return view('admin.rates.show', compact('rate', 'breadcrumb', 'types', 'contentTypes', 'socialNetworks'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $rate = Rate::findOrFail($id);
        $inputs = $request->all();

        Validator::make($inputs, [
            'type' => 'required|in:social,internet,radio,tv,print',
            'price' => 'required|numeric|min:0',
            'min_value' => 'required|integer|min:0',
            'max_value' => 'nullable|integer|min:0|gte:min_value',
        ])->validate();

        $rate->update([
            'source_id' => $inputs['source_id'] ?? null,
            'section_id' => $inputs['section_id'] ?? null,
            'social_network_id' => $inputs['social_network_id'] ?? null,
            'content_type' => $inputs['content_type'] ?? null,
            'min_value' => $inputs['min_value'],
            'max_value' => $inputs['max_value'] ?? null,
            'price' => $inputs['price'],
            'type' => $inputs['type'],
            'metadata' => $inputs['metadata'] ?? null,
        ]);

        return redirect()->route('rate.show', ['id' => $rate->id])
            ->with('status', '¡Éxito! La tarifa se ha actualizado correctamente.');
    }

    public function delete(int $id): RedirectResponse
    {
        $rate = Rate::findOrFail($id);
        $rate->delete();

        return redirect()->route('rates')->with('status', '¡La tarifa se ha eliminado satisfactoriamente!');
    }

    public function showImportForm(): View
    {
        $breadcrumb = [
            ['label' => 'Tarifas', 'url' => route('rates')],
            ['label' => 'Importar CSV'],
        ];

        $types = Rate::getTypes();

        return view('admin.rates.import', compact('breadcrumb', 'types'));
    }

    public function import(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
            'import_type' => 'required|in:social,internet,radio',
        ], [
            'csv_file.required' => 'El archivo CSV es requerido.',
            'csv_file.mimes' => 'El archivo debe ser un CSV.',
            'import_type.required' => 'El tipo de importación es requerido.',
        ])->validate();

        $file = $request->file('csv_file');
        $type = $request->input('import_type');
        $socialNetworkId = $request->input('social_network_id');
        $contentType = $request->input('content_type');

        try {
            $imported = $this->processCSV($file->getPathname(), $type, $socialNetworkId, $contentType);

            return redirect()->route('rates')
                ->with('status', "¡Éxito! Se importaron {$imported} tarifas correctamente.");
        } catch (\Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }

    private function processCSV(string $path, string $type, ?int $socialNetworkId = null, ?string $contentType = null): int
    {
        $handle = fopen($path, 'r');
        if ($handle === false) {
            throw new \RuntimeException('No se pudo abrir el archivo CSV');
        }

        $imported = 0;

        DB::beginTransaction();

        try {
            // Skip header rows for social media files
            if ($type === 'social') {
                $imported = $this->importSocialRates($handle, $socialNetworkId, $contentType);
            } elseif ($type === 'internet') {
                $imported = $this->importInternetRates($handle);
            } elseif ($type === 'radio') {
                $imported = $this->importRadioRates($handle);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            fclose($handle);
        }

        return $imported;
    }

    private function importSocialRates($handle, ?int $socialNetworkId, ?string $contentType): int
    {
        $imported = 0;

        // Skip first 4-5 header rows
        for ($i = 0; $i < 5; $i++) {
            fgetcsv($handle);
        }

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row[1]) || !str_contains($row[1], ' a ')) {
                continue;
            }

            $range = $this->parseRange($row[1]);
            if ($range === null) {
                continue;
            }

            $price = $this->parsePrice($row[3] ?? '0');
            if ($price <= 0) {
                continue;
            }

            Rate::updateOrCreate(
                [
                    'social_network_id' => $socialNetworkId,
                    'content_type' => $contentType,
                    'min_value' => $range['min'],
                    'max_value' => $range['max'],
                    'type' => Rate::TYPE_SOCIAL,
                ],
                [
                    'price' => $price,
                ]
            );

            $imported++;
        }

        return $imported;
    }

    private function importInternetRates($handle): int
    {
        $imported = 0;

        // Skip header row
        fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $portalName = trim($row[0] ?? '');
            if (empty($portalName)) {
                continue;
            }

            $visits = $this->parseNumber($row[1] ?? '0');
            $price = $this->parsePrice($row[2] ?? '0');
            $url = trim($row[3] ?? '');

            if ($price <= 0) {
                continue;
            }

            // Find or create source by name
            $source = Source::where('name', 'like', "%{$portalName}%")
                ->where('means_id', 5) // Internet
                ->first();

            Rate::updateOrCreate(
                [
                    'source_id' => $source?->id,
                    'min_value' => $visits,
                    'type' => Rate::TYPE_INTERNET,
                ],
                [
                    'price' => $price,
                    'metadata' => ['url' => $url, 'portal_name' => $portalName],
                ]
            );

            $imported++;
        }

        return $imported;
    }

    private function importRadioRates($handle): int
    {
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $programName = trim($row[1] ?? '');
            if (empty($programName)) {
                continue;
            }

            $audience = $this->parseNumber($row[2] ?? '0');

            // Find source by name
            $source = Source::where('name', 'like', "%{$programName}%")
                ->where('means_id', 2) // Radio
                ->first();

            // Parse different spot durations (columns may vary)
            $spotPrices = [];
            for ($i = 5; $i <= 10; $i++) {
                $price = $this->parsePrice($row[$i] ?? '0');
                if ($price > 0) {
                    $spotPrices[] = $price;
                }
            }

            if (empty($spotPrices)) {
                continue;
            }

            // Use the first valid price as the base rate
            Rate::updateOrCreate(
                [
                    'source_id' => $source?->id,
                    'min_value' => $audience,
                    'type' => Rate::TYPE_RADIO,
                ],
                [
                    'price' => $spotPrices[0],
                    'metadata' => [
                        'program_name' => $programName,
                        'spot_prices' => $spotPrices,
                    ],
                ]
            );

            $imported++;
        }

        return $imported;
    }

    private function parseRange(string $rangeStr): ?array
    {
        // Clean the string
        $rangeStr = str_replace([',', ' '], ['', ''], $rangeStr);

        // Handle special cases like "1M", "2M"
        if (preg_match('/^(\d+)M$/i', $rangeStr, $matches)) {
            $millions = (int) $matches[1];

            return [
                'min' => $millions * 1_000_000,
                'max' => ($millions + 1) * 1_000_000 - 1,
            ];
        }

        // Handle ranges like "200a500" or "200 a 500"
        if (preg_match('/(\d+)a(\d+)/i', $rangeStr, $matches)) {
            return [
                'min' => (int) $matches[1],
                'max' => (int) $matches[2],
            ];
        }

        return null;
    }

    private function parsePrice(string $priceStr): float
    {
        // Remove currency symbols, spaces, and thousands separators
        $priceStr = preg_replace('/[^\d.,]/', '', $priceStr);
        $priceStr = str_replace(',', '', $priceStr);

        return (float) $priceStr;
    }

    private function parseNumber(string $numStr): int
    {
        $numStr = str_replace([',', ' '], '', $numStr);

        return (int) $numStr;
    }

    /**
     * API endpoint to lookup rate by criteria.
     */
    public function lookup(Request $request): JsonResponse
    {
        $sourceId = $request->input('source_id');
        $sectionId = $request->input('section_id');
        $socialNetworkId = $request->input('social_network_id');
        $contentType = $request->input('content_type');
        $value = (int) $request->input('value', 0); // followers, visits, audience

        $query = Rate::query();

        // For social media
        if ($socialNetworkId) {
            $query->where('social_network_id', $socialNetworkId)
                ->where('type', Rate::TYPE_SOCIAL);

            if ($contentType) {
                $query->where('content_type', $contentType);
            }

            if ($value > 0) {
                $query->inRange($value);
            }
        }
        // For internet/radio/tv by source
        elseif ($sourceId) {
            $source = Source::with('mean')->find($sourceId);

            if ($source) {
                $query->where('source_id', $sourceId);

                // Determine type based on mean
                $meanType = match ($source->mean?->id) {
                    1 => Rate::TYPE_TV,
                    2 => Rate::TYPE_RADIO,
                    3, 4 => Rate::TYPE_PRINT,
                    5 => Rate::TYPE_INTERNET,
                    default => null,
                };

                if ($meanType) {
                    $query->where('type', $meanType);
                }

                if ($sectionId) {
                    $query->where('section_id', $sectionId);
                }
            }
        }

        $rate = $query->first();

        if ($rate) {
            return response()->json([
                'success' => true,
                'price' => $rate->price,
                'max_value' => $rate->max_value,
                'min_value' => $rate->min_value,
                'rate_id' => $rate->id,
                'type' => $rate->type,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se encontró una tarifa para los criterios especificados.',
        ]);
    }
}
