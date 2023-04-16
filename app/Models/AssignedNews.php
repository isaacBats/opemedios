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

namespace App\Models;

use App\{App\Models\Company, App\Models\News, App\Models\Theme, Illuminate, Models};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedNews extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'company_id',
        'theme_id',
        'num_users',
        'users_ids'
    ];

    /**
     * Relationship with Company Model
     *
     * @return Illuminate\Database\Eloquent\Model;
     */
    public function company()
    {
        return $this->belongsTo(Models\Company::class);
    }

    /**
     * Relationship with News Model
     *
     * @return Illuminate\Database\Eloquent\Model;
     */
    public function news()
    {
        return $this->belongsTo(Models\News::class);
    }

    /**
     * Relationship with Theme Model
     *
     * @return Illuminate\Database\Eloquent\Model;
     */
    public function theme()
    {
        return $this->belongsTo(Models\Theme::class);
    }
}
