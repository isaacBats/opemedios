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
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */


namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Mail\NewsletterEmail;
use App\News;
use App\Newsletter;
use App\NewsletterSend;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{

    protected $newsController;

    protected $mediaController;

    public function __construct(NewsController $newsController, MediaController $mediaController) {

        $this->newsController = $newsController;
        $this->mediaController = $mediaController;

    }

    public function index(){
        $newsletters = Newsletter::orderBy('id', 'DESC')->paginate(25);

        return view('admin.newsletter.index', compact('newsletters'));
    }

    public function showFormCreateNewsletter() {

        $companies = Company::all();

        return view('admin.newsletter.create', compact('companies'));
    }

    protected function validator(array $data) {
        return Validator::make($data,
            ['name' => 'required|max:200|',],
            ['name.required' => 'Es necesario elegir un nombre para el Newsletter.',]
        );
    }

    public function create (Request $request) {

        $data = $request->all();
        $company = Company::find($data['company_id']);

        if ($company->newsletter) {

            return redirect()->route('admin.newsletters')->with('status', 'El newsletter ya existe!');
        }

        if (!$request->has('name')) {
            $data['name'] = $company->name;
        }
        $this->validator($data)->validate();

        if($file = $request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('newsletters', 'local');
        }
        $data['active'] = 1; // Newsletter active by default
        $data['template'] = 'newsletter1'; // Newsletter template by default

        Newsletter::create($data);

        return redirect()->route('admin.newsletters')->with('status', 'El newsletter se ha creado con éxito');
    }

    public function sendMail(Request $request, $sendId) {

        try {
            $newsletterSend = NewsletterSend::findOrFail($sendId);
            $newsletter = $newsletterSend->newsletter;
            if($request->has('emails')){
                $emails = explode(',',$request->input('emails'));
            } else {
                $emails = $newsletter->newsletter_users->map(function($item){ return $item->email; });
            }
            Mail::to($emails)->send(new NewsletterEmail($newsletterSend));
            $newsIds = $newsletterSend->newsletter_theme_news->map(function($ntn) {
                return $ntn->news_id;
            });
            $newsletterSend->status ++;
            $newsletterSend->news_ids = serialize($newsIds);
            $newsletterSend->num_notes = $newsletterSend->newsletter_theme_news->count();
            $newsletterSend->num_email = sizeof($emails);
            $newsletterSend->save();

            $today = \Carbon\Carbon::today();
            
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        Log::info("Newsletters of the day {$today} have been sent");

        return 'Se ha enviado la noticia con satisfacción';
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request, $id) {
        $newsletter = Newsletter::findOrFail($id);

        return view('admin.newsletter.view', compact('newsletter'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function config(Request $request, $id) {
        $newsletter = Newsletter::findOrFail($id);
        $templates = [
            ['name' => 'newsletter1', 'label' => 'Plantilla 1'],
            ['name' => 'newsletter2', 'label' => 'Plantilla 2'],
            ['name' => 'newsletter3', 'label' => 'Plantilla 3'],
        ];

        return view('admin.newsletter.config', compact('newsletter', 'templates'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBanner(Request $request, $id) {
        $newsletter = Newsletter::findOrFail($id);
        try {
            if(Storage::drive('local')->exists($newsletter->banner)) {
                Storage::drive('local')->delete($newsletter->logo);
            }

            $newsletter->banner = $request->file('banner')->store('newsletters', 'local');
            $newsletter->save();

        } catch (Exception $e) {
            return back()->with('status', 'Could not update image: ' . $e->getMessage());
        }

        return redirect()->route('admin.newsletter.config', ['id' => $id])->with('status', '¡Exito!. Se ha cambiado el banner correctamente');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, $id) {
        $newsletter = Newsletter::findOrFail($id);
        try {
            $newsletter->active = $request->input('status');
            $status = $request->input('status') ? 'Activo' : 'Inactivo';
            $newsletter->save();

            return response()->json(['message' => "El newsletter a quedado {$status}"]);
        } catch (Exception $e) {
            return response()->json(['error' => "Error al actualizar el estatus del newsletter"]);
        }
    }

    public function showNew(Request $request) {

        if(!$request->has('qry')) {
            return redirect()->route('home');
        }

        try {
            $data = explode('-',Crypt::decryptString($request->get('qry')));
        } catch (DecryptException $e) {
            return abort(403, 'Noticia no encontrada');
        }
        $company = Company::find(end($data));
        $note = News::findOrFail($data[0]);

        return view('newsletter.shownew', compact('note'));
    }

    public function sendSelectHTMLWithThemes(Request $request) {

        $themes = Newsletter::find($request->input('newsletter_id'))
            ->company->themes()->get();

        return view('components.select-themes-newsletters', compact('themes'))->render();
    }

    public function sendSelectHTMLWithSends(Request $request) {

        $newsletterId = $request->input('newsletter_id');
        $newslettersSends = NewsletterSend::where('newsletter_id',$newsletterId)
            ->where('status', 0)->orderBy('id', 'DESC')->get();

        if($newslettersSends->count()) {
            return view('components.select-newsletter-send', compact('newslettersSends'))->render();
        }

        NewsletterSend::create([
            'newsletter_id' => $newsletterId,
            'status' => 0,
        ]);

        return $this->sendSelectHTMLWithSends($request);

    }

    public function removeNewsletterSend(Request $request, $sendId) {
        $newsletterSend = NewsletterSend::findOrFail($sendId);
        $newsletterSend->delete();

        return back()->with('status', "Se ha eliminado el newsletter satisfactoriamente");
    }

    public function updateTemplate(Request $request) {
        $newsletter = Newsletter::findOrFail($request->input('newsletter_id'));
        $newsletter->template = $request->input('template');
        $newsletter->save();
        return back()->with('status', "Se ha definido el template para el newsletter satisfactoriamente");
    }
}
