<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    protected $table = 'requests';
    protected $fillable = ['payStatus'];
    
    public function location()
    {
        return $this->belongsTo(Location::Class);
    }
    public function info()
    {
        return $this->hasOne(RequestInfo::Class,'request_id');
    }
    public function zamin()
    {
        return $this->hasOne(RequestZamin::Class,'request_id');
    }
    public function koods()
    {
        return $this->hasMany(RequestGetKood::Class,'request_id');
    }
    public function alafs()
    {
        return $this->hasMany(RequestAlaf::Class,'request_id');
    }
    public function alafkoshs()
    {
        return $this->hasMany(RequestAlafkosh::Class,'request_id');
    }
    public function files()
    {
        return $this->hasMany(RequestFile::Class,'request_id');
    }
    public function clinics()
    {
        return $this->hasMany(RequestClinic::Class,'request_id');
    }
    public function clinicSelect()
    {
        $instance = $this->clinics()->where('clinic_id', $this->clinic_id)->first();
        return $instance;
    }
    public function order()
    {
        return $this->hasOne(RequestOrder::Class,'request_id');
    }
    public function clinicOrder()
    {
        $instance = $this->hasMany(RequestClinic::Class,'request_id');
        $instance->where('clinic_id', $this->clinic_id);
        return $instance;
    }
    public function others()
    {
        return $this->hasMany(RequestOther::Class,'request_id');
    }
    public function getKood()
    {
        return $this->hasOne(RequestGetKood::Class,'request_id');
    }
    public function paymentOk()
    {
        return $this->hasMany(RequestPay::Class,'request_id')->where('status', 1);
    }
    public function paymentSum()
    {
        return $this->paymentOk->sum('price');
    }
}
