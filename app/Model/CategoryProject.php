<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryProject extends Model
{
    public $timestamps = true;
    protected $table = 'category_project';
    protected $fillable =[
        'title',
        'slug',
        'description',
        'title_en',
        'description_en',
        'category_id',
        'stt',
        'status',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'image',
        'cover',
        'icon',
        'gallery',
        'showhome',
    ];

    public function children() {
        return $this->hasMany(CategoryProject::class, 'category_id', 'id')->orderByDesc('stt');
    }

    public function project()
    {
        return $this->belongsToMany('App\Model\Project', 'App\Model\Join_Category_Project', 'category_id', 'project_id');
    }
}
