<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address',
    ];

    public function users() {

        return $this->hasMany(User::class);
    }
}
