<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'post';
    protected $primaryKey = 'id';
    
    public function category(){
        return $this->belongsToMany('App\NewsCategory', 'post_category_join', 'post_id', 'category_id');
    }

    public static function search(string $keyword){
        $keyword = '%' . addslashes($keyword) . '%';
        $result = self::select('id', 'title', 'slug', 'description')
            ->where('title', 'like', $keyword)->paginate(12);
        return $result;
    }
    
    public function getTitleAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'title_' . $lc};
        }
    }
    
    public function getDescriptionAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'description_' . $lc};
        }
    }
    
    public function getContentAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'content_' . $lc};
        }
    }

    public function getDetail($id, $type='')
    {
        $detail = new News;
        if($type == 'slug')
            $detail = $detail->where('slug', $id);
        else
            $detail = $detail->where('id', $id);

        $detail = $detail->first();
        return $detail;
    }
}
