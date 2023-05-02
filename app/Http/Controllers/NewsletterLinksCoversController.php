<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterLinksCoversRequest;
use App\Http\Requests\UpdateNewsletterLinksCoversRequest;
use App\Models\NewsletterLinksCovers;
use Illuminate\Support\Str;

class NewsletterLinksCoversController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $covers = NewsletterLinksCovers::all();
        return view('admin.newsletter.addcovers', compact('covers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewsletterLinksCoversRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreNewsletterLinksCoversRequest $request)
    {
        $name = $request->input('name');
        $cover = new NewsletterLinksCovers();
        $cover->name = $name;
        $cover->slug = Str::slug($name, '_');
        $cover->save();

        return redirect()->route('admin.newsletter.config.footer')->with('status', 'La nueva portada esta lista para configurar.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsletterLinksCovers  $newsletterLinksCovers
     * @return \Illuminate\Http\Response
     */
    public function show(NewsletterLinksCovers $newsletterLinksCovers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsletterLinksCovers  $newsletterLinksCovers
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsletterLinksCovers $newsletterLinksCovers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewsletterLinksCoversRequest  $request
     * @param  \App\Models\NewsletterLinksCovers  $newsletterLinksCovers
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsletterLinksCoversRequest $request, NewsletterLinksCovers $newsletterLinksCovers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsletterLinksCovers  $newsletterLinksCovers
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsletterLinksCovers $newsletterLinksCovers)
    {
        //
    }
}
