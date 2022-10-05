<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LocalizeController;
use App\Model\ShopCategory;

class ShopProduct extends Model
{
    use LocalizeController;

    public $timestamps = true;
    protected $table = 'shop_products';
    protected $guarded =[];
    protected $cast = [
        'meta' => 'array',
        'meta_en' => 'array'
    ];

    public function getUser()
    {
        $user = \App\User::find($this->user_id);
        if($user)
            return $user->name;
    }

    /*user detail*/
    public function getUserPost()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function admin(){
        return $this->belongsTo('App\Model\Admin', 'admin_id', 'id');
    }

    public function categories(){
        return $this->belongsToMany(ShopCategory::class, 'shop_product_category', 'product_id', 'category_id');
    }

    public function getOption(){
        return $this->hasOne(\App\Model\ShopProductOption::class, 'product_id', 'id');
    }

    public function listClass()
    {
        return array(
            'out-product'   => 'Ngoại thất',
            'in-product'   => 'Nội thất',
            'engine-product'   => 'Động cơ, An toàn',
            'operation-product'   => 'Vận hành',
        );
    }
}
