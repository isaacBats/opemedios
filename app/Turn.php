<?php

namespace App;

use App\Company;
use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    protected $fillable = ['name', 'description',];

    public function companies () {
        return $this->hasMany(Company::class);
    }
}
