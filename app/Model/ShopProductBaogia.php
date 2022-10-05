<?php

namespace App\Model;
use App\Traits\LocalizeController;

use Illuminate\Database\Eloquent\Model;

class ShopProductBaogia extends Model
{
    use LocalizeController;

    public $timestamps = true;
    protected $table = 'shop_product_baogia';
    protected $guarded =[];

    public function getUser()
    {
        return $this->hasOne(\App\User::class, 'id', 'user_id');
    }
}
