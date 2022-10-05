<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinCategoryProduct extends Model
{
    protected $table = 'join_category_theme';
    protected $primaryKey = 'join_category_themeID';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
