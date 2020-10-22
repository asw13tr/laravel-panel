<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nav;
class NavController extends Controller
{

    public function index(){
        $navs = Nav::where('type', 'menu')->get();
        $datas =  [
            'items' => $navs,
            'headTitle' => "Menüler"
        ];
        return view('panel/nav/navs', $datas);
    }


    public function createMenu(Request $request){
        if($request->get('navName')){
            Nav::create([
                'name' => $request->get('navName'),
                'type' => 'menu',
                'slug' => $request->get('navSlug'),
            ]);
        }
        return redirect( route('panel.navs') );
    }

    public function deleteMenu(Request $request, Nav $menu){
        $menuID = $menu->id;
        $delete = $menu->delete();
        if($delete){
            Nav::where('parent', $menuID)->delete();
        }
        return redirect( route('panel.navs') );
    }






    public function items(Request $request, Nav $menu){
        $items = Nav::where('parent',$menu->id)->where('type','item')->orderBy('menu_order')->get();
        $datas = [
            'headTitle' => 'Menü Düzenle',
            'menu' => $menu,
            'items' => $items
        ];
        return view('panel/nav/items', $datas);
    }




    public function createItem(Request $request, Nav $menu){
        $item = Nav::create($request->all());
        $target = $request->get('target', false)? true : false ;
        $item->update([ 'type'=>'item', 'parent'=>$menu->id, 'target'=>$request->get('target') ]);
        return redirect( route('panel.nav.items', ['menu'=>$menu]) );
    }
    public function deleteItem(Request $request, Nav $item){
        $menu = $item->parent;
        $item->delete();
        return redirect( route('panel.nav.items', ['menu'=>$menu]) );
    }

}
