<?php

namespace App\Http\Controllers;

use App\NewsletterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsletterUserController extends Controller
{
    public function addAccounts(Request $request) {
        try {
            $newsletterId = $request->input('newsletter_id');
            foreach ($request->input('accounts') as $email) {
                $newsletterUser = new NewsletterUser();
                $newsletterUser->newsletter_id = $newsletterId;
                $newsletterUser->email = $email;
                $newsletterUser->save();
            }

            return back()->with('status', 'Los correos se han agregado correctamente');

        } catch(Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function removeEmail(Request $request) {
        $email = NewsletterUser::findOrFail($request->input('id'));
        $correo = $email->email;
        $newsletter = $email->newsletter;
        $email->delete();

        return back()->with('status', "Se ha eliminado el la cuenta de {$correo} del newsletter {$newsletter->name} satisfactoriamente");
    }
}
