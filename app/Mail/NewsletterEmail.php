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

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;

    public $news;

    public $company;

    public $newsByTheme;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Newsletter $newsletter, $news, $company, $newsByTheme)
    {
        $this->newsletter = $newsletter;
        $this->news = $news;
        $this->company = $company;
        $this->newsByTheme = $newsByTheme;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.newsletter2')
                ->from('newsletter@opemedios.com.mx', 'Newsletter')
                ->subject("Newsletter - {$this->company->name}");
    }
}
