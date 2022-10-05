<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    public $timestamps = false;
    protected $table = 'investors';
    protected $fillable =[
        'title',
        'slug',
        'description',
        'content',
        'title_en',
        'description_en',
        'content_en',
        'image',
        'cover',
        'status'
    ];
}
