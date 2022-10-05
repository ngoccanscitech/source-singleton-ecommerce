<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;
    protected $table = 'post';
    protected $guarded =[];

    public function category_post()
    {
        return $this->belongsToMany('App\Model\Category', 'post_category_join', 'post_id', 'category_id');
    }
}
