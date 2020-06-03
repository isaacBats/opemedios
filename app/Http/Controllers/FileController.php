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

use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function uploadToS3($file) {

        $initialPath = 'https://objects-us-east-1.dream.io/opemedios-media';
        $date = Carbon::now();
        $path = "{$date->year}/{$date->month}";
        
        $fileName = $file->hashName();
        Storage::disk('s3')->put($path, $file, 'public');
        $update = new File;
        $update->name = $fileName;
        $update->original_name = $file->getClientOriginalName();
        $update->path_filename = "{$initialPath}/{$path}/{$fileName}";
        $update->public = 1;
        $update->filesystem = 'S3';
        $update->type = $file->getMimeType();
        $update->save();

        return $update;
    }

    public function validator ($data) {
        
        return Validator::make($data, [
            'file' => 'file|max:64000',                 // max_file_size in KB: For dreamhost basic is 64MB
        ], 
        [
            'size' => 'El tamaño debe de ser menor a 64MB',
        ]);
    }

    public function uploadFile (Request $request) {
        
        $files = $request->file('files');
        
        $arrayFiles = array();
        foreach ($files as $file) {
            $this->validator(array('file' => $file))->validate();
            $update = $this->uploadToS3($file);
            $arrayFiles[] = $update->id;
        }

        return response()->json(['files' => $arrayFiles]);
    }

    public function removeFile (Request $request) {
        return 'Borrar archivo';
    }
}
