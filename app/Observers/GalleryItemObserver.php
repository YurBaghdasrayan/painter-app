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
        if ($galleryItem->isDirty('image')) {
            $normalized = GalleryItem::normalizeStoredImage($galleryItem->image);
            $galleryItem->image = $normalized;
        }

        if ($galleryItem->isDirty('detail_images')) {
            $galleryItem->detail_images = GalleryItem::normalizeDetailImagesArray($galleryItem->detail_images);
        }
    }

    public function updating(GalleryItem $galleryItem): void
    {
        if ($galleryItem->isDirty('image')) {
            $this->thumbnails->deletePublicFile($galleryItem->getOriginal('image_thumb'));
        }

        if ($galleryItem->isDirty('detail_images')) {
            $old = GalleryItem::normalizeDetailImagesArray($galleryItem->getOriginal('detail_images'));
            $new = GalleryItem::normalizeDetailImagesArray($galleryItem->detail_images);
            foreach (array_diff($old, $new) as $removed) {
                $this->thumbnails->deletePublicFile($removed);
            }
        }
    }

    public function deleted(GalleryItem $galleryItem): void
    {
        $this->thumbnails->deletePublicFile($galleryItem->image_thumb);
        foreach (GalleryItem::normalizeDetailImagesArray($galleryItem->detail_images) as $path) {
            $this->thumbnails->deletePublicFile($path);
        }
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
