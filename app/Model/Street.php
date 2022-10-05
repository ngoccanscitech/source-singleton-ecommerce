<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    public $timestamps = false;
    protected $table = 'street';
    protected $fillable =[
        'name',
        'prefix',
        'district_id',
        'province_id'
    ];
}
