<?php

namespace App;

use App\Newsletter;
use App\Turn;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'slug', 'logo', 'turn_id' ];

    public function turn () {

        return $this->belongsTo(Turn::class);

    }

    public function newsletters() {

        return $this->hasMany(Newsletter::class);
    }
}
