<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    protected $table = 'project';
    
    protected $fillable =[
        'id',
        'title',
        'slug',
        'price',
        'acreage',
        'apartment',
        'villa',
        'description',
        'content',
        'image',
        'cover',
        'icon',
        'gallery',
        'stt',
        'status',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'province_id',
        'district_id',
        'ward_id',
        'street_id',
        'street',
        'address',
        'stage_id',
        'investor_id',
    ];

    /*
    *Format price
    */
    public function getPrice()
    {
        $price = $this->price;
        $m = '<span class="project-unit">triệu/m²</span>';
        if($price > 0){
            $price = (0 + str_replace(",", "", $price));
           
            // is this a number?
            if(!is_numeric($price)) return false;
           
            // now filter it;
            if($price>1000000000000) return round(($price/1000000000000),1).'<span class="project-unit"> nghìn tỷ/m²</span>';
            else if($price>1000000000) return round(($price/1000000000),2).' <span class="project-unit">tỷ/m²</span>';
            else if($price>1000000) return round(($price/1000000),1).' <span class="project-unit">triệu/m²</span>';
            else if($price>1000) return round(($price/1000),1).' <span class="project-unit">VNĐ/m²</span>';
            return '<span class="project-unit">'. number_format($price) .'/m²</span>';
        }
        else
            return __('Cập nhật...');
    }

    public function getAcreage()
    {
        $acreage = $this->acreage;
        if($acreage !='' && $acreage > 0){
            //1 ha = 10 000m2
            $ha = round($acreage / 10000, 2);
            return $ha;
        }
    }

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
    //Trang thai du an
    public function getStage(){
        $stage = \App\Model\Stage::findorfail($this->stage_id);
        return $stage->name;
    }

    public function category_post()
    {
        return $this->belongsToMany('App\Model\Category', 'App\Model\Join_Category_Post', 'id_post', 'id_category');
    }

    public function getInvestor()
    {
        return $this->hasOne(\App\Model\Investor::class, 'id', 'investor_id');
    }

}
