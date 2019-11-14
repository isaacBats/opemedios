<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_meta';

    protected $fillable = [
        'meta_key', 'meta_value',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
