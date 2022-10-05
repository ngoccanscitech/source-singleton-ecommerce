<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = true;
    protected $table = 'shop_brand';
    protected $guarded =[];

    public function getNameAttribute($value){
        $lc = app()->getLocale();
        if('vi' == $lc){
            return $value;
        } else {
            return $this->{'name_' . $lc};
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

    public function listLocation()
    {
        $data = array(
            'mienbac'   => 'Miền Bắc',
            'mientrung'   => 'Miền Trung',
            'miennam'   => 'Miền Nam'
        );
        return $data;
    }
}
