<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListReport extends Model
{
    protected $table = 'list_reports';

    protected $fillable = [
        'name_file',
        'start_date',
        'end_date',
        'company',
        'theme_id',
        'sector',
        'genre',
        'mean',
        'source_id',
        'word',
        'user_id',
        'status',
        'size',
    ];

    protected $casts = [
        'theme_id' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Status constants
     */
    public const STATUS_PENDING = 0;
    public const STATUS_GENERATED = 1;
    public const STATUS_DOWNLOADED = 2;
    public const STATUS_PROCESSING = 3;

    /**
     * Size constants
     */
    public const SIZE_SMALL = 'small';
    public const SIZE_MEDIUM = 'medium';
    public const SIZE_BIG = 'big';

    /**
     * Get the user that owns the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the company that owns the report.
     */
    public function companyRelation(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company');
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_GENERATED => 'Generado',
            self::STATUS_DOWNLOADED => 'Descargado',
            self::STATUS_PROCESSING => 'Procesando',
            default => 'Desconocido',
        };
    }

    /**
     * Get status badge class for UI.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_GENERATED => 'success',
            self::STATUS_DOWNLOADED => 'info',
            self::STATUS_PROCESSING => 'primary',
            default => 'secondary',
        };
    }

    /**
     * Check if report is ready for download.
     */
    public function isReadyForDownload(): bool
    {
        return $this->status === self::STATUS_GENERATED;
    }
}
