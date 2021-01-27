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
        $add = $this->takhsis()->where('kood_id',$id)->where('type',1)->where('status',1)->sum('tonne');
        $del = $this->takhsis()->where('kood_id',$id)->where('type',1)->where('status',-1)->sum('tonne');
        return $add - $del;
    }
    public function koodRemove($id)
    {
        $add = $this->takhsis()->where('kood_id',$id)->where('type',2)->where('status',1)->sum('tonne');
        $del = $this->takhsis()->where('kood_id',$id)->where('type',2)->where('status',-1)->sum('tonne');
		
		return $add - $del;
    }
    public function koodVal($id)
    {
        return $this->koodAdd($id) - $this->koodremove($id);
    }
	
	public function koodReq()
    {
        return $this->hasMany(KoodReq::Class,'ct_id','ct_id');
    }
	
    public function ReqKoodSumAll($id,$ab_type,$product_id,$startDate,$endDate)
    {
        $response = $this->koodReq()->where('kood_id',$id)->where('status','>',0);
		if($ab_type <> '')
		{
			$response->where('kood_reqs.abType_id',$ab_type);
		}
		if($product_id <> '')
		{
			$response->where('kood_reqs.product_id',$product_id);
		}
		if($startDate <> '')
		{
			$st = $startDate;
			$dt = explode('/', $st);
			
			$yearStart =  $dt[0];
			$monthStart = $dt[1];
			$dayStart = $dt[2];
			
			$start = \Morilog\Jalali\CalendarUtils::toGregorian($yearStart, $monthStart, $dayStart); // [2016, 5, 7]
			$startDate = $start[0].'-'.$start[1].'-'.$start[2];
			
			$response->whereDate('kood_reqs.make_date','>=',$startDate);
		}
		if($endDate <> '')
		{
			$st = $endDate;
			$dt = explode('/', $st);
			
			$yearEnd =  $dt[0];
			$monthEnd = $dt[1];
			$dayEnd = $dt[2];
			
			$end = \Morilog\Jalali\CalendarUtils::toGregorian($yearEnd, $monthEnd, $dayEnd); // [2016, 5, 7]
			$endDate = $end[0].'-'.$end[1].'-'.$end[2];
			
			$response->whereDate('kood_reqs.make_date','<=',$endDate);
		}
		
		$add = $response->sum('value');
        return $add * 50 / 1000;
    }
    public function ReqKoodSumTahvil($id,$ab_type,$product_id,$startDate,$endDate)
    {
        $response = $this->koodReq()->where('kood_id',$id)->where('status',2);
		if($ab_type <> '')
		{
			$response->where('kood_reqs.abType_id',$ab_type);
		}
		if($product_id <> '')
		{
			$response->where('kood_reqs.product_id',$product_id);
		}
		if($startDate <> '')
		{
			$st = $startDate;
			$dt = explode('/', $st);
			
			$yearStart =  $dt[0];
			$monthStart = $dt[1];
			$dayStart = $dt[2];
			
			$start = \Morilog\Jalali\CalendarUtils::toGregorian($yearStart, $monthStart, $dayStart); // [2016, 5, 7]
			$startDate = $start[0].'-'.$start[1].'-'.$start[2];
			
			$response->whereDate('kood_reqs.make_date','>=',$startDate);
		}
		if($endDate <> '')
		{
			$st = $endDate;
			$dt = explode('/', $st);
			
			$yearEnd =  $dt[0];
			$monthEnd = $dt[1];
			$dayEnd = $dt[2];
			
			$end = \Morilog\Jalali\CalendarUtils::toGregorian($yearEnd, $monthEnd, $dayEnd); // [2016, 5, 7]
			$endDate = $end[0].'-'.$end[1].'-'.$end[2];
			
			$response->whereDate('kood_reqs.make_date','<=',$endDate);
		}
		
		$add = $response->sum('value');
        return $add * 50 / 1000;
    }
	
}
