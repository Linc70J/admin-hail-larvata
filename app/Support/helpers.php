<?php

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Models\Media;

if (!function_exists('media_format')) {
    /**
     * @param $media
     * @return array|string
     */
    function media_format($media)
    {
        if ($media instanceof Collection) {
            $array = array();
            foreach ($media as $item) {
                $array[] = json_encode([
                    "id" => $item->id,
                    "type" => 'database',
                    "file_name" => $item->file_name,
                    "url" => $item->getUrl()
                ]);
            }
            return $array;
        }

        if ($media instanceof Media) {
            return json_encode([
                "id" => $media->id,
                "type" => 'database',
                "file_name" => $media->file_name,
                "url" => $media->getUrl()
            ]);
        }

        return '[]';
    }
}

if (!function_exists('media_to_json')) {
    /**
     * @param $type
     * @param $file_name
     * @param $url
     * @return string
     */
    function media_to_json($type, $file_name, $url)
    {
        return json_encode([
            "type" => $type,
            "file_name" => $file_name,
            "url" => $url
        ]);
    }
}

if (!function_exists('active_class')) {
    /**
     * Get the active class if the condition is not falsy
     *
     * @param        $condition
     * @param string $activeClass
     * @param string $inactiveClass
     *
     * @return string
     */
    function active_class($condition, $activeClass = 'active', $inactiveClass = '')
    {
        return $condition ? $activeClass : $inactiveClass;
    }
}
