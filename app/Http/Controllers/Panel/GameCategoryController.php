<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use App\GameCategory;
use Illuminate\Http\Request;
use App\Helpers\ASWHelper;

class GameCategoryController extends Controller{

    public function __construct(){
        $this->middleware('panelAccessPermission');
    }

    public function index(){
        return view('panel/game/categories', ['headTitle'=>'Oyun Kategorileri']);
    }


    public function create(){
        //
    }


    public function store(Request $request){
        $category = GameCategory::create($request->all());

        // Makale görseli güncelleniyor.
        $category->update( ['cover'=>$request->get('cover', null)] );
        setAlertFixed("Kategori Oluşturuldu.");
        return redirect( route('panel.game.categories') );
    }


    public function show(GameCategory $gameCategory){
        //
    }


    public function edit(GameCategory $gameCategory){
        $categories = GameCategory::whereNotIn('status', ["trash"])->orderBy('id','DESC')->get();
        $datas = [
          'items' => $categories,
          'category' => $gameCategory,
          'headTitle'=>'Oyun kategorisini düzenle'
        ];
        return view('panel/game/categories', $datas);
    }


    public function update(Request $request, GameCategory $gameCategory){
        $gameCategory->update( $request->all() );
        $gameCategory->update( ['cover'=>$request->get('cover', null)] );

        setAlertFixed("Kategori güncelleme başarılı.");
        return redirect( route('panel.game.category.edit', ['gameCategory'=>$gameCategory]) );
    }


    public function destroy(GameCategory $gameCategory)
    {
        if($gameCategory->status == "trash"){

            $id = $gameCategory->id;
            $title = $gameCategory->title;
            $gameCategory->delete();
            setAlertFixed('<strong>'.$title.'</strong> başlıklı yazı tamamen silindi.');
        }else{
           $gameCategory->update( ['status'=> "trash"] );
           setAlertFixed("Kategori çöpe taşındı.");
        }
        return redirect()->route('panel.game.categories');
    }



    public function published(GameCategory $gameCategory){
         $gameCategory->update( ['status'=>'published'] );
         setAlertFixed("Kategori yayımlandı.");
         return redirect( url()->previous() );
    }
    public function draft(GameCategory $gameCategory){
         $gameCategory->update( ['status'=>'draft'] );
         setAlertFixed("Kategori taslak olarak kaydedildi..");
         return redirect( url()->previous() );
    }



}
