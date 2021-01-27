<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahrebardar extends Model
{
    public function type()
    {
        return $this->belongsTo(HandyValue::Class,'type_id');
    }
}
