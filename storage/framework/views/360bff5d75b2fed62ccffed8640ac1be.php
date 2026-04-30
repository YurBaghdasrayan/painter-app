<?php $__env->startSection('title', $item->localized('title') ?? 'Artwork'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $galleryContent = $staticPage?->localizedContent() ?? [];
        $showHero = $galleryContent['show_hero'] ?? [];
        $showHeroTitle = $showHero['title'] ?? ($item->localized('title') ?? 'Artwork');
        $showHeroSubtitle = $showHero['subtitle'] ?? ($item->localized('short_description') ?? '');

        $showHeroBg = $showHero['background_image'] ?? null;
        $showHeroBgUrl = $showHeroBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($showHeroBg)
            : null;
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showHeroBgUrl || $showHeroTitle || $showHeroSubtitle): ?>
        <section class="artwork-show-hero" aria-label="Artwork hero">
            <div class="artwork-show-hero__top">
                <div class="artwork-show-hero__inner">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showHeroTitle): ?>
                        <h1 class="artwork-show-hero__title"><?php echo e($showHeroTitle); ?></h1>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showHeroSubtitle): ?>
                        <div class="artwork-show-hero__subtitle"><?php echo e($showHeroSubtitle); ?></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="artwork-show-hero__visual" aria-hidden="true">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showHeroBgUrl): ?>
                    <img class="artwork-show-hero__bg" src="<?php echo e($showHeroBgUrl); ?>" alt="">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <svg class="artwork-show-hero__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path
                        d="M0 60
                           C120 105 220 15 360 42
                           C520 74 620 18 760 52
                           C930 92 1050 62 1180 34
                           C1280 12 1360 30 1440 10
                           L1440 0
                           L0 0
                           Z"
                        fill="var(--gallery-bg)"
                    />
                </svg>

                <svg class="artwork-show-hero__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path
                        d="M0 104
                           C120 132 210 58 332 86
                           C476 118 620 90 760 110
                           C910 132 1050 92 1188 74
                           C1302 58 1376 76 1440 66"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <section class="artwork" aria-label="Artwork">
        <div class="artwork-inner">
            <header class="artwork-hero">
                <div class="artwork-hero-left">
                    <h2 class="artwork-title"><?php echo e($item->localized('title')); ?></h2>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item->localized('short_description'))): ?>
                        <div class="artwork-lead"><?php echo e($item->localized('short_description')); ?></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="artwork-hero-right">
                    <?php
                        $thumbs = array_values(array_filter([
                            $item->secondary_image,
                            $item->third_image,
                            $item->fourth_image,
                        ]));
                    ?>

                    <div class="artwork-hero-image">
                        <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($item->image)); ?>" alt="<?php echo e($item->localized('title')); ?>" />
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thumbs !== []): ?>
                        <div class="artwork-thumbs" aria-label="Additional images">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $thumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $thumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="artwork-thumb">
                                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($thumb)); ?>" alt="<?php echo e($item->localized('title')); ?>" loading="lazy" />
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </header>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item->localized('full_description'))): ?>
                <div class="artwork-body">
                    <div class="artwork-body-text">
                        <?php echo nl2br(e($item->localized('full_description'))); ?>

                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <section class="related" aria-label="Related artworks">
                <div class="related-head">
                    <h2 class="related-title">
                        <?php echo e($item->localized('same_line_title') ?: 'FROM THE SAME LINE'); ?>

                    </h2>
                </div>

                <div class="related-grid" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="related-card" role="listitem">
                            <a class="related-link" href="<?php echo e(route('gallery.show', $related->slug)); ?>" aria-label="<?php echo e($related->localized('title')); ?>">
                                <div class="related-image">
                                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($related->image)); ?>" alt="<?php echo e($related->localized('title')); ?>" loading="lazy" />
                                </div>
                                <div class="related-meta">
                                    <div class="related-item-title"><?php echo e($related->localized('title')); ?></div>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </section>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/gallery/show.blade.php ENDPATH**/ ?>