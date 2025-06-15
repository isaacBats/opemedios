<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewspaperFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'newspaper',
        'date',
        'file'
    ];
}
