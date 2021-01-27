<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestInfo extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::Class);
    }
    public function bazr()
    {
        return $this->belongsTo(HandyValue::Class);
    }
    public function abyariType()
    {
        return $this->belongsTo(HandyValue::Class,'abyariType_id');
    }
    public function abType()
    {
        return $this->belongsTo(HandyValue::Class,'abType_id');
    }
    public function khakColor()
    {
        return $this->belongsTo(HandyValue::Class,'khakColor_id');
    }
    public function khakType()
    {
        return $this->belongsTo(HandyValue::Class,'khakType_id');
    }
}
