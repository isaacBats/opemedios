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

use App\Company;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'description', 'company_id'];

    public function company () {

        return $this->belongsTo(Company::class);
    }

    public function accounts() {
        return $this->belongsToMany(User::class, 'theme_user');
    }

    public function assignedNews() {
        return $this->hasMany(AssignedNews::class);
    }
}
