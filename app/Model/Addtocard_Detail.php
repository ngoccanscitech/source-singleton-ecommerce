<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Addtocard_Detail extends Model
{
    public $timestamps = false;
    protected $table = 'addtocard_detail';
    protected $fillable =[
        'id',
        'product_id',
        'cart_id',
        'admin_id',
        'name',
        'quanlity',
        'subtotal'
    ];
}
