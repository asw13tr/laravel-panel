<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use App\Page;
use Illuminate\Http\Request;
use App\Helpers\ASWHelper;

class PageController extends Controller{


    public function __construct(){
        $this->middleware('panelAccessPermission');
    }

    public function index(Request $request){
        $datas = [  'items' => $this->getPagesWithSub(0, -1, $request->get('s', null)), 'headTitle'=>'Sayfalar'    ];
        return view("panel/page/pages", $datas);
    }


    public function create(){
        $datas = [  'pages' => $this->getPagesWithSub(0, -1), 'headTitle'=>'Yeni sayfa ekle'    ];
        return view('panel/page/page-form', $datas);
    }

    public function store(Request $request){
        $goUrl = url()->previous();
        // POST VERİLERİ İLE MODEL OLUŞTURULUYOR.
        $page = Page::create( $request->all() );
        $page->update( [
            'cover'=> $request->get('cover', null),
            'allow_comments' => $request->get('allow_comments', 'off'),
            'hide_cover' => $request->get('hide_cover', 'off')
            ] );

        // UYARI VE YÖNLENDİRME
        setAlertFixed('<strong>'.$page->title.'</strong> başlıklı sayfa oluşturuldu.');
        $goUrl = route('panel.page.edit', ['page'=>$page] );
        return redirect( $goUrl );
    }



    public function edit(Page $page){
        $datas = [  'pages' => $this->getPagesWithSub(0, -1), 'data' => $page, 'headTitle'=>'Sayfayı düzenle'   ];
        return view('panel/page/page-form', $datas);
    }

    public function update(Request $request, Page $page){
        if($request->get('status', 'null')=="trash" && $page->status=="trash"){ return $this->destroy($page); }
        $goUrl = url()->previous();
        // POST VERİLERİ İLE MODEL OLUŞTURULUYOR.
        $page->update( $request->all() );
        $page->update( [
            'cover'=> $request->get('cover', null),
            'allow_comments' => $request->get('allow_comments', 'off'),
            'hide_cover' => $request->get('hide_cover', 'off')
            ] );

        // UYARI VE YÖNLENDİRME
        setAlertFixed('<strong>'.$page->title.'</strong> başlıklı sayfa güncellendi.');
        $goUrl = route('panel.page.edit', ['page'=>$page] );
        return redirect( $goUrl );
    }


    public function destroy(Page $page){
        if($page->status != 'trash'){
             $page->update( ['status' => 'trash'] );
             setAlertFixed('<strong>'.$page->title.'</strong> başlıklı sayfa çöpe taşındı.');
             $goUrl = url()->previous();
        }else{
             $id = $page->id;
             $title = $page->title;
             $page->delete();
             setAlertFixed('<strong>'.$title.'</strong> başlıklı sayfa tamamen silindi.');
             $goUrl = route('panel.page.pages');
        }
        return redirect( $goUrl );
    }








    public function change_cover_visibilty(Page $page){
        $newValue = $page->hide_cover=="on"? "off" : "on" ;
        $page->update( ['hide_cover'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $page->hide_cover),
            'class'  => getBool($page->hide_cover, "on", "danger", "success")
        ];
        return response()->json($datas);
    }
    public function change_comments_permissions(Page $page){
        $newValue = $page->allow_comments=="on"? "off" : "on" ;
        $page->update( ['allow_comments'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $page->allow_comments),
            'class'  => getBool($page->allow_comments, "on", "success", "danger")
        ];
        return response()->json($datas);
    }
    public function change_status(Page $page){
        $newValue = $page->status!="published"? "published" : "draft";
        $page->update( ['status'=>$newValue] );
        $datas = [
            'status' => getBool($newValue, $page->status),
            'class' => getBool($page->status, "published", "success", "danger")
        ];
        return response()->json( $datas );
    }










    private function getPagesWithSub($parent = 0, $repeat = -1, $status='published'){
         $items = null;
         $datas = Page::where('parent', $parent);
         if($status!=null){ $datas = $datas->where('status',  $status); }
         $datas = $datas->orderBy('id', 'desc');
         if($datas->count() > 0){
              $items = array();
              $repeat++;
              foreach($datas->cursor() as $data){
                   array_push($items, [
                        'data' => $data,
                        'repeat' => $repeat
                   ]);
                   $subItems = $this->getPagesWithSub($data->id, $repeat, $status);
                   if($subItems != null){
                        $items = array_merge($items, $subItems);
                   }
              }
         }
         return $items;
    }
}
