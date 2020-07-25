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
use App\News;
use App\Theme;
use Illuminate\Database\Eloquent\Model;

class AssignedNews extends Model
{
    protected $fillable = ['news_id', 'company_id', 'theme_id', 'num_users', 'users_ids'];

    public function company () {
        return $this->belongsTo(Company::class);
    }

    public function news () {
        return $this->belongsTo(News::class);
    }

    public function theme () {
        return $this->belongsTo(Theme::class);
    }


}
