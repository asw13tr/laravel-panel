<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model{

    protected $primaryKey = 'id';
    protected $table = 'games';
    protected $fillable = [
        'title',            'slug',         'description',      'summary',          'cover',            'author',
        'game_file',        'game_url',     'game_code',        'game_video',       'game_screen',
        'game_scale',       'status',       'content',          'p_time',            'allow_comments' ];



    public function categories(){
        return $this->belongsToMany('App\GameCategory', 'conn_game_cat', 'game_id', 'game_category_id');
    }
    public function getCategories($status='published'){
        $categories = $this->categories;
        $ids = array();
        foreach($categories as $c){ $ids[] = $c->id; }
        return GameCategory::where('status', $status)->whereIn('id', $ids)->get();
    }

    public function hasCover(){ return (strlen($this->cover)>5); }
    public function getCover($which=null){ return getImgSrc($this->cover, $which); }

    public function getCategoriesUrlAdmin(){
        $urls = array();
        if($this->categories()){
            foreach( $this->categories as $item ){
                $urls[] = '<a href="'.route('panel.game.games').'?c='.$item->id.'">'.$item->title.'</a>';
            }
        }
        return implode(', ', $urls);
    }


    public function getUrl(){
        return route('game', ['id'=>$this->id, 'slug'=>$this->slug]);
    }

    public function updateCount(){
        $this->views++;
        $this->save();
    }
    public function getCount(){
        return $this->views;
    }
    public function getPublished(){
        return date('d F Y', strtotime($this->p_time));
    }

    public function getObject(){
        if(strlen($this->game_code) > 10){
            $result = $this->game_code;
        }elseif(strlen($this->game_url) > 10){
            $result = '<iframe id="objGame" src="'.$this->game_url.'" frameborder="0"></iframe>';
        }elseif(strlen($this->game_file) > 10){
            $result = $this->getSwfObject($this->game_file);
        }else{
            $result = '<div class="alert alert-danger">Oyun Blunamadı</div>';
        }
        return $result;
    }

    private function getSwfObject($swf){
        return '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
      codebase="https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
      id="flash-content" align="middle"
      class="item-direct-container resizable">
      <param name="allowScriptAccess" value="never" />
      <param name="movie" value="'.$swf.'" />
      <param name="quality" value="high" />
      <param name="wmode" value="window" />
      <param name="allowfullscreen" value="false" />
      <param name="allowfullscreeninteractive" value="false" />
      <param name="fullScreenAspectRatio" value="" />
      <param name="quality" value="" />
      <param name="play" value="true" />
      <param name="loop" value="true" />
      <param name="menu" value="" />
      <param name="hasPriority" value="true" />
      <embed src="'.$swf.'"
        class="item-direct-container resizable"
        id="objGame"
        name="flash-content"
        align="middle"
        wmode="window"
        allowfullscreen="false"
        allowfullscreeninteractive="false"
        fullScreenAspectRatio=""
        quality="high"
        play="true"
        loop="true"
        allowScriptAccess="never"
        hasPriority="true"
        type="application/x-shockwave-flash"
        pluginspage="https://www.adobe.com/go/getflashplayer"></embed>
    </object>';
    }

    public function getPercent(){
        return get_percent($this->like, $this->dislike);
    }
    public function getPercentLikeAttribute(){
        return get_percent($this->like, $this->dislike)->x;
    }
    public function getPercentDislikeAttribute(){
        return get_percent($this->like, $this->dislike)->y;
    }




}
