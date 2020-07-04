<?php

namespace App\Mail;

use App\News;
use App\Theme;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeNewsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $news;

    public $theme;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(News $news, Theme $theme)
    {
        $this->news = $news;
        $this->theme = $theme;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.noticeNews');
    }
}
