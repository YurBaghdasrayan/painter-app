<?php $__env->startSection('title', $heroSection?->localized('title') ?? 'Gallery'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $heroTitle = $staticPage?->getBlock('hero')['title'] ?? ($heroSection?->localized('title') ?? 'Art Gallery');
        $heroSubtitle = $staticPage?->getBlock('hero')['subtitle'] ?? ($heroSection?->localized('left_text') ?? '');

    $bottomFeature = $staticPage?->getBlock('bottom_feature_section') ?? [];
    $bottomFeatureTitle = $bottomFeature['title'] ?? null;
    $bottomFeatureItems = collect($bottomFeature['items'] ?? [])->filter()->values();
    $bottomFeatureButtonLink = $bottomFeature['button_link'] ?? null;

    $bottomFeatureImage = $bottomFeature['image'] ?? null;

    if (is_array($bottomFeatureImage)) {
        $bottomFeatureImage = $bottomFeatureImage[0] ?? null;
    }

    if (empty($bottomFeatureImage) && $staticPage) {
        foreach (['en', 'ru', 'am'] as $fallbackLocale) {
            $fallbackBlock = $staticPage->getBlock('bottom_feature_section', $fallbackLocale);
            $candidateImage = $fallbackBlock['image'] ?? null;

            if (is_array($candidateImage)) {
                $candidateImage = $candidateImage[0] ?? null;
            }

            if (!empty($candidateImage)) {
                $bottomFeatureImage = $candidateImage;
                break;
            }
        }
    }
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
            $topGridSections = $sections->count() > 5 ? $sections->take(5) : $sections;
            $sliderSections = $sections->take(5);
            $tailSections = $sections->count() > 5 ? $sections->slice(5)->values() : collect();
            $sectionsSliderId = 'gallery-index-sections-slider';
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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sections->count() > 1): ?>
            <section class="gallery-index-slider" aria-label="All gallery sections">
                <div class="gallery-index-slider-inner">
                    <div class="gallery-index-slider-wrap">
                        <button
                            class="gallery-index-slider-arrow gallery-index-slider-arrow--left"
                            type="button"
                            data-gallery-slider-prev="<?php echo e($sectionsSliderId); ?>"
                            data-gallery-index-slider-nav="prev"
                            hidden
                            aria-hidden="true"
                            aria-label="Previous"
                        ></button>

                        <button
                            class="gallery-index-slider-arrow gallery-index-slider-arrow--right"
                            type="button"
                            data-gallery-slider-next="<?php echo e($sectionsSliderId); ?>"
                            data-gallery-index-slider-nav="next"
                            hidden
                            aria-hidden="true"
                            aria-label="Next"
                        ></button>

                        <div
                            class="gallery-index-slider-track"
                            id="<?php echo e($sectionsSliderId); ?>"
                            data-gallery-index-slider-track="<?php echo e($sectionsSliderId); ?>"
                            role="list"
                        >
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sliderSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $coverItem = ($section->items ?? collect())->first();
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coverItem && !empty($coverItem->image)): ?>
                                    <article class="gallery-index-slider-card" role="listitem">
                                        <a class="gallery-index-slider-card-link" href="<?php echo e(route('gallery.section', $section)); ?>">
                                            <div class="gallery-index-slider-image">
                                                <img
                                                    src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image)); ?>"
                                                    alt="<?php echo e($section->localized('title')); ?>"
                                                    loading="lazy"
                                                >
                                            </div>

                                            <div class="gallery-index-slider-meta">
                                                <div class="gallery-index-slider-section-title">
                                                    “<?php echo e(strtoupper((string) ($section->localized('title') ?? 'Gallery'))); ?>”
                                                </div>

                                                <?php
                                                    $desc = trim((string) ($section->localized('left_text') ?? ''));
                                                    if ($desc === '') {
                                                        $desc = trim((string) ($section->localized('right_text') ?? ''));
                                                    }
                                                ?>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($desc !== ''): ?>
                                                    <div class="gallery-index-slider-section-desc">
                                                        <?php echo e($desc); ?>

                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </a>
                                    </article>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tailSections->count()): ?>
                <section class="gallery-index-tail" aria-label="More gallery sections">
                    <div class="gallery-index-tail-inner">
                        <div class="gallery-masonry" role="list">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tailSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $coverItem = ($section->items ?? collect())->first();
                                ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coverItem && !empty($coverItem->image)): ?>
                                    <article class="gallery-masonry-card" role="listitem">
                                        <a class="gallery-masonry-card-link" href="<?php echo e(route('gallery.section', $section)); ?>">
                                            <div class="gallery-masonry-image">
                                                <img
                                                    src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image)); ?>"
                                                    alt="<?php echo e($section->localized('title')); ?>"
                                                    loading="lazy"
                                                >
                                            </div>

                                            <div class="gallery-masonry-meta">
                                                <div class="gallery-masonry-title">“GALLERY”</div>

                                                <?php
                                                    $desc = trim((string) ($section->localized('left_text') ?? ''));
                                                    if ($desc === '') {
                                                        $desc = trim((string) ($section->localized('right_text') ?? ''));
                                                    }
                                                ?>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($desc !== ''): ?>
                                                    <div class="gallery-masonry-desc"><?php echo e($desc); ?></div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </a>
                                    </article>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomFeatureTitle || $bottomFeatureItems->count() || $bottomFeatureImage): ?>

        <section class="gallery-bottom-feature" aria-label="Gallery bottom feature">
            <div class="gallery-bottom-feature-inner">
                <div class="gallery-bottom-feature-content">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomFeatureTitle): ?>
                        <h2 class="gallery-bottom-feature-title">“<?php echo e($bottomFeatureTitle); ?>”</h2>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomFeatureItems->count()): ?>
                        <ul class="gallery-bottom-feature-list">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bottomFeatureItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureText): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo $featureText; ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="gallery-bottom-feature-media">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomFeatureImage): ?>
                        <img
                            src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($bottomFeatureImage)); ?>"
                            alt="<?php echo e($bottomFeatureTitle ?? 'Gallery feature image'); ?>"
                            class="gallery-bottom-feature-image"
                        >
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomFeatureButtonLink): ?>
                        <a href="<?php echo e($bottomFeatureButtonLink); ?>" class="gallery-bottom-feature-arrow" aria-label="Open feature">
                            <span>→</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function () {
            function scrollSlider(sliderEl, direction) {
                if (!sliderEl) return;
                var card = sliderEl.querySelector('.gallery-index-slider-card');
                var step = card ? (card.getBoundingClientRect().width + 18) : 320;
                sliderEl.scrollBy({ left: direction * step, behavior: 'smooth' });
            }

            function updateGalleryIndexSliderNav(sliderId) {
                var track = document.querySelector('[data-gallery-index-slider-track="' + sliderId + '"]');
                if (!track) return;

                var wrap = track.closest('.gallery-index-slider-wrap');
                if (!wrap) return;

                var prev = wrap.querySelector('[data-gallery-index-slider-nav="prev"]');
                var next = wrap.querySelector('[data-gallery-index-slider-nav="next"]');
                if (!prev || !next) return;

                var overflowing = track.scrollWidth - track.clientWidth > 1;

                track.classList.toggle('is-overflowing', overflowing);

                prev.hidden = !overflowing;
                next.hidden = !overflowing;
                prev.setAttribute('aria-hidden', overflowing ? 'false' : 'true');
                next.setAttribute('aria-hidden', overflowing ? 'false' : 'true');
            }

            function bindGalleryIndexSlider(sliderId) {
                var track = document.querySelector('[data-gallery-index-slider-track="' + sliderId + '"]');
                if (!track) return;

                var ro = null;
                if (typeof ResizeObserver !== 'undefined') {
                    ro = new ResizeObserver(function () {
                        updateGalleryIndexSliderNav(sliderId);
                    });
                    ro.observe(track);
                }

                window.addEventListener('resize', function () {
                    updateGalleryIndexSliderNav(sliderId);
                });

                track.addEventListener('scroll', function () {
                    updateGalleryIndexSliderNav(sliderId);
                }, { passive: true });

                window.addEventListener('load', function () {
                    updateGalleryIndexSliderNav(sliderId);
                });

                Array.prototype.forEach.call(track.querySelectorAll('img'), function (img) {
                    if (img.complete) return;
                    img.addEventListener('load', function () {
                        updateGalleryIndexSliderNav(sliderId);
                    }, { once: true });
                });

                requestAnimationFrame(function () {
                    updateGalleryIndexSliderNav(sliderId);
                });
            }

            document.addEventListener('click', function (e) {
                var prev = e.target.closest('[data-gallery-slider-prev]');
                if (prev) {
                    if (prev.hidden) return;
                    var id = prev.getAttribute('data-gallery-slider-prev');
                    scrollSlider(document.getElementById(id), -1);
                    return;
                }

                var next = e.target.closest('[data-gallery-slider-next]');
                if (next) {
                    if (next.hidden) return;
                    var id2 = next.getAttribute('data-gallery-slider-next');
                    scrollSlider(document.getElementById(id2), 1);
                }
            });

            bindGalleryIndexSlider(<?php echo json_encode($sectionsSliderId ?? 'gallery-index-sections-slider', 15, 512) ?>);
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/balasona/public_html/resources/views/gallery/index.blade.php ENDPATH**/ ?>