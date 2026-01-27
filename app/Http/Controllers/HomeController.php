<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\{Models\Company, Models\ContactMessage, Models\User};
use App\Http\Requests\FormContactRequest;
use App\Http\Requests\ContactFormV3Request;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Throwable;

class HomeController extends Controller
{
    public function index()
    {
        $company = '';
        if (Auth::check() && !session()->has('slug_company')) {
            $company = Company::first();
        }

        return view('homev3', compact('company'));
    }

    /**
     * Handle contact form submission from legacy contact page.
     */
    public function formContact(FormContactRequest $request)
    {
        // TODO: Crear una plantilla general de correo de notificación para opemedios
        $contactMessage = ContactMessage::create($request->all());

        $users = User::where('email', 'froylan@opemedios.com.mx')
            ->orWhere('email', 'karenina.opemedios@gmail.com')
            ->get();

        Notification::send($users, new ContactFormNotification($contactMessage));

        return back()->with(
            'status',
            'Gracias por interesarse en nuestros servicios. En breve nos pondremos en contacto con usted.'
        );
    }

    /**
     * Handle contact form submission from Home v3 (SaaS Modern Theme).
     */
    public function formContactV3(ContactFormV3Request $request)
    {
        try {
            $contactMessage = ContactMessage::create([
                'name'             => $request->input('name'),
                'company'          => $request->input('company'),
                'email'            => $request->input('email'),
                'phone'            => $request->input('phone'),
                'service_interest' => $request->input('service_interest'),
                'message'          => $request->input('message'),
            ]);

            $users = User::where('email', 'froylan@opemedios.com.mx')
                ->orWhere('email', 'karenina.opemedios@gmail.com')
                ->get();

            Notification::send($users, new ContactFormNotification($contactMessage));

            Log::info('Contact form v3 submitted successfully', [
                'contact_id' => $contactMessage->id,
                'email'      => $contactMessage->email,
                'service'    => $contactMessage->service_interest,
            ]);

            return back()->with(
                'success',
                '¡Gracias por contactarnos! Nos pondremos en contacto contigo muy pronto.'
            );
        } catch (Throwable $e) {
            Log::error('Error processing contact form v3', [
                'error'   => $e->getMessage(),
                'email'   => $request->input('email'),
                'service' => $request->input('service_interest'),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Hubo un problema al enviar tu solicitud. Por favor, intenta nuevamente.');
        }
    }

    public function changeCompany(Request $request)
    {
        if ($request->has('slug')) {
            if (session('slug_company')) {
                $slug = $request->get('slug');
                session()->put('slug_company', $slug);

                return redirect("{$slug}/mis-noticias");
            }
        }

        return back();
    }
}
