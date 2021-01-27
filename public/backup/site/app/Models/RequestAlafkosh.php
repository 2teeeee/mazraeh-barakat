<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestAlafkosh extends Model
{
    public function alafkosh()
    {
        return $this->belongsTo(HandyValue::Class,'alafkosh_id');
    }
}
