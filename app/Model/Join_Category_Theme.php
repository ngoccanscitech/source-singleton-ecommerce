<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Join_Category_Theme extends Model
{
    public $timestamps = false;
    protected $table = 'join_category_theme';
    protected $fillable =[
        'theme_id',
        'category_id'
    ];
}
