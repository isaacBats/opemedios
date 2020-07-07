<?php

namespace App\Mail;

use App\News;
use App\Theme;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class NoticeNewsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $news;

    public $theme;

    public $cost;

    public $scope;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(News $news, Theme $theme)
    {
        $this->news = $news;
        $this->theme = $theme;

        $this->cost = $this->getAttribute('Costo');
        $this->scope = $this->getAttribute('Alcance');
    }

    protected function getAttribute($attr) {
        return Arr::first($this->news->metas(), function($value, $key) use($attr) {
            return $value['label'] == $attr;
        });
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noticia@opemedios.com.mx', 'Noticias OPEMEDIOS')
                ->subject($this->news->title)
                ->view('mail.noticeNews');
    }
}
