<?php

namespace App\Observers;

use App\Models\GalleryItem;
use App\Services\GalleryThumbnailService;

class GalleryItemObserver
{
    public function __construct(
        private readonly GalleryThumbnailService $thumbnails
    ) {}

    public function saving(GalleryItem $galleryItem): void
    {
        if (! $galleryItem->isDirty('image')) {
            return;
        }

        $normalized = GalleryItem::normalizeStoredImage($galleryItem->image);
        $galleryItem->image = $normalized;
    }

    public function updating(GalleryItem $galleryItem): void
    {
        if ($galleryItem->isDirty('image')) {
            $this->thumbnails->deletePublicFile($galleryItem->getOriginal('image_thumb'));
        }
    }

    public function deleted(GalleryItem $galleryItem): void
    {
        $this->thumbnails->deletePublicFile($galleryItem->image_thumb);
    }

    public function saved(GalleryItem $galleryItem): void
    {
        // wasChanged('image') is unreliable here (cleared before saved in some flows).
        $before = GalleryItem::normalizeStoredImage($galleryItem->getOriginal('image'));
        $after = GalleryItem::normalizeStoredImage($galleryItem->image);
        if ($before === $after) {
            return;
        }

        $this->thumbnails->syncMainThumbnail($galleryItem);
    }
}
