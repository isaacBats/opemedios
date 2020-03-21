<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'company', 'comment', 'logo', 'active', 'coverage', 'means_id'];
}
