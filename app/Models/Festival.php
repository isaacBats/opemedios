<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Festival extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $fillable = ['name', 'description', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function means()
    {
        return $this->belongsToMany(Means::class, 'festival_means', 'festival_id', 'mean_id');
    }
}
