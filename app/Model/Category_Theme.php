<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category_Theme extends Model
{
    public $timestamps = true;
    protected $table = 'category_theme';
    protected $guarded =[];

    protected $primaryKey = 'categoryID';

    public function supplier()
    {
        return $this->belongsTo(\App\Model\Supplier::class, 'supplier_id');
    }

    public function children() {
        return $this->hasMany(Category_Theme::class, 'categoryParent', 'categoryID')->orderByDesc('categoryShort');
    }

    public function join_category_theme() {
        return $this->hasMany(\App\Model\Join_Category_Theme::class, 'id_category_theme','categoryID');
    }

    public function themes()
    {
        return $this->belongsToMany(Theme::class, 'join_category_theme','id_category_theme', 'id_theme');
    }
}
