<?php

namespace Mdzahid\LaravelSlugGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Mdzahid\LaravelSlugGenerator\GenerateSlug;

class GenerateSlugServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([__DIR__ . "../../../config/generate-slug.php" => config_path('generate-slug.php')],'generate-slug');

        $this->mergeConfigFrom(__DIR__ . '../../../config/generate-slug.php','generate-slug');
    }

    public function register()
    {
        app()->bind("generate-slug", function (){
            return new GenerateSlug();
        });
    }
}
