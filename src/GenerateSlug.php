<?php

namespace Mdzahid\LaravelSlugGenerator;

use Arr;
use Str;

class GenerateSlug
{
    public function slug(
        $sluggable_text,
        $model_name,
        $is_module = false,
        $module_name = null,
        $column_name = 'slug'
    ): string  // Idea from Suzon extended by Md Zahid
    {
        // Use CamelCase for Model and Module Name
        $model_path = $is_module ? 'Modules\\' . ucwords($module_name) . '\Entities\\' . ucwords($model_name) :
            '\App\Models\\' . ucwords($model_name);

        $slug = Str::slug($sluggable_text, config("generate-slug.separator"));
        $check = true;

        do {
            $old_collection = (new $model_path())->where($column_name, $slug)
                ->orderBy('id', 'DESC')->first();

            if ($old_collection != null) {
                $old_collection_name = $old_collection->$column_name;
                $exploded = explode('-', $old_collection_name);

                if (array_key_exists(1, $exploded)) {
                    $number = end($exploded);

                    if (is_numeric($number)) {
                        $number = (int)$number;
                        array_pop($exploded);

                        $final_array = array_merge($exploded, Arr::wrap(++$number));

                        $slug = implode('-', $final_array);
                    } else {
                        $slug .= '-1';
                    }
                } else {
                    $slug .= '-1';
                }
            } else {
                $check = false;
            }
        } while ($check);

        return $slug;
    }
}
