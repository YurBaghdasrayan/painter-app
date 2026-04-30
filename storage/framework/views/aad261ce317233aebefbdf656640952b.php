<?php
    /** @var \App\Models\GallerySection $section */
    $items = $section->items ?? collect();
    $coverItem = $items->first();
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coverItem && !empty($coverItem->image)): ?>
    <article class="gallery-section-card" role="listitem">
        <a class="gallery-section-card-link" href="<?php echo e(route('gallery.section', $section)); ?>" aria-label="<?php echo e($section->localized('title')); ?>">
            <div class="gallery-section-card-image">
                <img
                    src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image)); ?>"
                    alt="<?php echo e($section->localized('title')); ?>"
                    loading="lazy"
                />
            </div>

            <div class="gallery-section-card-meta">
                <div class="gallery-section-card-title">
                    “<?php echo e(strtoupper((string) ($section->localized('title') ?? 'Gallery'))); ?>”
                </div>

                <?php
                    $desc = trim((string) ($section->localized('left_text') ?? ''));
                    if ($desc === '') {
                        $desc = trim((string) ($section->localized('right_text') ?? ''));
                    }
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($desc !== ''): ?>
                    <div class="gallery-section-card-desc">
                        <?php echo e($desc); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </a>
    </article>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /var/www/html/painter-app/resources/views/gallery/partials/section-card.blade.php ENDPATH**/ ?>