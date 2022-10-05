<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project_Join_Variable extends Model
{
    public $timestamps = false;
    protected $table = 'project_join_variable';
    protected $fillable =[
        'project_id',
        'variable_id',
        'code',
        'img',
		'icon',
        'price',
		'description',
		'theme_code',
        'status',
    ];

    public function getVariable()
    {
        return $this->hasOne(\App\Model\Variable::class, 'id', 'variable_id');
    }
}
