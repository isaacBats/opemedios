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
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['name', 'banner', 'active', 'company_id'];

    public function company() {

        return $this->belongsTo(Company::class);
    }
}
