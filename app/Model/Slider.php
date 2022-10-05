<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public $timestamps = false;
    protected $table = 'sliders';
    protected $fillable =[
        'id',
        'slider_id',
        'name',
        'src',
        'src_mobile',
        'order',
        'link',
        'description',
        'target',
        'link_target',
        'created',
        'updated',
        'status'
    ];

    public function slides(){
        return $this->hasMany(Slider::class, 'slider_id', 'id');
    }
}
