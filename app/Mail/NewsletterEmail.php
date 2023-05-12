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
  * Type: Class
  * Description: Email Newsletter
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Mail;

use App\Models\{NewsletterFooter,NewsletterLinksCovers,NewsletterSend};
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletterSend;

    public $coversLinks;

    public $coversAllowed;

    public $covers;

    public $linksAllowed = array();

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(NewsletterSend $newsletterSend, NewsletterFooter $coversFooter)
    {
        $this->newsletterSend = $newsletterSend;

        $this->covers = NewsletterLinksCovers::all();

        $this->coversLinks = unserialize($coversFooter->urls);

        $this->coversAllowed = unserialize($this->newsletterSend->newsletter->covers);

        foreach ($this->coversLinks as $key => $link) {
            foreach ($this->coversAllowed as $allowed) {
                if($key == $allowed) {
                    $this->linksAllowed[$key] = $link;
                }
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("mail.{$this->newsletterSend->newsletter->template}")
                ->from('newsletter@opemedios.com.mx', 'Newsletter')
                ->subject("Newsletter - {$this->newsletterSend->newsletter->company->name}");
    }
}
