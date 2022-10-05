<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopEmailTemplate extends Model
{
    public $timestamps = false;
    public $table = 'shop_email_template';
    protected $guarded = [];

}
