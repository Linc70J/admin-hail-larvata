<?php


namespace App\Services\MediaLibrary;


use Spatie\MediaLibrary\HasMedia\HasMedia;
use Storage;

class LMedia
{
    /**
     * 將LMedia格式的文件儲存
     *
     * @param $model
     * @param $type
     * @param $collection_name
     * @param $file_name
     * @param $url
     * @return \Spatie\MediaLibrary\Models\Media|null
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
     */
    public static function save($model, $type, $collection_name, $file_name, $url)
    {
        if ($model instanceof HasMedia) {
            switch ($type) {
                case 'tmp':
                    /** @noinspection PhpUndefinedMethodInspection Laravel 5.4+ add "path" method */
                    return $model->addMedia(Storage::disk('public')->path($url))->setFileName($file_name)->toMediaCollection($collection_name);
                case 'base64':
                    return $model->addMediaFromBase64($url)->setFileName($file_name)->toMediaCollection($collection_name);
                case 'url':
                    return $model->addMediaFromUrl($url)->setFileName($file_name)->toMediaCollection($collection_name);
            }
        }
        return null;
    }
}
