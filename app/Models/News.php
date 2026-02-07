<?php

namespace App\Models;

use App\{App\Models\AssignedNews,
    App\Models\AuthorType,
    App\Models\File,
    App\Models\Genre,
    App\Models\Means,
    App\Models\NewsletterThemeNews,
    App\Models\Section,
    App\Models\Sector,
    App\Models\Source,
    App\Models\TypePage,
    App\Models\User,
    Models};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'synthesis', 'author', 'author_type_id', 'sector_id', 'genre_id', 'source_id', 'section_id', 'mean_id', 'news_date', 'cost', 'trend', 'scope', 'comments', 'in_newsletter', 'metas_news', 'user_id', 'social_network_id'];

    protected $casts = [
        'news_date' => 'datetime',
    ];

    public function source()
    {
        return $this->belongsTo(Models\Source::class);
    }

    public function authorType()
    {
        return $this->belongsTo(Models\AuthorType::class);
    }

    public function sector()
    {
        return $this->belongsTo(Models\Sector::class);
    }

    public function genre()
    {
        return $this->belongsTo(Models\Genre::class);
    }

    public function section()
    {
        return $this->belongsTo(Models\Section::class);
    }

    public function mean()
    {
        return $this->belongsTo(Models\Means::class);
    }

    public function files()
    {
        return $this->hasMany(Models\File::class);
    }

    public function user()
    {
        return $this->belongsTo(Models\User::class);
    }

    public function metas()
    {

        $fmt = numfmt_create('es_MX', \NumberFormatter::CURRENCY);
        $fmtn = numfmt_create('es_MX', \NumberFormatter::DECIMAL);
        $trend = $this->trend == 1 ? 'Positiva' : ($this->trend == 2 ? 'Neutral' : 'Negativa');

        $news_metas = unserialize($this->metas_news);

        $array_metas = [
            ['label' => 'Encabezado', 'value' => $this->title],
            ['label' => 'Síntesis', 'value' => $this->synthesis],
            ['label' => 'Autor', 'value' => $this->author],
            ['label' => 'Tipo de autor', 'value' => $this->authorType->description ?? 'N/E'],
            ['label' => 'Fecha', 'value' => Carbon::parse($this->news_date)->formatLocalized('%A %d de %B %Y')],
            ['label' => 'Sector', 'value' => $this->sector->name ?? 'N/E'],
            ['label' => 'Genero', 'value' => $this->genre->description ?? 'N/E'],
            ['label' => 'Fuente', 'value' => $this->source->name ?? 'N/E'],
            ['label' => 'Sección', 'value' => $this->section->name ?? 'N/E'],
            ['label' => 'Medio', 'value' => $this->mean->name ?? 'N/E'],
            ['label' => 'Costo', 'value' => numfmt_format($fmt, $this->cost)],
            ['label' => 'Alcance', 'value' => numfmt_format($fmtn, $this->scope)],
            ['label' => 'Tendencia', 'value' => $trend],
            ['label' => 'Comentarios', 'value' => $this->comments],
            ['label' => 'Creador', 'value' => $this->user->name ?? 'N/E'],
        ];

        if ($this->mean->short_name == 'tel' || $this->mean->short_name == 'rad') {
            array_push(
                $array_metas,
                ['label' => 'Hora', 'value' => $news_metas['news_hour']],
                ['label' => 'Duración', 'value' => $news_metas['news_duration']]
            );
        } elseif ($this->mean->short_name == 'per' || $this->mean->short_name == 'rev') {
            $pageType = Models\TypePage::find($news_metas['page_type_id']);

            array_push(
                $array_metas,
                ['label' => 'Tipo de página', 'value' => $pageType->description],
                ['label' => 'Número de página', 'value' => $news_metas['page_number']],
                ['label' => 'Tamaño de página', 'value' => $news_metas['page_size']]
            );
        } elseif ($this->mean->short_name == 'int') {
            array_push(
                $array_metas,
                ['label' => 'URL', 'value' => "<a href='{$news_metas['url']}' target='_blank'>{$news_metas['url']}</a>"],
                ['label' => 'Hora', 'value' => $news_metas['news_hour']]
            );
        }

        return $array_metas;
    }

    // public function getAttribute($attr) {
    //     return Arr::first($this->metas(), function($value, $key) use($attr) {
    //         return $value['label'] == $attr;
    //     });
    // }

    public function newsletters()
    {
        return $this->hasMany(Models\NewsletterThemeNews::class);
    }

    public function assignedNews()
    {
        return $this->hasMany(Models\AssignedNews::class);
    }

    public function isAssigned()
    {
        if ($this->assignedNews->count() > 0) {
            return true;
        }

        return false;
    }

    public static function latestNews($limit = 10)
    {
        return News::latest()->limit($limit)->get();
    }

    public function scopeSearchBy($query, $type, $value)
    {
        if (($type) && ($value)) {
            return $query->where($type, 'like', "%{$value}%");
        }
    }
}
