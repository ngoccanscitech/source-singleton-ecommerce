<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category_Join_Variable extends Model
{
    public $timestamps = false;
    protected $table = 'category_join_variable';
    protected $fillable =[
        'category_id',
        'variable_id',
    ];
}
