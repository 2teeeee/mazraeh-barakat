<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKesht extends Model
{
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
}
