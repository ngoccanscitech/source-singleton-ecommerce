<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'wallet','about_me', 'provider_id', 'provider', 'birthday', 'phone', 'created_at', 'updated_at', 'address', 'province', 'district', 'ward', 'avatar', 'status', 'remember_token', 'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rate() {
    	return $this->hasManyTo('App\Model\Rating_Product', 'user_id', 'id');
    }
}
