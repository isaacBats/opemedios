<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterEmail;
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

    public function addNote (Request $request) {
        
        $data['newsletter_id'] = $request->input('newsletterid');
        $data['newsletter_theme_id'] = $request->input('themeid');
        $data['newsletter_send_id'] = $request->input('newssend');
        $data['news_id'] = $request->input('news_id');
        $this->ntnc->create($data);

        return response()->json([
            'status' => 'OK',
            'message' => '¡Nota agregada correctamente!'
        ]);
    }

    public function remove (Request $request) {
        $this->ntnc->remove($request->input('ntn'));

        return response()->json(['status' => 'OK', 'message' => '¡Nota eliminada correctamente!']);
    }

    public function previewEmail(Request $request, $id) {
        
        $newsletterSend = NewsletterSend::findOrFail($id);

        return new NewsletterEmail($newsletterSend);
    }
}
