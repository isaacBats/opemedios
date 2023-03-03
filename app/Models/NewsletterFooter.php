<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterFooter extends Model
{
    protected $table = 'newsletter_footer';

    protected $fillable = ['urls'];
}
