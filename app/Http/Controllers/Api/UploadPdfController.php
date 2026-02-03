<?php
namespace App\Http\Controllers\Api;

use App\Models\NewspaperFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
