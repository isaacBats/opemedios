<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Rate;
use App\Models\Source;

class CostCalculatorService
{
    /**
     * Calculate cost for social media content.
     *
     * @param int $socialNetworkId Social network ID
     * @param string|null $contentType Content type (post, story, reel, video)
     * @param int $followers Number of followers
     * @return array{success: bool, price?: float, rate_id?: int, message?: string}
     */
    public function calculateSocialCost(int $socialNetworkId, ?string $contentType, int $followers): array
    {
        $query = Rate::where('social_network_id', $socialNetworkId)
            ->where('type', Rate::TYPE_SOCIAL)
            ->inRange($followers);

        if ($contentType) {
            $query->where('content_type', $contentType);
        }

        $rate = $query->first();

        if ($rate) {
            return [
                'success' => true,
                'price' => (float) $rate->price,
                'rate_id' => $rate->id,
            ];
        }

        return [
            'success' => false,
            'message' => 'No se encontró una tarifa para esta red social y número de seguidores.',
        ];
    }

    /**
     * Calculate cost for internet portal.
     *
     * @param int $sourceId Source (portal) ID
     * @return array{success: bool, price?: float, rate_id?: int, message?: string}
     */
    public function calculateInternetCost(int $sourceId): array
    {
        $rate = Rate::where('source_id', $sourceId)
            ->where('type', Rate::TYPE_INTERNET)
            ->first();

        if ($rate) {
            return [
                'success' => true,
                'price' => (float) $rate->price,
                'rate_id' => $rate->id,
            ];
        }

        return [
            'success' => false,
            'message' => 'No se encontró una tarifa para este portal.',
        ];
    }

    /**
     * Calculate cost for radio/TV.
     *
     * @param int $sourceId Source (program) ID
     * @param int|null $sectionId Section ID
     * @param string $type Rate type (radio or tv)
     * @return array{success: bool, price?: float, rate_id?: int, message?: string}
     */
    public function calculateBroadcastCost(int $sourceId, ?int $sectionId, string $type): array
    {
        $query = Rate::where('source_id', $sourceId)
            ->where('type', $type);

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        $rate = $query->first();

        if ($rate) {
            return [
                'success' => true,
                'price' => (float) $rate->price,
                'rate_id' => $rate->id,
                'metadata' => $rate->metadata,
            ];
        }

        return [
            'success' => false,
            'message' => 'No se encontró una tarifa para esta fuente.',
        ];
    }

    /**
     * Calculate cost based on source and mean type.
     *
     * @param int $sourceId Source ID
     * @param int|null $sectionId Section ID
     * @param int|null $socialNetworkId Social network ID (for mean=5 internet/social)
     * @param string|null $contentType Content type for social media
     * @param int|null $value Followers/visits/audience value
     * @return array{success: bool, price?: float, rate_id?: int, message?: string}
     */
    public function calculateCostBySource(
        int $sourceId,
        ?int $sectionId = null,
        ?int $socialNetworkId = null,
        ?string $contentType = null,
        ?int $value = null
    ): array {
        // If social network is provided, use social calculation
        if ($socialNetworkId && $value) {
            return $this->calculateSocialCost($socialNetworkId, $contentType, $value);
        }

        // Get source to determine the mean type
        $source = Source::with('mean')->find($sourceId);

        if (!$source) {
            return [
                'success' => false,
                'message' => 'Fuente no encontrada.',
            ];
        }

        $meanId = $source->mean?->id;

        return match ($meanId) {
            1 => $this->calculateBroadcastCost($sourceId, $sectionId, Rate::TYPE_TV),
            2 => $this->calculateBroadcastCost($sourceId, $sectionId, Rate::TYPE_RADIO),
            3, 4 => $this->calculatePrintCost($sourceId, $sectionId),
            5 => $this->calculateInternetCost($sourceId),
            default => [
                'success' => false,
                'message' => 'Tipo de medio no soportado.',
            ],
        };
    }

    /**
     * Calculate cost for print media (newspaper/magazine).
     *
     * @param int $sourceId Source ID
     * @param int|null $sectionId Section ID
     * @return array{success: bool, price?: float, rate_id?: int, message?: string}
     */
    public function calculatePrintCost(int $sourceId, ?int $sectionId): array
    {
        $query = Rate::where('source_id', $sourceId)
            ->where('type', Rate::TYPE_PRINT);

        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        $rate = $query->first();

        if ($rate) {
            return [
                'success' => true,
                'price' => (float) $rate->price,
                'rate_id' => $rate->id,
            ];
        }

        return [
            'success' => false,
            'message' => 'No se encontró una tarifa para este medio impreso.',
        ];
    }

    /**
     * Get all rates for a specific source.
     *
     * @param int $sourceId Source ID
     * @return \Illuminate\Database\Eloquent\Collection<int, Rate>
     */
    public function getRatesForSource(int $sourceId)
    {
        return Rate::where('source_id', $sourceId)
            ->orderBy('min_value')
            ->get();
    }

    /**
     * Get all rates for a specific social network.
     *
     * @param int $socialNetworkId Social network ID
     * @param string|null $contentType Content type filter
     * @return \Illuminate\Database\Eloquent\Collection<int, Rate>
     */
    public function getRatesForSocialNetwork(int $socialNetworkId, ?string $contentType = null)
    {
        $query = Rate::where('social_network_id', $socialNetworkId)
            ->where('type', Rate::TYPE_SOCIAL);

        if ($contentType) {
            $query->where('content_type', $contentType);
        }

        return $query->orderBy('min_value')->get();
    }
}
