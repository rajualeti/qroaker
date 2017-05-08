<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Auth\Authenticatable;
use App\User;
use App\Setting;
use Illuminate\Support\ServiceProvider;
use App\Customer;
use App\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory as ViewFactory;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
    	Setting::getAllSettings();
    	
    	$view->composer('*', 'App\Http\ViewComposers\GlobalComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
