<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Thongke extends Model
{
    public $timestamps = false;
    protected $table = 'theme_thongke';
    protected $fillable =[
        'theme_id',
        'view',
        'click',
        'phone',
    ];

}
