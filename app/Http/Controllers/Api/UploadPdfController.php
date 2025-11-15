<?php
namespace App\Http\Controllers\Api;

use App\Exports\NewsExport;
use App\Mail\NoticeNewsEmail;
use App\Models\AssignedNews;
use App\Models\AuthorType;
use App\Models\File;
use App\Models\NewspaperFile;
use App\Models\Genre;
use App\Models\Means;
use App\Models\News;
use App\Models\Newsletter;
use App\Models\NewsletterSend;
use App\Models\NewsletterThemeNews;
use App\Models\Sector;
use App\Models\SocialNetworks;
use App\Models\Theme;
use App\Models\TypePage;
use App\Models\User;
use App\Traits\StadisticsNotes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class UploadPdfController extends Controller
{

    public function validaSiExiste(Request $request){
        $data = $request->all();
        $validate = $this->validator($data);
        
        if($validate->fails()) return response()->json($validate->errors(), 400);

        $existe = \App\Models\NewspaperFile::where('newspaper', $data['newspaper'])
                            ->where('date', $data['date'])
                            //->where('file', $data['file'])
                            ->exists();
                            
        return response()->json(['existe' => $existe]);
    }

    public function upload(Request $request){
        $data = $request->all();
        $validate = $this->validator($data);

        if($validate->fails()) return response()->json($validate->errors(), 400);

        NewspaperFile::create($data);

        return response()->json(['status' => true]);
    }

    public function validator(array $data) {
        return Validator::make($data, [
            'newspaper' => 'required',
            'date' => 'required',
            'file' => 'required',
        ]);
    }
}
