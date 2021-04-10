<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
  * @version 1.0.0
  * @package App\
  * Type: Model
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        
namespace App;

use App\Company;
use App\Theme;
use App\UserMeta;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function metas() {
        return $this->hasMany(UserMeta::class);
    }

    public function getMonitorType() {
        if($this->isMonitor()) {
            return  Means::find($this->metas->where('meta_key', 'user_monitor_type')->first()->meta_value)->first();
        }

        return false;
    }

    public function isMonitor() {
        if($this->hasRole('monitor')) {
            return true;
        }

        return false;
    }

    public function isClient() {
        if($this->hasRole('client')) {
            return true;
        }

        return false;
    }

    public function isExecutive() {
        if($this->hasRole('manager')) {
            return true;
        }
        return false;
    }

    public function isAdmin() {
        if($this->hasRole('admin')) {
            return true;
        }
        return false;
    }

    public function news() {
        if($this->isMonitor() || $this->isAdmin() || $this->isExecutive()) {
            return $this->hasMany(News::class);
        }

        return false;
    }

    public function themes() {
        if(!$this->isClient()) {
            return false;
        }

        return $this->belongsToMany(Theme::class, 'theme_user');
    }

    public function companies() {
        if($this->isExecutive() || $this->isClient() || $this->isAdmin()) {
            return $this->belongsToMany(Company::class, 'client_executive');
        }
        
        return false;
    }

    public function company() {
        if($this->isClient()) {
            $companyId = $this->metas->where('meta_key', 'company_id')->first()->meta_value;
            return Company::findOrFail($companyId);
        }

        return false;
    }

    public static function getRoleNameCustom($name) {
        switch ($name) {
            case 'admin':   $customName = 'Super Administrador';    break;
            case 'manager': $customName = 'Ejecutivo de Cuentas';   break;
            case 'monitor': $customName = 'Monitorista';            break;
            case 'client':  $customName = 'Cliente';                break;
            case 'disable':  $customName = 'Deshabilitado';         break;
            default:        $customName = 'Indefinido';             break;
        }

        return $customName;
    }

    public function toStringRoles() {
        $roles = $this->getRoleNames();
        if($roles->count() == 1){
            return $this->getRoleNameCustom($roles[0]);
        }

        if($roles->count() > 1 ) {
            $names = $roles->map(function($rol) {
                return $this->getRoleNameCustom($rol);
            });

            return implode(',', $names);
        }

        return false;
    }

    public function getMetaByKey($key) {

        $meta = UserMeta::where([
            ['meta_key', '=', $key],
            ['user_id', '=', $this->id],
        ])->first();
        
        if(is_null($meta)) {
            return false;
        }

        return $meta;
    }
}
