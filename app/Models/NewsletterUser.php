<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterUser extends Model
{
    use SoftDeletes;

    protected $fillable = ['newsletter_id', 'email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function newsletter()
    {

        return $this->belongsTo(Newsletter::class);
    }
}
