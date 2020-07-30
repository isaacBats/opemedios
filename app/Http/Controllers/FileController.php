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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function uploadToS3($file, $isCover = false) {

        $initialPath = 'https://objects-us-east-1.dream.io/opemedios-media';
        $date = Carbon::now();
        $path = ($isCover) ? "covers/{$date->year}/{$date->month}":"{$date->year}/{$date->month}";
        
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

    public static function removeTrashS3($file, $isCover = false) {
        $date = Carbon::now();
        $path_file = static::getRelativePath($file);
        $path_trash = $isCover ? "trash/{$date->year}/cover" : "trash/{$date->year}/{$file->news->mean->short_name}";
        Storage::disk('s3')->move($path_file, "{$path_trash}/$file->name");

        return true;
    }

    protected static function getRelativePath($file) {
        $initialPath = 'https://objects-us-east-1.dream.io/opemedios-media/';
        return Str::after($file->path_filename, $initialPath);
    }
    public function validator ($data) {
        
        return Validator::make($data, [
            'file' => 'file|max:1048576',                 // max_file_size in KB: 1GB
        ], 
        [
            'size' => 'El tamaño debe de ser menor a 1GB',
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

    public function validateCover($data) {
        return Validator::make($data, [
                'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2000',
            ], [
                'image' => 'Debe de ser una imagen',
                'mimes' => 'El archivo debe de ser de tipo :values'
        ]);
    }
    //TODO: Refactorizar todo el codigo para guardar un archivo en S3

    public function update($file, $newFile, $isCover = false) {

        $validate = $isCover ? $this->validateCover(array('image' => $newFile)) : $this->validator(array('file' => $newFile));
        if($validate->fails()) {
            return false;
        }
        $pathFile = static::getRelativePath($file);
        try {
            if(Storage::drive('s3')->exists($pathFile)) {
                static::removeTrashS3($file, true);
                $initialPath = 'https://objects-us-east-1.dream.io/opemedios-media';
                $date = Carbon::now();
                $path = $isCover ? "covers/{$date->year}/{$date->month}":"{$date->year}/{$date->month}";
                Storage::disk('s3')->put($path, $newFile, 'public');

                $fileName = $newFile->hashName();
                $file->name = $fileName;
                $file->original_name = $newFile->getClientOriginalName();
                $file->path_filename = "{$initialPath}/{$path}/{$fileName}";
                $file->type = $newFile->getMimeType();
                $file->save();

                return true;
            } 
        } catch (Exception $e) {
            Log::error('Could not update image: ' . $e->getMessage());
            Log::error("Hay un error con la actualizacion del archivo {$e->getMessage()}");
        }

        return false;
    }

    public function removeFile (Request $request) {
        return 'Borrar archivo';
    }
}
