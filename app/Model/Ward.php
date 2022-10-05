<?php

namespace App\Model;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use Filterable;
    protected $fillable = [
        'name',
        'type',
        'district_id',
        'slug',
    ];


    protected $dates = [

    ];
    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/wards/'.$this->getKey());
    }

    public function salesNew(){
        return $this->hasMany(SalesNews::class);
    }

    public function district(){
        return $this->belongsTo( District::class, 'district_id', 'id' );
    }
}
