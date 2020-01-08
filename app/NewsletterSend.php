<?php

namespace App;

use App\Newsletter;
use Illuminate\Database\Eloquent\Model;

class NewsletterSend extends Model
{
    protected $fillable = ['newsletter_id', 'status', 'news_ids', 'num_notes', 'num_email'];

    protected $table = 'newsletters_send';

    public function newsletter() {

        return $this->belongsTo(Newsletter::class);
    }
}
