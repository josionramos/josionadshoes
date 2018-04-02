<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Requests\Gallery as GalleryRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Gallery::paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        return Gallery::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return $gallery;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update($request->all());

        return $gallery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
