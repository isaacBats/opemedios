<?php

namespace App;

use App\Newsletter;
use App\Turn;
use App\UserMeta;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'slug', 'logo', 'turn_id' ];

    public function turn () {

        return $this->belongsTo(Turn::class);

    }

    public function newsletters() {

        return $this->hasMany(Newsletter::class);
    }

    public function accounts() {
        $usersIds = UserMeta::where([
            ['meta_key', '=', 'company_id'],
            ['meta_value', '=', $this->id]
        ])->get()->map(function ($meta) {
            return $meta->user_id;
        });

        return User::whereIn('id', $usersIds)->get();
    }

    public function emailsNewsLetters() {
        $users = $this->accounts();
        $emails = array();
        foreach ($users as $user) {
            if($user->metas()->where([
                ['meta_key', '=', 'user_newsletter'], 
                ['meta_value', '=', 1],
            ])->first()) {
                $emails[] = $user->email;
            }
        }
        
        return $emails;
    }

    public function getOldCompanyId() {
        $users = $this->accounts();
        $companyOld = false;
        foreach ($users as $user) {
            if($meta = $user->metas()->where('meta_key', 'old_company_id')->first()) {
                $companyOld = $meta->meta_value;
                break;
            }
        }

        return $companyOld;
    }
}
