<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestClinicItem extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::Class);
    }
}
