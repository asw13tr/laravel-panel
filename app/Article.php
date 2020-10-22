<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
         'title',        'slug',        'keywords',         'description',
         'summary',      'author',      'status',           'content',
         'cover',        'video',       'hide_cover',      'allow_comments',    'p_time'
    ];


    public function categories(){
         return $this->belongsToMany('App\BlogCategory', 'conn_art_cat', 'article_id', 'blog_category_id');
    }
    public function getCategoriesID(){
        $result = array();
        foreach($this->categories as $k){ $result[] = $k->id; }
        return $result;
    }

    public function getCategoriesUrlAdmin(){
        $urls = array();
        foreach( $this->categories as $item ){
            $urls[] = '<a href="'.route('panel.blog.articles').'?c='.$item->id.'">'.$item->title.'</a>';
        }
        return implode(', ', $urls);
    }
/*
    public function getCategories(){

    }*/

    public function getSummary($limit=null){
        $text = strlen($this->summary)>0 ? $this->summary : $this->description;
        return $limit>0? mb_substr($text, 0, $limit, 'utf-8') : $text ;
    }

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
    public function getPublished(){
        return dateTR(date('d m Y', strtotime($this->p_time)));
    }

    public function hasCover(){
        return (strlen($this->cover) > 10);
    }
    public function getCover($which=null){
        return getImgSrc($this->cover, $which);
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

    public function getReadTime(){
        $dk = round( ( (strlen($this->content)*3)/60 ) / 60 );
        if($dk > 10){
            $fark = $dk - 10;
            $dk = round( 10 + ($fark * 0.35) );
        }
        return $dk;
    }

    public function getUrl(){
        return route('post', ['slug'=>substr($this->slug,0), 'id'=>$this->id]);
    }





    public function getKeywords(){
        $keywords = explode(',', $this->keywords);
        array_map('trim', $keywords);
        return $keywords;
    }

    public function related(){
        $limit = 10;
        $keywords = $this->getKeywords();
        $result = null;
        if($keywords){
            $result = Article::where('status', 'published')
                        ->where('id', '!=', $this->id)
                        ->where('p_time', '<=', date('Y-m-d- H:i:s'))
                        ->orderBy('views','desc')
                        ->where(function($query)use($keywords){
                            foreach ($keywords as $k => $keyword) {
                                if(strlen($keyword) > 2){
                                    $query = $query->orWhere('keywords', $keyword);
                                    $query = $query->orWhere('keywords', 'like', '%,'.$keyword.',%');
                                    $query = $query->orWhere('keywords', 'like', $keyword.',%');
                                    $query = $query->orWhere('keywords', 'like', '%,'.$keyword);
                                }
                            }
                        })
                        ->inRandomOrder()
                        ->limit($limit);
            $result = $result->get();

            if($result->count() < $limit){
                $newLimit = $limit - $result->count();
                $ids = $this->getCategoriesID();

                $otherResult = Article::where('status', 'published')
                        ->where('id', '!=', $this->id)
                        ->where('p_time', '<=', date('Y-m-d- H:i:s'))
                        ->whereHas('categories', function($query)use($ids){
                            foreach ($ids as $id) {
                                $query = $query->orWhere('blog_category_id', $id);
                            }
                        })
                        ->inRandomOrder()
                        ->limit($newLimit);
                $result = $result->merge($otherResult->get());
            }

        }else{
            $ids = $this->getCategoriesID();
            $otherResult = Article::where('status', 'published')
                    ->where('id', '!=', $this->id)
                    ->where('p_time', '<=', date('Y-m-d- H:i:s'))
                    ->whereHas('categories', function($query)use($ids){
                        foreach ($ids as $id) {
                            $query = $query->orWhere('blog_category_id', $id);
                        }
                    })
                    ->inRandomOrder()
                    ->limit($limit);
            $result = $otherResult->get();
        }


        return $result;

    }

}
