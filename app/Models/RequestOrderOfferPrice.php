<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOrderOfferPrice extends Model
{
    public function orderProduct()
    {
        return $this->belongsTo(RequestOrderProduct::Class,'request_order_product_id');
    }
}
