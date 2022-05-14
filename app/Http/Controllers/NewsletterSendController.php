<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2021
  * @version 1.0.0
  * @package App\
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Http\Controllers;

use App\Mail\NewsletterEmail;
use App\Newsletter;
use App\NewsletterFooter;
use App\NewsletterSend;
use App\NewsletterThemeNews;
use Carbon\Carbon;
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
    public function create(Request $request, $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $label = $request->input('nwl-name') == "" ? "Default" : $request->input('nwl-name');
        $forSend = NewsletterSend::create([
            'newsletter_id' => $newsletter->id,
            'status' => 0,
            'label' => $label,
            'date_sending' => Carbon::createFromFormat('Y-m-d', $request->input('date-sending')),
        ]);

        return redirect()->route('admin.newsletter.view', ['id' => $newsletter->id])
            ->with('status', 'Se ha creado una nueva plantilla para newsletter');
    }

    /**
     * @param Request $reques
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $reques, $id)
    {
        $breadcrumb = array();
        $newsletterSend = NewsletterSend::findOrFail($id);

        array_push($breadcrumb, ['label' => 'Newsletters', 'url' => route('admin.newsletters')]);
        array_push($breadcrumb, [
            'label' => $newsletterSend->newsletter->name,
            'url' => route('admin.newsletter.view', ['id' => $newsletterSend->newsletter->id])
        ]);
        array_push($breadcrumb, ['label' => 'Agregar notas']);

        return view('admin.newsletter.editsend', compact('newsletterSend', 'breadcrumb'));
    }

    public function editLabel(Request $request, $id)
    {

        $newsletterSend = NewsletterSend::findOrFail($id);
        $newsletterSend->label = $request->input('label');
        $newsletterSend->save();

        return response()->json(['status' => 'OK', 'message' => '¡Nombre de etiqueta de newsletter actualizada!']);
    }

    public function addNote(Request $request)
    {
        
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

    public function remove(Request $request)
    {
        $this->ntnc->remove($request->input('ntn'));

        return response()->json(['status' => 'OK', 'message' => '¡Nota eliminada correctamente!']);
    }

    public function previewEmail(Request $request, $id)
    {
        
        $newsletterSend = NewsletterSend::findOrFail($id);
        $covers = NewsletterFooter::whereDate('created_at', Carbon::today()->format('Y-m-d'))->first();

        if (!$covers) {
            $covers = NewsletterFooter::latest('id')->first();
        }

        return new NewsletterEmail($newsletterSend, $covers);
    }
}
