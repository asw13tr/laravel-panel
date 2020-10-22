<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{

     public  $table = 'blog_categories';
     public  $fillable = [
          'title',
          'slug',
          'description',
          'parent',
          'status'
     ];

     public function articles(){
         return $this->belongsToMany('App\Article', 'conn_art_cat', 'blog_category_id', 'article_id');
    }

    public function getUrl(){
        return route('blog_category', ['slug'=>substr($this->slug,0), 'id'=>$this->id]);
    }
}
