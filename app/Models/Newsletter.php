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

namespace App\Models;

use App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Newsletter
 * @package App
 * @method static findOrFail($id)
 */
class Newsletter extends Model
{
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'banner', 'active', 'company_id', 'template'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {

        return $this->belongsTo(Models\Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newsletter_send()
    {

        return $this->hasMany(Models\NewsletterSend::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newsletter_theme_news()
    {
        return $this->hasMany(NewsletterThemeNews::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newsletter_users()
    {

        return $this->hasMany(NewsletterUser::class);
    }
}
