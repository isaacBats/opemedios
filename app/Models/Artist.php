<?php

namespace App\Models;

use App\{App\Models\Company, App\Models\User, Models};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $fillable = ['name', 'description', 'company_id'];
    
    public function company()
    {
        return $this->belongsTo(Models\Company::class);
    }
}
