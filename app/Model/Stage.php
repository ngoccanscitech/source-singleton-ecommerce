<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public $timestamps = false;
    protected $table = 'stage';
    
    protected $fillable =[
        'title',
    ];
}
