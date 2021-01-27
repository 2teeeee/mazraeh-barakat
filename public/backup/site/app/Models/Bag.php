<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{
    public function bagPays()
    {
        return $this->hasMany(BagPay::Class,'bag_id');
    }
    public function incBag()
    {
        $val = $this->bagPays()->where('status',1)->whereIn('typePay_id',[162,163])->get();
        $val = $val->sum('price');
        return $val;
    }
    public function subBag()
    {
        $val = $this->bagPays()->where('status',-1)->whereIn('typePay_id',[162,163])->get();
        $val = $val->sum('price');
        return $val;
    }
    public function credit(){
        return $this->incBag() - $this->subBag();
    }
}
