<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // By default is true, but set it explicitly
    public $timestamps = true;
    
    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }

    public function tags()
    {
    	return $this->belongsToMany('App\Tag');
    }

    public function categories()
    {
    	return $this->belongsTo('App\Category');
    }

    public function hasImage(): bool
    {
        return filled($this->image_file_name);
    }
}