<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestZamin extends Model
{
    public function keshtType()
    {
        return $this->belongsTo(HandyValue::Class,'keshtType_id');
    }
    public function keshtOld()
    {
        return $this->belongsTo(Product::Class,'keshtOld_id');
    }
    public function bazrType()
    {
        return $this->belongsTo(Product::Class,'bazrType_id');
    }
}
