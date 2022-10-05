<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PriceConfig extends Model
{
    protected $fillable = [
        'from',
        'to',
        'slug',
        'from_unit',
        'to_unit',
        'status',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];
    public CONST UNITS = [
        'trieu' => 'Triệu',
        'ty' => 'Tỷ',
    ];
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/price-configs/'.$this->getKey());
    }
}
