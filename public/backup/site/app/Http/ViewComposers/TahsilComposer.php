<?php 
namespace App\Http\ViewComposers;

use App\Models\HandyValue;

class TahsilComposer
{

    public function compose($view)
    {
        $sath = HandyValue::where('handy_id',5)->get();
        $arrSath = [];
        foreach ($sath as $value) {
            $arrSath[$value->id] = $value->title;
        }
        //Add your variables
        $view->with(['sathTahsil'=>$arrSath]);
    }
}