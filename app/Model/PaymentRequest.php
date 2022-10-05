<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    public $timestamps = true;
    protected $table = 'payment_request';
    protected $fillable =[
        'user_id',
        'amount',
        'status',
        'payment_method',
        'payment_status',
        'payment_code',
        'bank_code',
        'conent'
    ];
}
