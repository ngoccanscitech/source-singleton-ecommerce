<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopProductVariable extends Model
{
    public $timestamps = false;
    protected $table = 'shop_product_variable';
    protected $guarded    = [];

    public function getFinalPrice()
    {
        if($this->promotion > 0)
            return $this->promotion;
        return $this->price;
    }
    
    public function getVariable()
    {
        return $this->hasOne(\App\Variable::class, 'id', 'variable_id');
    }
    public function getVariableParent()
    {
        return $this->hasOne(ThemeVariable::class, 'id', 'parent');
    }
    public function getVariableChild()
    {
        return $this->hasOne(ThemeVariable::class, 'parent', 'id');
    }
}
