<?php

namespace App;

use App\Source;
use Illuminate\Database\Eloquent\Model;

class Cover extends Model
{
    protected $fillable = ['cover_type','title','author','date_cover','source_id','content','image'];

    protected $dates = ['date_cover'];

    public function source () {
        return $this->belongsTo(Source::class);
    }

    public function image () {
        return $this->belongsTo(File::class);
    }
}
