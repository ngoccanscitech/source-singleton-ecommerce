<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ShopCustomFieldDetail;

class ShopCustomField extends Model
{
    public $timestamps     = false;
    public $table          = 'shop_custom_field';
    protected $guarded     = [];

    public function details()
    {
        $data  = (new ShopCustomFieldDetail)->where('custom_field_id', $this->id)
            ->get();
        return $data;
    }

    /**
     * Get custom fields
     */
    public function getCustomField($type) {
        return $this->where('type', $type)
            ->where('status', 1)
            ->get();
    }

}
