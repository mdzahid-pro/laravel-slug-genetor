<?php

namespace Mdzahid\LaravelSlugGenerator\Facades;

use Illuminate\Support\Facades\Facade;

class GenerateSlug extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "generate-slug";
    }
}
