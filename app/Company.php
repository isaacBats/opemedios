<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2019
  * @version 1.0.0
  * @package App\
  * Type: Model
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App;

use App\{AssignedNews, News, Newsletter, Theme, Turn, UserMeta};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Support\Facades\DB;

class Company extends Model
{

    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'slug', 'logo', 'turn_id', 'parent', 'digital_properties' ];

    public function turn()
    {

        return $this->belongsTo(Turn::class);
    }

    public function newsletter()
    {

        return $this->hasOne(Newsletter::class);
    }

    public function accounts()
    {
        $usersIds = UserMeta::where([
            ['meta_key', '=', 'company_id'],
            ['meta_value', '=', $this->id]
        ])->get()->map(function ($meta) {
            return $meta->user_id;
        });

        return User::whereIn('id', $usersIds)->get();
    }

    public function emailsNewsLetters()
    {
        $users = $this->accounts();
        $emails = array();
        foreach ($users as $user) {
            if ($user->metas()->where([
                ['meta_key', '=', 'user_newsletter'],
                ['meta_value', '=', 1],
            ])->first()) {
                $emails[] = $user->email;
            }
        }

        return $emails;
    }

    public function themes()
    {

        return $this->hasMany(Theme::class);
    }

    public function assignedNews()
    {
        return $this->hasMany(AssignedNews::class);
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%{$name}%");
        }
    }

    public function scopeTurn($query, $turn)
    {
        if ($turn) {
            return $query->where('turn_id', $turn);
        }
    }

    public function executives()
    {
        return $this->belongsToMany(User::class, 'client_executive');
    }

    public function allAccountsOfACompany()
    {
        return $this->accounts()->merge($this->executives);
    }
}
