<?php

namespace App\Observers;

use App\Models\GalleryItem;
use App\Services\GalleryThumbnailService;

class GalleryItemObserver
{
    public function __construct(
        private readonly GalleryThumbnailService $thumbnails
    ) {}

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
        if (! $galleryItem->wasChanged('image') && ! $galleryItem->wasRecentlyCreated) {
            return;
        }

        $this->thumbnails->syncMainThumbnail($galleryItem);
    }
}
