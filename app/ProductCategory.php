<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'shop_category';
    
    public function products(){
        return $this->belongsToMany('App\Product', 'shop_product_category', 'category_id', 'product_id')->orderByDesc('shop_products.updated_at');
    }
    
    public function getCategoryNameAttribute($value){
        $lc = app()->getLocale();
        if('en' == $lc){
            return $value;
        } else {
            return $this->{'categoryName_' . $lc};
        }
    }
    public function getCategoryDescriptionAttribute($value){
        $lc = app()->getLocale();
        if('en' == $lc){
            return $value;
        } else {
            return $this->{'categoryDescription_' . $lc};
        }
    }
    public function getCategoryContentAttribute($value){
        $lc = app()->getLocale();
        if('en' == $lc){
            return $value;
        } else {
            return $this->{'categoryContent_' . $lc};
        }
    }

    public function children() {
        return $this->hasMany(ProductCategory::class, 'parent', 'id')->orderBy('priority', 'asc');
    }
    public function parent() {
        return $this->hasOne(ProductCategory::class, 'categoryID', 'categoryParent');
    }

    public function getDetail($id, $type = '')
    {
        $detail = new ProductCategory;
        if($type == 'slug')
            $detail = $detail->where('slug', $id);
        else
            $detail = $detail->where('id', $id);

        $detail = $detail->first();
        return $detail;
    }
}
