<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps = false;
    protected $table = 'wishlist';
    protected $fillable =[
        'product_id',
        'user_id'
    ];

    public function product(){
        return $this->hasOne('App\Product', 'id', 'product_id')->orderByDesc('theme.updated_at');
    }
}
