<?php $__env->startSection('title', $heroSection?->localized('title') ?? 'Gallery'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $heroTitle = $staticPage?->getBlock('hero')['title'] ?? ($heroSection?->localized('title') ?? 'Art Gallery');
        $heroSubtitle = $staticPage?->getBlock('hero')['subtitle'] ?? ($heroSection?->localized('left_text') ?? '');
    ?>

    <?php $__env->startSection('meta_description', strip_tags((string) $heroSubtitle)); ?>

    <section class="gallery-hero" aria-label="Gallery hero">
        <div class="gallery-hero-inner">
            <h1 class="gallery-hero-title">
                <?php echo e($heroTitle); ?>

            </h1>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heroSubtitle)): ?>
                <p class="gallery-hero-subtitle">
                    <?php echo e($heroSubtitle); ?>

                </p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="gallery-hero-art">
            <div class="gallery-hero-art-bg">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroItem && !empty($heroItem->image)): ?>
                    <img
                        src="<?php echo e(asset('assets/images/gallery.hero.bg.png')); ?>"
                        alt="<?php echo e($heroItem->localized('title')); ?>"
                    >
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <svg class="gallery-hero-wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
                <path
                    d="M0 60
                       C120 105 220 15 360 42
                       C520 74 620 18 760 52
                       C930 92 1050 62 1180 34
                       C1280 12 1360 30 1440 10
                       L1440 0
                       L0 0
                       Z"
                    fill="#f7f5ef"
                />
            </svg>

            <svg class="gallery-hero-stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroItem && !empty($heroItem->image)): ?>
                <article class="gallery-hero-featured">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSection): ?>
                        <a href="<?php echo e(route('gallery.section', $heroSection)); ?>" class="gallery-hero-featured-link">
                            <img
                                src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($heroItem->image)); ?>"
                                alt="<?php echo e($heroItem->localized('title')); ?>"
                            >
                        </a>
                    <?php else: ?>
                        <div class="gallery-hero-featured-link">
                            <img
                                src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($heroItem->image)); ?>"
                                alt="<?php echo e($heroItem->localized('title')); ?>"
                            >
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </article>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sections->count()): ?>
        <?php
            $head = $sections->first();
            $topGridSections = $sections;
        ?>

        <section class="gallery-index" aria-label="Gallery index">
            <div class="gallery-inner">
                <div class="gallery-head">
                    <h2 class="gallery-title"><?php echo e($head->localized('title')); ?></h2>

                    <div class="gallery-toptexts">
                        <div class="gallery-toptext gallery-toptext--left">
                            <?php echo nl2br(e($head->localized('left_text') ?? '')); ?>

                        </div>
                        <div class="gallery-toptext gallery-toptext--right">
                            <?php echo nl2br(e($head->localized('right_text') ?? '')); ?>

                        </div>
                    </div>
                </div>

                <div class="gallery-section-grid" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topGridSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('gallery.partials.section-card', ['section' => $section], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/gallery/index.blade.php ENDPATH**/ ?>