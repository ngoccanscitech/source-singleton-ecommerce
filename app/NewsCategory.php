<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'post_category';
    
    public function news(){
        return $this->belongsToMany('App\News', 'post_category_join', 'category_id', 'post_id');
    }
    
    public function getCategoryNameAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'categoryName_' . $lc};
        }
    }
    
    public function getCategoryDescriptionAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'categoryDescription_' . $lc};
        }
    }
}
