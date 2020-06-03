<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterThemeNews extends Model
{
    protected $fillable = ['newsletter_id', 'newsletter_theme_id', 'news_id'];

    protected $table = 'newsletter_themes_news';
}
