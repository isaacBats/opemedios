<?php

namespace App\Http\Controllers;

use App\NewsletterThemeNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterThemeNewsController extends Controller
{
    public function create ($data) {
        $this->validator($data)->validate();

        return NewsletterThemeNews::create([
            'newsletter_id' => $data['newsletter_id'],
            'newsletter_theme_id' => $data['newsletter_theme_id'],
            'newsletter_send_id' => $data['newsletter_send_id'],
            'news_id' => $data['news_id'],
        ]);
    }

    public function validator($data) {

        //TODO: validar que solo exista un solo registro con los mismos ids
        return Validator::make($data, [
            'newsletter_id' => 'required',
            'newsletter_theme_id' => 'required',
            'newsletter_send_id' => 'required',
            'news_id' => 'required',
        ]);
    }

    public function remove($id) {
        $newsletterThemeNews = NewsletterThemeNews::findOrFail($id);
        return $newsletterThemeNews->delete();
    }
}
