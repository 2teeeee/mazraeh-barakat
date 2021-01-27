<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestAlaf extends Model
{
    public function alaf()
    {
        return $this->belongsTo(HandyValue::Class,'alaf_id');
    }
}
