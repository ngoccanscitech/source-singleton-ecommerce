<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Harimayco\Menu\Facades\Menu;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;

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
        $this->registerRouteMiddleware();
    }   

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('templatePath', env('APP_THEME', 'demo'));
        view()->share('templateFile', env('APP_THEME', 'demo'));
        
        //
        Shortcode::add('slider', function($atts, $id, $items=3) 
        {
            $data = Shortcode::atts([
                'id' => $id,
                'items' => $items
            ], $atts);

            $file = 'partials/shortcode/slider' ; // ex: resource/views/partials/ $atts['name'] .blade.php
            // dd($data);
            if (view()->exists($file)) {
                return view($file, compact('data'));
            }
        });
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }


    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'currency' => \App\Http\Middleware\Currency::class
    ];


}
