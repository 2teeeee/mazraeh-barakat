<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagPay extends Model
{
    protected $fillable = ['status'];
    
    public function pay()
    {
        return $this->hasOne(RequestPay::Class,'bag_pay_id');
    }
    
}
