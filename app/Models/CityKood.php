<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CityKood extends Model
{
    public function kood()
    {
        return $this->belongsTo(Product::Class,'kood_id');
    }
    public function city()
    {
        return $this->belongsTo(City::Class,'city_id');
    }
    public function user()
    {
        return $this->belongsTo(User::Class,'user_id');
    }
    
}
