<?php

namespace App;
use DB;

use App\Models;
use App\Models\BrokerKood;
use App\Models\KoodReq;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uname', 'email', 'password', 'codemelli', 'mobile', 'name', 'status', 'code', 'address', 'check_email', 'check_mobile',
        'father_name', 'birth_date', 'level_tahsil', 'reshte_tahsil','num_pahne','ostan_id','city_id','bakhsh_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function info()
    {
        return $this->hasOne(Models\UserInfo::Class,'user_id');
    }
    
    public function roles()
    {
        return $this->belongsToMany(Models\Role::Class);
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
    }

    public function authorizeCheck($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || 0;
      }
      return $this->hasRole($roles) || 0;
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
    }
    
    public function checkRole($role)
    {
      return null !== $this->roles()->find($role);
    }
    
    public function clinic()
    {
        return $this->belongsTo(Models\Clinic::Class,'user_id');
    }
    public function city()
    {
        return $this->belongsTo(Models\City::Class,'city_id');
    }
    public function bags()
    {
        return $this->hasMany(Models\Bag::Class,'user_id');
    }
    public function mainBag()
    {
        return $this->bags()->where('isMain',1)->first();
    }
    public function keshts()
    {
        return $this->hasMany(Models\UserKesht::Class,'user_id');
    }
    public function keshtCity()
    {
        return $this->keshts()->select('*', DB::raw('SUM(square) as sum'))
        ->groupBy('user_keshts.product_id')
        ->groupBy('user_keshts.abType_id')
        ->groupBy('user_keshts.ct_id')
        ->orderBy('ct_id')
        ->orderBy('product_id')
        ->get();
    }
    public function shotooies()
    {
        return $this->hasMany(Models\ShotooiValue::Class,'user_id');
    }
    public function shotooiProd()
    {
        return $this->shotooies()->select('*', DB::raw('SUM(value) as sum'))
        ->groupBy('shotooi_values.product_id')
        ->orderBy('product_id')
        ->get();
    }
	
    public function keshtProduct($prod,$ab,$ct)
    {
        return $this->keshts()->select('*', DB::raw('SUM(square) as sum'))
        ->where('user_keshts.product_id',$prod)
        ->where('user_keshts.abType_id',$ab)
        ->where('user_keshts.ct_id',$ct)
        ->first();
    }
    public function koods()
    {
        return $this->hasMany(Models\KoodReq::Class,'user_id');
    }
    public function getKoodProduct($prod,$ab,$ct,$kood)
    {
        return $this->koods()->select('*', DB::raw('SUM(value) as sumVal'))
        ->where('kood_reqs.product_id',$prod)
        ->where('kood_reqs.abType_id',$ab)
        ->where('kood_reqs.ct_id',$ct)
        ->where('kood_reqs.kood_id',$kood)
        ->where('kood_reqs.status','>',0)
        ->first();
    }
    
    public function takhsis()
    {
        return $this->hasMany(BrokerKood::Class,'broker_id');
    }
    
    public function koodAdd($id)
    {
        $add = $this->takhsis()->where('kood_id',$id)->where('type',1)->sum('tonne');
        $del = $this->takhsis()->where('kood_id',$id)->where('type',0)->sum('tonne');
        return $add - $del;
    }
    public function koodRemove($id)
    {
		$kood = KoodReq::select(DB::raw('sum(tbl_kood_reqs.value) as kise'),
								 DB::raw('ROUND(sum(tbl_kood_reqs.value * 50 / 1000),1) as tone'))
			->where('kood_reqs.status','>',0)
			->where('kood_reqs.broker_id',$this->id)
			->where('kood_reqs.kood_id',$id)->first();
    //    return $this->takhsis()->where('kood_id',$id)->where('type',-1)->sum('tonne');
		return $kood->tone;
    }
    public function koodVal($id)
    {
        return $this->koodAdd($id) - $this->koodremove($id);
    }
    public function koodValBag($id)
    {
        return $this->koodVal($id) * 1000 / 50;
    }
    
    
    public function brokerReq()
    {
        return $this->hasMany(KoodReq::Class,'broker_id');
    }
    public function brokerReqNewCount()
    {
        return $this->brokerReq()->where('status',1)
                ->where('kood_reqs.make_date','>=',date('Y-m-d', strtotime('-5 days')))->count();
    }
    public function brokerReqSendCount()
    {
        return $this->brokerReq()->where('status',2)->count();
    }
    public function brokerReqLastCount()
    {
        return $this->brokerReq()->where('status',1)
                ->where('kood_reqs.make_date','<',date('Y-m-d', strtotime('-5 days')))->count();
    }
    public function brokerReqBackCount()
    {
        return $this->brokerReq()->where('status',-1)->count();
    }
}
