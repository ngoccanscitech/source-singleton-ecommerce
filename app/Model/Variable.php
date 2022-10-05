<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    public $timestamps = true;
    protected $table = 'shop_variable';
    protected $guarded =[];

    public function get_child()
    {
        return $this->hasMany(Variable::class, 'parent', 'id')->orderBy('stt', 'asc');
    }

    public function renderNameinCart($id)
    {
        if($this->id = $id)
            return $this->name;
    }
}
