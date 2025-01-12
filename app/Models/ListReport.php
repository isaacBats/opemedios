<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListReport extends Model
{
    protected $table = 'list_reports';
    protected $casts = [
        'theme_id' => 'array',
    ];
}
