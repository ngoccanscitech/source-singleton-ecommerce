<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Addtocard extends Model
{
    public $timestamps = true;
    public $primaryKey = 'cart_id';
    protected $table = 'addtocard';
    protected $guarded =[];
}
