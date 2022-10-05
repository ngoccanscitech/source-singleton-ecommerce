<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Join_Category_Project extends Model
{
    public $timestamps = false;
    protected $table = 'join_category_project';
    public $incrementing = false;
    protected $fillable =[
        'project_id',
        'category_id'
    ];
}
