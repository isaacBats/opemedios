<?php

namespace App;

use App\Company;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['name', 'description', 'company_id'];

    public function company () {

        return $this->belongsTo(Company::class);
    }
}
