<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use \App\Model\ShopProduct;
use App\Traits\LocalizeController;
use App\Post;

class ShopCategory extends Model
{
    use LocalizeController;
    
    public $timestamps = true;
    protected $table = 'shop_category';
    protected $guarded =[];

    public function supplier()
    {
        return $this->belongsTo(\App\Model\Supplier::class, 'supplier_id');
    }

    public function children() {
        return $this->hasMany(ShopCategory::class, 'parent', 'id')->orderBy('priority');
    }

    public function theParent(){
        return $this->belongsTo(ShopCategory::class, 'parent', 'id');
    }

    public function join_category_theme() {
        return $this->hasMany(\App\Model\Join_Category_Theme::class, 'id_category_theme','categoryID');
    }

    public function themes()
    {
        return $this->belongsToMany(ShopProduct::class, 'shop_product_category', 'category_id', 'product_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'shop_product_category', 'category_id', 'product_id');
    }

    public function getOption(){
        return $this->hasOne(\App\Model\ShopCategoryOption::class, 'category_id', 'id');
    }
}