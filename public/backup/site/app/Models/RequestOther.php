<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOther extends Model
{
    public function offers()
    {
        return $this->hasMany(RequestOtherOffer::Class,'request_other_id');
    }
    public function hasOffer()
    {
        return $this->hasOne(RequestOtherOffer::Class,'request_other_id');
    }
    public function selectOffer()
    {
        return $this->offers()->where('status',1)->first();
    }
    public function type()
    {
        return $this->belongsTo(HandyValue::CLass,'type_id');
    }
    public function request()
    {
        return $this->belongsTo(Req::Class,'request_id');
    }
}
