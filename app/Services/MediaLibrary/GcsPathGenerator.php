<?php


namespace App\Services\MediaLibrary;

use Carbon\Carbon;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\BasePathGenerator;

class GcsPathGenerator extends BasePathGenerator
{
    public function getPath(Media $media): string
    {
        // 資料夾規則，如：201709/{id}/
        // 資料夾切割能提高搜尋速度

        /** @var Carbon $createAt */
        $createAt = $media->{$media->getCreatedAtColumn()};
        return $createAt->format('Ym') . '/' . $this->getBasePath($media) . '/';
    }
}
