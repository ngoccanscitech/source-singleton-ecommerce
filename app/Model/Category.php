<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $table = 'post_category';
    protected $guarded =[];

    public function post()
    {
        return $this->belongsToMany('App\Model\Post', 'App\Model\Join_Category_Post', 'id_category', 'id_post');
    }
}
