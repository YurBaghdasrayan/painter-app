<?php

namespace App\Services;

use App\Models\GalleryItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use Throwable;

class GalleryThumbnailService
{
    public const int MAX_WIDTH = 1400;

    public const int JPEG_QUALITY = 82;

    public function thumbRelativePathFor(string $imageRelativePath): string
    {
        $dir = dirname($imageRelativePath);
        if ($dir === '.' || $dir === '') {
            $dir = 'gallery';
        }
        $filename = pathinfo($imageRelativePath, PATHINFO_FILENAME);

        return $dir.'/thumbs/'.$filename.'_list.jpg';
    }

    public function deletePublicFile(?string $relativePath): void
    {
        if ($relativePath === null || $relativePath === '') {
            return;
        }
        $disk = Storage::disk('public');
        if ($disk->exists($relativePath)) {
            $disk->delete($relativePath);
        }
    }

    /**
     * Build or refresh list thumbnail; updates image_thumb on model (saveQuietly).
     */
    public function syncMainThumbnail(GalleryItem $item): void
    {
        $disk = Storage::disk('public');

        if (! $item->image || ! $disk->exists($item->image)) {
            $this->deletePublicFile($item->image_thumb);
            $item->forceFill(['image_thumb' => null])->saveQuietly();

            return;
        }

        $thumbPath = $this->thumbRelativePathFor($item->image);
        $thumbDir = dirname($thumbPath);
        $disk->makeDirectory($thumbDir);

        $sourcePath = $disk->path($item->image);
        $targetPath = $disk->path($thumbPath);

        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($sourcePath);
            $image->scaleDown(width: self::MAX_WIDTH);
            $image->encode(new JpegEncoder(quality: self::JPEG_QUALITY))->save($targetPath);
        } catch (Throwable $e) {
            Log::warning('gallery.thumbnail_failed', [
                'gallery_item_id' => $item->getKey(),
                'image' => $item->image,
                'message' => $e->getMessage(),
            ]);

            return;
        }

        if ($item->image_thumb && $item->image_thumb !== $thumbPath) {
            $this->deletePublicFile($item->image_thumb);
        }

        $item->forceFill(['image_thumb' => $thumbPath])->saveQuietly();
    }
}
