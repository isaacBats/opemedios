<?php

namespace App\Http\Controllers;

use App\Newsletter;
use App\NewsletterSend;
use App\NewsletterThemeNews;
use Illuminate\Http\Request;

/**
 * Class NewsletterSendController
 * @package App\Http\Controllers
 */
class NewsletterSendController extends Controller
{

    protected $ntnc;

    public function __construct(NewsletterThemeNewsController $ntnc)
    {
        $this->ntnc = $ntnc;
    }

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

    /**
     * @param Request $reques
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit (Request $reques, $id) {

        $newsletterSend = NewsletterSend::findOrFail($id);

        return view('admin.newsletter.editsend', compact('newsletterSend'));
    }

    public function addNote (Request $request, $id) {
        $data = $request->all();
        $this->ntnc->create($data);

        return redirect()->route('admin.newsletter.edit.send', ['id' => $id])->with('status', 'Nota agregada correctamente!');
    }

    public function remove (Request $request, $id) {
        $this->ntnc->remove($request->input('newsletter_theme_news_id'));

        return redirect()->route('admin.newsletter.edit.send', ['id' => $id])->with('status', 'Nota eliminada correctamente!');
    }
}
