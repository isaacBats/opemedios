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

use App\Models\NewsletterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsletterUserController extends Controller
{
    public function addAccounts(Request $request) {
        try {
            $newsletterId = $request->input('newsletter_id');

            if($request->has('tareaemails')) {
                $accounts = explode(",", trim($request->input('tareaemails')));

            } elseif($request->has('accounts')) {
                $accounts = $request->input('accounts');
            }

            foreach ($accounts as $email) {
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
