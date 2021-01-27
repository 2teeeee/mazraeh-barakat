<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function ostan()
    {
        return $this->belongsTo(Ostan::Class);
    }
    
    public function takhsis()
    {
        return $this->hasMany(CityKood::Class,'city_id');
    }
    
    public function koodAdd($id)
    {
        $add = $this->takhsis()->where('kood_id',$id)->where('type',1)->sum('tonne');
        $del = $this->takhsis()->where('kood_id',$id)->where('type',0)->sum('tonne');
        return $add - $del;
    }
    public function koodRemove($id)
    {
        return $this->takhsis()->where('kood_id',$id)->where('type',-1)->sum('tonne');
    }
    public function koodVal($id)
    {
        return $this->koodAdd($id) - $this->koodremove($id);
    }

    
}
