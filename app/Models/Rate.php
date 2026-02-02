<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_SOCIAL = 'social';
    public const TYPE_INTERNET = 'internet';
    public const TYPE_RADIO = 'radio';
    public const TYPE_TV = 'tv';
    public const TYPE_PRINT = 'print';

    public const CONTENT_POST = 'post';
    public const CONTENT_STORY = 'story';
    public const CONTENT_REEL = 'reel';
    public const CONTENT_VIDEO = 'video';

    protected $fillable = [
        'source_id',
        'section_id',
        'social_network_id',
        'content_type',
        'min_value',
        'max_value',
        'price',
        'type',
        'metadata',
    ];

    protected $casts = [
        'min_value' => 'integer',
        'max_value' => 'integer',
        'price' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * @return BelongsTo<Source, Rate>
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * @return BelongsTo<Section, Rate>
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @return BelongsTo<SocialNetworks, Rate>
     */
    public function socialNetwork(): BelongsTo
    {
        return $this->belongsTo(SocialNetworks::class);
    }

    /**
     * Get available rate types.
     *
     * @return array<string, string>
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_SOCIAL => 'Redes Sociales',
            self::TYPE_INTERNET => 'Internet',
            self::TYPE_RADIO => 'Radio',
            self::TYPE_TV => 'Televisión',
            self::TYPE_PRINT => 'Impreso',
        ];
    }

    /**
     * Get available content types for social media.
     *
     * @return array<string, string>
     */
    public static function getContentTypes(): array
    {
        return [
            self::CONTENT_POST => 'Post',
            self::CONTENT_STORY => 'Story',
            self::CONTENT_REEL => 'Reel',
            self::CONTENT_VIDEO => 'Video',
        ];
    }

    /**
     * Scope to filter by type.
     *
     * @param \Illuminate\Database\Eloquent\Builder<Rate> $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder<Rate>
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to find rate by value within range.
     *
     * @param \Illuminate\Database\Eloquent\Builder<Rate> $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder<Rate>
     */
    public function scopeInRange($query, int $value)
    {
        return $query->where('min_value', '<=', $value)
            ->where(function ($q) use ($value) {
                $q->whereNull('max_value')
                    ->orWhere('max_value', '>=', $value);
            });
    }

    /**
     * Check if a value falls within this rate's range.
     */
    public function isInRange(int $value): bool
    {
        if ($value < $this->min_value) {
            return false;
        }

        if ($this->max_value !== null && $value > $this->max_value) {
            return false;
        }

        return true;
    }
}
