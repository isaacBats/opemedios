<?php

namespace App\Http\Controllers;

use App\ContactMessage;
use App\Http\Requests\FormContactRequest;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function about()
    {

        return view('aboutus');
    }

    public function clients()
    {

        return view('clients');
    }

    public function contact()
    {

        return view('contact');
    }

    public function signin()
    {

        return view('signin');
    }

    public function formContact(FormContactRequest $request)
    {
        // TODO: Crear una notificacion por correo para las personas que requieran ver esta información
        // TODO: Crear una plantilla general de correo de notificación para opemedios

        ContactMessage::create($request->all());

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
            
                return redirect("{$slug}/dashboard");
            }
        }

        return back();
    }
}
