<?php

namespace App\Models;

use App\{App\Models\Company, App\Models\User, Models};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasksBoard extends Model
{
    use HasFactory;
    protected $table = 'tasks_board';

    public function company()
    {
        return $this->belongsTo(Models\Company::class);
    }

}
