<?php

namespace App;

use App\AssignedNews;
use App\AuthorType;
use App\File;
use App\Genre;
use App\Means;
use App\NewsletterThemeNews;
use App\Section;
use App\Sector;
use App\Source;
use App\TypePage;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class News extends Model
{
    protected $fillable = ['title', 'synthesis', 'author', 'author_type_id', 'sector_id', 'genre_id', 'source_id', 'section_id', 'mean_id', 'news_date', 'cost', 'trend', 'scope', 'comments', 'in_newsletter', 'metas_news', 'user_id']; 

    protected $dates = [
        'news_date'
    ];

    public function source () {
        return $this->belongsTo(Source::class);
    }

    public function authorType() {
        return $this->belongsTo(AuthorType::class);
    }

    public function sector() {
        return $this->belongsTo(Sector::class);
    }

    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }

    public function mean() {
        return $this->belongsTo(Means::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function metas() {
        
        $fmt = numfmt_create('es_MX', \NumberFormatter::CURRENCY);
        $fmtn = numfmt_create('es_MX', \NumberFormatter::DECIMAL);
        $trend = $this->trend == 1 ? 'Positiva' : ($this->trend == 2 ? 'Neutral' : 'Negativa');

        $news_metas = unserialize($this->metas_news);

        $array_metas = [
            ['label' => 'Encabezado', 'value' => $this->title],
            ['label' => 'Síntesis', 'value' => $this->synthesis],
            ['label' => 'Autor', 'value' => $this->author],
            ['label' => 'Tipo de autor', 'value' => $this->authorType->description],
            ['label' => 'Fecha', 'value' => Carbon::parse($this->news_date)->formatLocalized('%A %d de %B %Y')],
            ['label' => 'Sector', 'value' => $this->sector()->withTrashed()->where('id', $this->sector_id)->first()->name],
            ['label' => 'Genero', 'value' => $this->genre->description],
            ['label' => 'Fuente', 'value' => $this->source()->withTrashed()->where('id', $this->source_id)->first()->name],
            ['label' => 'Sección', 'value' => $this->section()->withTrashed()->where('id', $this->section_id)->first()->name],
            ['label' => 'Medio', 'value' => $this->mean()->withTrashed()->where('id', $this->mean_id)->first()->name],
            ['label' => 'Costo', 'value' => numfmt_format($fmt, $this->cost)],
            ['label' => 'Alcance', 'value' => numfmt_format($fmtn, $this->scope)],
            ['label' => 'Tendencia', 'value' => $trend],
            ['label' => 'Comentarios', 'value' => $this->comments],
            ['label' => 'Creador', 'value' => $this->user->name],
        ];

        if($this->mean->short_name == 'tel' || $this->mean->short_name == 'rad') {
            array_push($array_metas,
                ['label' => 'Hora', 'value' => $news_metas['news_hour']],
                ['label' => 'Duración', 'value' => $news_metas['news_duration']]
            );
        } elseif ($this->mean->short_name == 'per' || $this->mean->short_name == 'rev') {
            
            $pageType = TypePage::find($news_metas['page_type_id']);

            array_push($array_metas, 
                ['label' => 'Tipo de página', 'value' => $pageType->description],
                ['label' => 'Número de página', 'value' => $news_metas['page_number']],
                ['label' => 'Tamaño de página', 'value' => $news_metas['page_size']]
            );
        } elseif ($this->mean->short_name == 'int') {
            array_push($array_metas, 
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

    public function newsletters() {
        return $this->hasMany(NewsletterThemeNews::class);
    }

    public function assignedNews() {
        return $this->hasMany(AssignedNews::class);
    }

    public function isAssigned() {
        if($this->assignedNews->count() > 0) {
            return true;
        }

        return false;
    }

    public static function latestNews($limit = 10) {
        return News::latest()->limit($limit)->get();
    }

    public function scopeSearchBy($query, $type, $value) {
        if(($type) && ($value)) {
            return $query->where($type, 'like', "%{$value}%");
        }
    }
}
