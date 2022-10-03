<?php

namespace App\Providers;

use App\Models\PackageRequest;
use App\UserSetting;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        try {
            view()->composer('*', function ($view) {
                if (Auth::check()) {
//                $oldRequest = PackageRequest::with('package')->onlyTrashed()->where('active',1)->where('user_id', Auth::user()->id)->get();
                    $oldRequest = [];
                } else {
                    $oldRequest = [];
                }
                $view->with('oldRequest', $oldRequest);
            });

            View::share('userSettings', UserSetting::where('user_id', 3)->first());
        } catch (\Exception $e) {
            //
        }
    }
}
