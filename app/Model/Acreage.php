<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Acreage extends Model
{
    protected $fillable = [
        'from',
        'to',
        'slug',
        'status',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/acreages/'.$this->getKey());
    }
}
