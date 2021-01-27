<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestGetKood extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::Class,'product_id');
    }
    public function sendType()
    {
        return $this->belongsTo(HandyValue::CLass,'sendType_id');
    }
}
