<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model{

    protected $table = "photo_galleries";
    protected $fillable = [ 'name', 'slug', 'type', 'parent', 'url', 'alt', 'info', 'menu_order'];

}
