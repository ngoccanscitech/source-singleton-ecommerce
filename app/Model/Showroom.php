<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    public $timestamps = false;
    protected $table = 'showroom';
    protected $guarded = [];

    /*
    *gallery
    */
    public function getGallery(){
        if($this->gallery!='')
            return unserialize($this->gallery);
        return '';
    }
    public function countGallery(){
        if($this->gallery!='')
            return count(unserialize($this->gallery));
        return 0;
    }
}
