<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinCategoryNews extends Model
{
    protected $table = 'join_category_post';
    protected $primaryKey = 'join_category_postID';
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
