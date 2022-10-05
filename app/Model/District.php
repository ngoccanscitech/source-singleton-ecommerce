<?php

namespace App\Model;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use Filterable;
    protected $fillable = [
        'name',
        'type',
        'lat',
        'lng',
        'slug',
        'city_id',
    ];


    protected $dates = [

    ];
    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */
    public function getResourceUrlAttribute()
    {
        return url('/admin/districts/'.$this->getKey());
    }

    public function salesNew(){
        return $this->hasMany(SalesNews::class, 'district_id', 'id');
    }

    public function province(){
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function wards(){
        return $this->hasMany( Ward::class, 'district_id', 'id' );
    }

    /**
     * SCROPE
     */

    public function scopeHaNoi($builder){
        return $builder->where('city_id', 1);
     }
}
