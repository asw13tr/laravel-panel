<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model{
     public  $table = 'game_categories';
     public  $fillable = [
          'title',
          'slug',
          'description',
          'parent',
          'cover',
          'status'
     ];

    public function games(){
        return $this->belongsToMany('App\Game', 'conn_game_cat', 'game_category_id', 'game_id');
    }

    public function gamesCount(){
        $id = $this->id;
        return \App\Game::whereHas('categories', function($query) use($id){
            $query->where('game_category_id', $id);
        })->count();
    }

    public function hasCover(){ return (strlen($this->cover)>5); }
    public function getCover($which=null){ return getImgSrc($this->cover, $which); }

    public function getUrl(){
        return route('game_category', ['slug'=>$this->slug, 'id'=>$this->id]);
    }

    public function getPopularGames(){
        $id = $this->id;
        return \App\Game::whereHas('categories', function($query) use($id){
            $query->where('game_category_id', $id);
        })->orderBy('views', 'desc')->limit(5)->get();
    }

}
