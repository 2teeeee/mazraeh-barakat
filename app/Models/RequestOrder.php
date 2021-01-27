<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOrder extends Model
{
    public function items()
    {
        return $this->hasMany(RequestOrderProduct::Class,'request_order_id');
    }
    
    public function offers()
    {
        return $this->hasMany(RequestOrderOffer::Class,'request_order_id');
    }
    public function offerSelect()
    {
        return $this->offers()->where('status', 1)->first();
    }
    
}
