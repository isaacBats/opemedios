<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
  * @version 1.0.0
  * @package App\
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        
namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FolderController extends Controller
{
    public function create(Request $request) {
        $inputs = $request->all();

        $same = Folder::where([
            ['name', 'like', "{$inputs['name']}"],
            ['level', $inputs['level']]
        ])->get();
        
        if($same->count()) {
            return back()->with('warning', "El folder {$inputs['name']} ya existe");
        }

        try {
            if($inputs['level'] == '1') {
                Storage::disk('s3')->makeDirectory($inputs['name'], 0755, true, true);
                $initialPath = 'https://objects-us-east-1.dream.io/opemedios-media';
                $newFolder = Folder::create([
                    'name' => $inputs['name'],
                    'filesystem' => 's3',
                    'is_public' => 1,
                    'level' => 1,
                    'path' => "{$initialPath}/{$inputs['name']}"
                ]);

            } else {
                $parent = Folder::where('name', 'like', "{$inputs['last-folder']}")
                    ->where('level', $inputs['level'] - 1)->first();

                Storage::disk('s3')->makeDirectory("{$parent->name}/{$inputs['name']}", 0755, true, true);
                $newFolder = $newFolder = Folder::create([
                    'name' => $inputs['name'],
                    'filesystem' => 's3',
                    'is_public' => 1,
                    'parent' => $parent->id,
                    'level' => $parent->level + 1,
                    'path' => "{$parent->path}/{$inputs['name']}"
                ]);

            }
            
        } catch (Exception $e) {
            LOG::error("Error crate folder: {$e->getMessage()}");
            return back()->with('status', 'No se ha podido crear la carpeta. Intentelo en otro momento');
        }
        return back()->with('status', 'La carpeta se ha creado satisfactoriamente');
    }
}
