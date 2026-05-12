<?php

namespace App\Console\Commands;

use App\Models\GalleryItem;
use App\Services\GalleryThumbnailService;
use Illuminate\Console\Command;

class RegenerateGalleryThumbnails extends Command
{
    protected $signature = 'gallery:regenerate-thumbnails {--id= : Only this gallery_items.id}';

    protected $description = 'Rebuild image_thumb JPEGs for gallery list (max width 1400px)';

    public function handle(GalleryThumbnailService $thumbnails): int
    {
        $query = GalleryItem::query()->whereNotNull('image');

        if ($this->option('id')) {
            $query->whereKey((int) $this->option('id'));
        }

        $count = 0;
        $failed = 0;
        $query->orderBy('id')->chunkById(50, function ($items) use ($thumbnails, &$count, &$failed) {
            foreach ($items as $item) {
                if ($thumbnails->syncMainThumbnail($item)) {
                    $count++;
                    $this->line('OK #'.$item->getKey());
                } else {
                    $failed++;
                    $this->warn('Skip #'.$item->getKey().' (missing file or encode error — see storage/logs)');
                }
            }
        });

        $this->info('Thumbnails OK: '.$count.', skipped: '.$failed.'.');

        return self::SUCCESS;
    }
}
