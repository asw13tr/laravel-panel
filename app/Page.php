<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Page extends Model{

    protected $table = 'pages';
    protected $fillable = [
            'title',            'slug',         'description',      'content',
            'cover',            'parent',       'status',           'hide_cover',
            'allow_comments',   'p_time',       'video'         ];

    public function hasCover(){ return (strlen($this->cover)>5); }
    public function getCover($which=null){ return getImgSrc($this->cover, $which); }
    public function updateCount(){
        if(!Session::get('view_'.$this->id, false)){
            $this->views++;
            $this->save();
            Session::put('view_'.$this->id, true);
        }
    }
    public function getCount(){
        return number_format($this->views, 0, '.', '.');
    }
    public function showCover(){
        return $this->hide_cover=="on"? false : true;
    }

    public function getVideoUrl(){
        if(strlen($this->video) < 10){
            return false;
        }
        $id = getYoutubeVideoId($this->video);
        return $id? 'https://www.youtube.com/embed/'.$id.'?rel=0' : false;
    }
    public function getUrl(){
        return route('page', ['slug'=>$this->slug, 'id'=>$this->id]);
    }

}
