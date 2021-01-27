<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestClinic extends Model
{
    public function request()
    {
        return $this->belongsTo(Req::Class,'request_id');
    }
    public function clinic()
    {
        return $this->belongsTo(Location::Class,'clinic_id');
    }
    public function items()
    {
        return $this->hasMany(RequestClinicItem::Class,'request_clinic_id');
    }
}
