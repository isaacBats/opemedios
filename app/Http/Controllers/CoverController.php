<?php

namespace App\Http\Controllers;

use App\Cover;
use App\Means;
use App\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $covers = Cover::orderBy('id', 'desc')->paginate(25);;
        return view('admin.press.index', compact('covers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coverTypes = $this->coverTypes();
        $neswpaperMean = Means::where('short_name', 'per')->first();
        $sources = Source::where('means_id', $neswpaperMean->id)->get();
        return view('admin.press.create', compact('coverTypes', 'sources'));
    }

    public function coverTypes() {
        return [
            1 => 'Primeras planas',
            2 => 'Portadas financieras',
            3 => 'Columnas políticas',
            4 => 'Columnas financieras',
            5 => 'Cartones'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);
        if($validate->fails()) {
            return back()->withErrors($validate)
                ->withInput();
        }
        $newCover = new Cover();
        $newCover->cover_type = $data['cover_type'];
        $newCover->date_cover = Carbon::createFromFormat('d-m-Y', $data['date_cover']);
        $newCover->source_id = $data['source_id'];
        if ($data['cover_type'] == 3 || $data['cover_type'] == 4) {
            $newCover->title = $data['title'];
            $newCover->author = $data['author'];
            $newCover->content = $data['content'];
        }
        if($request->hasFile('image')) {
            $initialPath = 'https://objects-us-east-1.dream.io/opemedios-media';
            $date = Carbon::now();
            $path = "covers/{$date->year}/{$date->month}";
            $file = $data['image'];
            $fileName = $file->hashName();
            Storage::disk('s3')->put($path, $file, 'public');
            $newCover->image = "{$initialPath}/{$path}/{$fileName}";
        }
        $newCover->save();

        return redirect()->route('admin.press.show')->with('status','¡Portada creada satisfactoriamente!');
    }

    public function validator(array $data) {
        return Validator::make($data, [
            'cover_type' => 'required',
            'title' => [Rule::requiredIf(function() use ($data){
                            $coverType = $data['cover_type'];
                            if ($coverType == 3 || $coverType == 4) {
                                return true;
                            } 
                            return false;
                        })],
            'author' => [Rule::requiredIf(function() use ($data){
                            $coverType = $data['cover_type'];
                            if ($coverType == 3 || $coverType == 4) {
                                return true;
                            } 
                            return false;
                        })],
            'date_cover' => 'required',
            'source_id' => 'required',
            'content' => [Rule::requiredIf(function() use ($data){
                            $coverType = $data['cover_type'];
                            if ($coverType == 3 || $coverType == 4) {
                                return true;
                            } 
                            return false;
                        })],
            'image' => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function show(Cover $cover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function edit(Cover $cover)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cover $cover)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cover $cover)
    {
        //
    }
}
