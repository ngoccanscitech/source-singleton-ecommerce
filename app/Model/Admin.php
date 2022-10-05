<?php

namespace App\Model;

use App\Post;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admins';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'admin_level', 'email_info', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function theme() {
    	return $this->hasMany('App\Model\Theme', 'admin_id', 'id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'admin_id', 'id');
    }
}