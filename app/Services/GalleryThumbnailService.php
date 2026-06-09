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

    public const int JPEG_QUALITY = 92;

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
    public function syncMainThumbnail(GalleryItem $item): bool
    {
        $disk = Storage::disk('public');

        $mainRelative = GalleryItem::normalizeStoredImage($item->image);
        if ($mainRelative === null || ! $disk->exists($mainRelative)) {
            $this->deletePublicFile(GalleryItem::normalizeStoredImage($item->image_thumb));
            $item->forceFill(['image_thumb' => null])->saveQuietly();

            return false;
        }

        $thumbPath = $this->thumbRelativePathFor($mainRelative);
        $thumbDir = dirname($thumbPath);
        $disk->makeDirectory($thumbDir);

        $sourcePath = $disk->path($mainRelative);
        $targetPath = $disk->path($thumbPath);

        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($sourcePath);
            $image->scaleDown(width: self::MAX_WIDTH);
            $image->encode(new JpegEncoder(quality: self::JPEG_QUALITY))->save($targetPath);
        } catch (Throwable $e) {
            Log::error('gallery.thumbnail_failed', [
                'gallery_item_id' => $item->getKey(),
                'image' => $mainRelative,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }

        $oldThumb = GalleryItem::normalizeStoredImage($item->image_thumb);
        if ($oldThumb && $oldThumb !== $thumbPath) {
            $this->deletePublicFile($oldThumb);
        }

        $item->forceFill(['image_thumb' => $thumbPath])->saveQuietly();

        return true;
    }
}
