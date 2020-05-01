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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public function index() {

        return view('admin.fm.index');
    }

    public function getDirectoriesS3() {
        $storage = Storage::disk('s3');

        // $file = asset('images/digitalagency.jpg');
        $client = $storage->getAdapter()->getClient();
        // $client->getEndpoint()->withHost('objects-us-east-1.dream.io');
        $command = $client->getCommand('ListObjects');
        $command['Bucket'] = $storage->getAdapter()->getBucket();
        // $command['host'] = 'objects-us-east-1.dream.io';
        // $command['Prefix'] = 'path/to/FS_1054_';
        $result = $client->execute($command);
            dd($result);
        // foreach ($result['Contents'] as $file) {
            //do something with $file['Key']
        // }
        // $client->getEndpoint()->getHost('objects-us-east-1.dream.io');
        // $update = $storage->put('imagenPruebadigitalagency.jpg', $file, 'public');
        // dd($update);
    }
}
