<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'page';

    public static function search(string $keyword){
        $keyword = '%' . addslashes($keyword) . '%';
        $result = self::select('id', 'title', 'slug', 'description')
            ->where('title', 'like', $keyword)
            ->orWhere('parent', 'like', $keyword)
            ->get();
        return $result;
    }

    public function getContentAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'content_' . $lc};
        }
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
}
