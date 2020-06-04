<?php

namespace App;

use App\AuthorType;
use App\File;
use App\Genre;
use App\Means;
use App\Section;
use App\Sector;
use App\Source;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'synthesis', 'author', 'author_type_id', 'sector_id', 'genre_id', 'source_id', 'section_id', 'mean_id', 'news_date', 'cost', 'trend', 'scope', 'comments', 'in_newsletter', 'metas_news']; 

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
}
