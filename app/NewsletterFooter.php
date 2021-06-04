<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterFooter extends Model
{
    protected $table = 'newsletter_footer';
    
    protected $fillable = ['urls'];
}
