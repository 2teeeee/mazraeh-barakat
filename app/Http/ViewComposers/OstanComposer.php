<?php 
namespace App\Http\ViewComposers;

use App\Models\Ostan;

class OstanComposer
{

    public function compose($view)
    {
        //Add your variables
        $view->with(['ostans'=>Ostan::all()]);
    }
}