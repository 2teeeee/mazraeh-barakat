<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductKoodValue extends Model
{
    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $startDate = explode('/',$model->startDate);
            $startDate = \Morilog\Jalali\CalendarUtils::toGregorian($startDate[0], $startDate[1], $startDate[2]);
            $model->startDate = implode('-',$startDate);
            
            $endDate = explode('/',$model->endDate);
            $endDate = \Morilog\Jalali\CalendarUtils::toGregorian($endDate[0], $endDate[1], $endDate[2]);
            $model->endDate = implode('-',$endDate);
        });


        self::updating(function($model){
            // ... code here
        });

    }
	
	public function product()
	{
		return $this->belongsTo(Product::Class,'productCode_id','code');
	}
	public function kood()
	{
		return $this->belongsTo(Product::Class,'koodType_id','koodType_id');
	}
	public function city()
	{
		return $this->belongsTo(City::Class,'ct_id','ct_id');
	}
}
