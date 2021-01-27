<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['*'], 
                'App\Http\ViewComposers\OstanComposer'
        );
        View::composer(
            ['*'], 
                'App\Http\ViewComposers\SettingComposer'
        );
        View::composer(
            ['profile.validation','profile.profile','auth.register'], 
                'App\Http\ViewComposers\TahsilComposer'
        );
    }
}
