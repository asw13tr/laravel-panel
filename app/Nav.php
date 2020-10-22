<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Nav extends Model{

    protected $table = "navigations";
    protected $fillable = [ 'name', 'slug', 'type', 'parent', 'url', 'target', 'css', 'menu_order' ];

    public function items(){
        return Nav::where(['type'=>'item', 'parent'=>$this->id])->orderBy('menu_order')->get();
    }

}
