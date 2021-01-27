<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestOrderProduct extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::Class);
    }
}
