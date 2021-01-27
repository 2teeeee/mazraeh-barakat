<?php 
namespace App\Http\ViewComposers;

use App\Models\HandyValue;
use App\Models\Product;

class SettingComposer
{

    public function compose($view)
    {
        
        $mahsoolType = Product::where('category_id',1)->get();
        $samType = Product::where('category_id',2)->get();
        $allKoodType = Product::whereIn('category_id',[3])->get();
        
        $typeMazrae = HandyValue::where('handy_id',1)->get();
        $keshtType = HandyValue::where('handy_id',2)->get();
        $bazrType = HandyValue::where('handy_id',3)->get();
        $abType = HandyValue::where('handy_id',4)->get();
        $koodType = HandyValue::where('handy_id',7)->get();
        $ecAbType = HandyValue::where('handy_id',8)->get();
        $ecKhakType = HandyValue::where('handy_id',9)->get();
        $alafType = HandyValue::where('handy_id',10)->get();
        $alafkoshType = HandyValue::where('handy_id',11)->get();
        $khakType = HandyValue::where('handy_id',12)->get();
        $khakType2 = HandyValue::where('handy_id',13)->get();
        $typeMalekiyat = HandyValue::where('handy_id',15)->get();
        $sendType = HandyValue::where('handy_id',19)->get();
        $vipType = HandyValue::where('handy_id',20)->get();
        //Add your variables
        $view->with([
            'typeMazrae'=>$typeMazrae,
            'typeMalekiyat'=>$typeMalekiyat,
            'keshtType'=>$keshtType,
            'bazrType'=>$bazrType,
            'mahsoolType' => $mahsoolType,
            'koodType' => $koodType,
            'ecAbType' => $ecAbType,
            'ecKhakType' => $ecKhakType,
            'abType' => $abType,
            'alafType' => $alafType,
            'alafkoshType' => $alafkoshType,
            'khakType' => $khakType,
            'khakType2' => $khakType2,
            'samType' => $samType,
            'allKoodType' => $allKoodType,
            'sendType' => $sendType,
            'vipType' => $vipType
        ]);
    }
}