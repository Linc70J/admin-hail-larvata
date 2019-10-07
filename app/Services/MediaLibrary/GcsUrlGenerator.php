<?php


namespace App\Services\MediaLibrary;

use DateTimeInterface;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\FilesystemManager;
use Spatie\MediaLibrary\UrlGenerator\BaseUrlGenerator;
use Storage;

class GcsUrlGenerator extends BaseUrlGenerator
{
    /** @var FilesystemManager */
    protected $filesystemManager;

    public function __construct(Config $config, FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;

        parent::__construct($config);
    }

    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl(): string
    {
        $disk = Storage::disk($this->media->disk);
        return $disk->url($this->getPathRelativeToRoot());
    }

    /**
     * Get the temporary url for a media item.
     *
     * @param DateTimeInterface $expiration
     * @param array $options
     *
     * @return string
     */
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return $this
            ->filesystemManager
            ->disk($this->media->disk)
            ->temporaryUrl($this->getPath(), $expiration, $options);
    }

    /**
     * Get the url to the directory containing responsive images.
     *
     * @return string
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        return config('medialibrary.gcs.domain') . '/' . $this->pathGenerator->getPathForResponsiveImages($this->media);
    }
}
