<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialNetworks extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = ['name', 'company', 'comment', 'logo', 'active', 'coverage', 'means_id'];
    
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%{$name}%");
        }
    }
}
