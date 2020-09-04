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

use App\News;
use App\Newsletter;
use App\NewsletterSend;
use App\Theme;
use Illuminate\Database\Eloquent\Model;

class NewsletterThemeNews extends Model
{
    protected $fillable = ['newsletter_id', 'newsletter_theme_id', 'newsletter_send_id', 'news_id'];

    protected $table = 'newsletter_themes_news';

    public function newsletter () {
        return $this->belongsTo(Newsletter::class);
    }

    public function theme() {
        return $this->belongsTo(Theme::class, 'newsletter_theme_id');
    }

    public function news() {
        return $this->belongsTo(News::class);
    }

    public function newsletter_send() {
        return $this->belongsTo(NewsletterSend::class, 'newsletter_send_id');
    }
}
