<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    
    public function user()
    {
        return $this->belongsTo(\App\User::Class,'user_id');
    }
    public function ostan()
    {
        return $this->belongsTo(Ostan::Class,'ostan_id');
    }
    public function city()
    {
        return $this->belongsTo(City::Class,'city_id');
    }
    public function info()
    {
        return $this->hasOne(LocationInfo::Class,'location_id');
    }
    public function bahrebardar()
    {
        return $this->hasOne(Bahrebardar::Class,'location_id');
    }
    public function requests()
    {
        return $this->hasMany(Request::Class,'location_id');
    }
    public function type()
    {
        return $this->belongsTo(HandyValue::Class,'type_id');
    }
}
