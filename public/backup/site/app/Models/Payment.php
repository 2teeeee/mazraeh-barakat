<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function paymentBag()
    {
        return $this->hasOne(BagPay::Class,'payment_id');
    }
}
