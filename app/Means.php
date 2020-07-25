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

use App\Source;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Means extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'short_name', 'icon', 'slug'];

    public function sources() {
        return $this->hasMany(Source::class);
    }

    public function getColor() {
        $array_colors = ['rgb(38,42,247, 0.48)','rgb(247,247,38, 0.48)','rgb(247,38,38, 0.48)','rgb(247,142,38, 0.48)','rgb(38,247,247, 0.48)'];
        switch ($this->id) {
            case 1: return 'rgb(38,42,247, 0.48)'; break;
            case 2: return 'rgb(247,247,38, 0.48)'; break;
            case 3: return 'rgb(247,38,38, 0.48)'; break;
            case 4: return 'rgb(247,142,38, 0.48)'; break;
            case 5: return 'rgb(38,247,247, 0.48)'; break;
            default: return Arr::random($array_colors); break;
        }
    }
}
