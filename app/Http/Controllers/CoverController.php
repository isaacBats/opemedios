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
        $covers = Cover::orderBy('id', 'desc')->paginate(25);
        $types = $this->coverTypes();

        return view('admin.press.index', compact('covers', 'types'));
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
            1 => 'Primera plana',
            2 => 'Portada financiera',
            3 => 'Columna política',
            4 => 'Columna financiera',
            5 => 'Carton'
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
    public function edit(Request $response, $id)
    {
        $cover = Cover::findOrFail($id);
        $types = $this->coverTypes();
        $coverType = array_filter($types, function($v, $k) use($cover) { return $k == $cover->cover_type; }, ARRAY_FILTER_USE_BOTH);
        $neswpaperMean = Means::where('short_name', 'per')->first();
        $sources = Source::where('means_id', $neswpaperMean->id)->get();
        
        return view('admin.press.edit', compact('cover', 'coverType', 'sources'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $cover = Cover::findOrFail($id);
        $data['date_cover'] = Carbon::createFromFormat('d-m-Y', $data['date_cover']);
        $cover->update($data);
        $types = $this->coverTypes();
        $coverType = array_filter($types, function($v, $k) use($cover) { return $k == $cover->cover_type; }, ARRAY_FILTER_USE_BOTH);

        return redirect()->route('admin.press.show')->with('status',"¡{$coverType[$cover->cover_type]} actualizada satisfactoriamente!"); 
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
