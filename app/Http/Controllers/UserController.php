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
  * Type: Class
  * Description: UserController
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        


namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index () {
        $users = User::select()->paginate(25);

        return view('admin.user.index', compact('users'));
    }

    public function show (Request $request, $id) {
        $profile = User::find($id);

        return view('admin.user.show', compact('profile'));

    }
}
