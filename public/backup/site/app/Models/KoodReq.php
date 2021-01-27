<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class KoodReq extends Model
{
    public function kood()
    {
        return $this->belongsTo(Product::Class,'kood_id');
    }
    public function kesht()
    {
        return $this->belongsTo(UserKesht::Class,'kesht_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::Class,'product_id');
    }
    public function ab()
    {
        return $this->belongsTo(HandyValue::Class,'abType_id');
    }
    public function ct()
    {
    	return $this->belongsTo(City::Class,'ct_id','ct_id');
    }
    public function user()
    {
        return $this->belongsTo(User::Class,'user_id');
    }
    public function broker()
    {
        return $this->belongsTo(User::Class,'broker_id');
    }
    public function send()
    {
        return $this->belongsTo(HandyValue::Class,'send_id');
    }
}
