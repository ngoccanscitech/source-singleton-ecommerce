<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserWalletLog extends Model
{
    public $timestamps = true;
    protected $table = 'user_wallet_logs';
    protected $guarded =[];

}
