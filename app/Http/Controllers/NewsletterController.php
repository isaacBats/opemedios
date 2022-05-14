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

use App\AssignedNews;
use App\Company;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Mail\NewsletterEmail;
use App\News;
use App\Newsletter;
use App\NewsletterFooter;
use App\NewsletterSend;
use App\User;
use Carbon\Carbon;
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

    public function __construct(NewsController $newsController, MediaController $mediaController)
    {

        $this->newsController = $newsController;
        $this->mediaController = $mediaController;
    }

    public function index()
    {
        $breadcrumb = array();
        $newsletters = Newsletter::orderBy('id', 'DESC')->paginate(25);
        $covers = NewsletterFooter::limit(5)->orderBy('id', 'DESC')->get();
        $coverToday = false;

        if ($covers->count() > 0) {
            $coverToday = $covers->filter(function ($cover) {
                return $cover->created_at->format('Y-m-d') == Carbon::today()->format('Y-m-d');
            })->first();
        }
        
        array_push($breadcrumb, ['label' => 'Newsletters']);

        return view('admin.newsletter.index', compact('newsletters', 'covers', 'coverToday', 'breadcrumb'));
    }

    public function showFormCreateNewsletter()
    {
        $breadcrumb = array();
        $companies = Company::all();

        array_push($breadcrumb, ['label' => 'Newsletters', 'url' => route('admin.newsletters')]);
        array_push($breadcrumb, ['label' => 'Nuevo newsletter']);

        return view('admin.newsletter.create', compact('companies', 'breadcrumb'));
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            ['name' => 'required|max:200|',],
            ['name.required' => 'Es necesario elegir un nombre para el Newsletter.',]
        );
    }

    public function create(Request $request)
    {

        $data = $request->all();
        $company = Company::find($data['company_id']);

        if ($company->newsletter) {
            return redirect()->route('admin.newsletters')->with('status', 'El newsletter ya existe!');
        }

        if (!$request->has('name')) {
            $data['name'] = $company->name;
        }
        $this->validator($data)->validate();

        if ($file = $request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('newsletters', 'local');
        }
        $data['active'] = 1; // Newsletter active by default
        $data['template'] = 'newsletter1'; // Newsletter template by default

        Newsletter::create($data);

        return redirect()->route('admin.newsletters')->with('status', 'El newsletter se ha creado con éxito');
    }

    public function sendMail(Request $request, $sendId)
    {

        try {
            $newsletterSend = NewsletterSend::findOrFail($sendId);
            $covers = NewsletterFooter::whereDate('created_at', Carbon::today()->format('Y-m-d'))->first();
            $newsletter = $newsletterSend->newsletter;
            if ($request->has('emails')) {
                $emails = explode(',', $request->input('emails'));
            } else {
                $emails = $newsletter->newsletter_users->map(function ($item) {
                    return $item->email;
                });
            }
            if (!$covers) {
                return back()->with(
                    'status',
                    'No se puede enviar el newsletter por que hace falta agregar las portadas del día de hoy'
                );
            }

            foreach ($emails as $email) {
                $reciver = User::where('email', trim($email))->first();
                if ($reciver) {
                    Mail::to($reciver)->send(new NewsletterEmail($newsletterSend, $covers));
                } else {
                    Mail::to(trim($email))->send(new NewsletterEmail($newsletterSend, $covers));
                }
            }

            foreach ($newsletterSend->newsletter_theme_news as $newsletterThemeNew) {
                $assigned = AssignedNews::firstOrNew(
                    ['news_id' => $newsletterThemeNew->news_id],
                    ['theme_id' => $newsletterThemeNew->newsletter_theme_id]
                );

                $assigned->company_id = $newsletter->company_id;
                $assigned->save();
            }


            $newsIds = $newsletterSend->newsletter_theme_news->map(function ($ntn) {
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

        return back()->with('status', 'Se ha enviado la noticia con satisfacción');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request, $id)
    {
        $breadcrumb = array();
        $newsletter = Newsletter::findOrFail($id);

        array_push($breadcrumb, ['label' => 'Newsletters', 'url' => route('admin.newsletters')]);
        array_push($breadcrumb, ['label' => $newsletter->name]);

        return view('admin.newsletter.view', compact('newsletter', 'breadcrumb'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function config(Request $request, $id)
    {
        $breadcrumb = array();
        $newsletter = Newsletter::findOrFail($id);
        $templates = [
            ['name' => 'newsletter1', 'label' => 'Plantilla 1'],
            ['name' => 'newsletter2', 'label' => 'Plantilla 2'],
            ['name' => 'newsletter3', 'label' => 'Plantilla 3'],
        ];

        array_push($breadcrumb, ['label' => 'Newsletters', 'url' => route('admin.newsletters')]);
        array_push($breadcrumb, ['label' => "Configuracion {$newsletter->name}"]);

        return view('admin.newsletter.config', compact('newsletter', 'templates', 'breadcrumb'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBanner(Request $request, $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        try {
            if (Storage::drive('local')->exists($newsletter->banner)) {
                Storage::drive('local')->delete($newsletter->logo);
            }

            $newsletter->banner = $request->file('banner')->store('newsletters', 'local');
            $newsletter->save();
        } catch (Exception $e) {
            return back()->with('status', 'Could not update image: ' . $e->getMessage());
        }

        return redirect()->route('admin.newsletter.config', ['id' => $id])
            ->with('status', '¡Exito!. Se ha cambiado el banner correctamente');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, $id)
    {
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

    public function showNew(Request $request)
    {

        if (!$request->has('qry')) {
            return redirect()->route('home');
        }

        try {
            $data = explode('-', Crypt::decryptString($request->get('qry')));
        } catch (DecryptException $e) {
            return abort(403, 'Noticia no encontrada');
        }
        $company = Company::find(end($data));
        $note = News::findOrFail($data[0]);

        return view('newsletter.shownew', compact('note'));
    }

    public function sendSelectHTMLWithThemes(Request $request)
    {

        $themes = Newsletter::find($request->input('newsletter_id'))
            ->company->themes()->get();

        return view('components.select-themes-newsletters', compact('themes'))->render();
    }

    public function sendSelectHTMLWithSends(Request $request)
    {

        $newsletterId = $request->input('newsletter_id');
        $newslettersSends = NewsletterSend::where('newsletter_id', $newsletterId)
            ->where('status', 0)->orderBy('id', 'DESC')->get();

        if ($newslettersSends->count()) {
            return view('components.select-newsletter-send', compact('newslettersSends'))->render();
        }

        NewsletterSend::create([
            'newsletter_id' => $newsletterId,
            'status' => 0,
        ]);

        return $this->sendSelectHTMLWithSends($request);
    }

    public function removeNewsletterSend(Request $request, $sendId)
    {
        $newsletterSend = NewsletterSend::findOrFail($sendId);
        $newsletterSend->delete();

        return back()->with('status', "Se ha eliminado el newsletter satisfactoriamente");
    }

    public function updateTemplate(Request $request)
    {
        $newsletter = Newsletter::findOrFail($request->input('newsletter_id'));
        $newsletter->template = $request->input('template');
        $newsletter->save();
        return back()->with('status', "Se ha definido el template para el newsletter satisfactoriamente");
    }

    public function addCovers()
    {

        return view('admin.newsletter.addcovers');
    }

    public function remove(Request $request, $id)
    {
        try {
            $newsletter = Newsletter::findOrFail($id);
            $name = $newsletter->name;
            $newsletter->newsletter_theme_news()->delete();
            $newsletter->newsletter_users()->forceDelete();
            $newsletter->forceDelete();

            return back()->with('status', "El newsletter {$name} se ha borrado satisfactoriamente.");
        } catch (Exception $e) {
            Log::error("Error al borrar newsletter: {$e->getMessage()}");
            return back()->with('status', "No se ha podido borrar el newsletter {$name}. Intentelo mas tarde");
        }
    }
}
