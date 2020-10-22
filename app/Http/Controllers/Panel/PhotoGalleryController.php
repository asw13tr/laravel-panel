<?php

namespace App\Http\Controllers\Panel;

use App\PhotoGallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoGalleryController extends Controller{

    public function index(){
        $galleries = PhotoGallery::where('type', 'gallery')->orderBy("id", "desc")->get();
        $datas =  [
            'items' => $galleries,
            'headTitle' => "Fotoğraf Galeriler"
        ];
        return view('panel/photo-gallery/index', $datas);
    }

    public function createGallery(Request $request){
        if($request->get('galleryName')){
            PhotoGallery::create([
                'name' => $request->get('galleryName'),
                'type' => 'gallery',
                'slug' => $request->get('gallerySlug'),
            ]);
        }
        return redirect( route('panel.photo_galleries') );
    }

    public function deleteGallery(Request $request, PhotoGallery $gallery){
        $itemID = $gallery->id;
        $delete = $gallery->delete();
        if($delete){
            PhotoGallery::where('parent', $itemID)->delete();
        }
        return redirect( route('panel.photo_galleries') );
    }



    public function items(Request $request, PhotoGallery $gallery){
        $items = PhotoGallery::where('parent',$gallery->id)->where('type','item')->orderBy('menu_order')->get();
        $datas = [
            'headTitle' => 'Galeri Düzenle',
            'gallery' => $gallery,
            'items' => $items
        ];
        return view('panel/photo-gallery/items', $datas);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhotoGallery  $photoGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(PhotoGallery $photoGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhotoGallery  $photoGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhotoGallery $photoGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhotoGallery  $photoGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhotoGallery $photoGallery)
    {
        //
    }
}
