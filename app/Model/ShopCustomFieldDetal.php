<?php
#S-Cart/Core/Front/Models/ShopCustomFieldDetail.php
namespace SCart\Core\Front\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;
class ShopCustomFieldDetail extends Model
{
    public $timestamps     = false;
    public $table          = 'shop_custom_field_detail';
    protected $guarded     = [];

}
