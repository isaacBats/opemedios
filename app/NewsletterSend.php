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

use App\Newsletter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NewsletterSend
 * @package App
 */
class NewsletterSend extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['newsletter_id', 'status', 'news_ids', 'num_notes', 'num_email'];

    /**
     * @var string
     */
    protected $table = 'newsletters_send';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function newsletter() {

        return $this->belongsTo(Newsletter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function newsletter_theme_news() {
        return $this->hasMany(NewsletterThemeNews::class);
    }
}
