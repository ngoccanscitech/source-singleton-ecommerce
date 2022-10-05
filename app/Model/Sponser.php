<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sponser extends Model
{
    public $timestamps = false;
    protected $table = 'sponser';
    protected $fillable =[
        'name',
        'thumbnail',
        'link',
        'status',
        'order',
        'created',
        'updated'
    ];
}
