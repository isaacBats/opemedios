<?php

namespace App\Http\Controllers;

use App\Newsletter;
use App\NewsletterSend;
use Illuminate\Http\Request;

/**
 * Class NewsletterSendController
 * @package App\Http\Controllers
 */
class NewsletterSendController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, $id) {
        $newsletter = Newsletter::findOrFail($id);
        $forSend = NewsletterSend::create([
            'newsletter_id' => $newsletter->id,
            'status' => 0,
        ]);

        return redirect()->route('admin.newsletter.view', ['id' => $newsletter->id])->with('status', 'Se ha creado una nueva plantilla para newsletter');
    }
}
