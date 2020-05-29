<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'synthesis', 'author', 'author_type_id', 'sector_id', 'genre_id', 'source_id', 'section_id', 'mean_id', 'news_date', 'cost', 'trend', 'scope', 'comments', 'in_newsletter', 'metas_news']; 
}
