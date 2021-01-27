<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShotooiValue extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::Class,'product_id');
    }
}
