<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestPay extends Model
{
    protected $fillable = ['status'];
    
    public function request()
    {
        return $this->hasOne(Req::Class,'request_id');
    }
    public function requestKood()
    {
        return $this->hasMany(RequestPayKood::Class,'request_pay_id');
    }
}
