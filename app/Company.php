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

use App\AssignedNews;
use App\Newsletter;
use App\Theme;
use App\Turn;
use App\UserMeta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Company extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'slug', 'logo', 'turn_id' ];

    public function turn () {

        return $this->belongsTo(Turn::class);

    }

    public function newsletter() {

        return $this->hasOne(Newsletter::class);
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

    public function themes() {

        return $this->hasMany(Theme::class);
    }

    public function oldCompany() {

        if(!empty($this->old_company_id)) {

            return DB::connection('opemediosold')->table('empresa')
                ->where('id_empresa', $this->old_company_id)->first();
        }

        return false;
    }

    public function assignedNews() {
        return $this->hasMany(AssignedNews::class);
    }

    public function scopeName($query, $name) {
      if($name) {
        return $query->where('name', 'like', "%{$name}%");
      }
    }

    public function scopeTurn($query, $turn) {
      if($turn) {
        return $query->where('turn_id', $turn);
      }
    }
}
