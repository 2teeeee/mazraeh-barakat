<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOrderOffer extends Model
{
    public function order()
    {
        return $this->belongsTo(RequestOrder::Class,'request_order_id');
    }

    public function store()
    {
        return $this->belongsTo(Location::Class,'store_id');
    }
    public function prices()
    {
        return $this->hasMany(RequestOrderOfferPrice::Class,'request_order_offer_id');
    }
    public function sumPrice()
    {
        return $this->prices()->sum('price');
    }
}
