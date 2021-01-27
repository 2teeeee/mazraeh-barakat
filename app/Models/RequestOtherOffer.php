<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOtherOffer extends Model
{
    public function store()
    {
        return $this->belongsTo(Location::Class,'store_id');
    }
}
