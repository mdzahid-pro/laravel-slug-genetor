<?php

namespace Mdzahid\LaravelSlugGenerator;

use Arr;
use Illuminate\Support\Str;
use Str;

class GenerateSlug
{
    public function slug(
        $sluggable_text,
        $model_name,
        $is_module = false,
        $module_name = null,
        $column_name = 'slug'
    ): string {
        // Use CamelCase for Model and Module Name
        $model_path = $is_module ? 'Modules\\' . ucwords($module_name) . '\Entities\\' . ucwords($model_name) :
            '\App\Models\\' . ucwords($model_name);

        $slug = Str::slug($sluggable_text, config("generate-slug.separator"));

        // Check if the slug already exists
        $existingSlug = (new $model_path())->where($column_name, $slug)->exists();

        if ($existingSlug) {
            // If the slug exists, append a numeric suffix
            $suffix = 1;
            do {
                $newSlug = $slug . '-' . $suffix;
                $existingSlug = (new $model_path())->where($column_name, $newSlug)->exists();
                $suffix++;
            } while ($existingSlug);

            return $newSlug;
        }

        return $slug;
    }
}
