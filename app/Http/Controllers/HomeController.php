<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\{Models\Company, Models\ContactMessage, Models\User};
use App\Http\Requests\FormContactRequest;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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
