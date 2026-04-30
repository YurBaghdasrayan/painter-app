<?php $__env->startSection('title', $heroSection?->localized('title') ?? 'Collection'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $heroTitle = $staticPage?->getBlock('hero')['title'] ?? ($heroSection?->localized('title') ?? 'Collection');
        $heroSubtitle = $staticPage?->getBlock('hero')['subtitle'] ?? ($heroSection?->localized('description') ?? '');

        $sectionHero = $staticPage?->getBlock('section_hero') ?? [];
        $sectionHeroTitle = $sectionHero['title'] ?? null;
        $sectionHeroSubtitle = $sectionHero['subtitle'] ?? null;

        $sectionHeroBg = $sectionHero['background_image'] ?? null;
        $sectionHeroMain = $sectionHero['main_image'] ?? null;
        $sectionHeroCardTitle = $sectionHero['card_title'] ?? null;
        $sectionHeroCardText = $sectionHero['card_text'] ?? null;

        if (is_array($sectionHeroBg)) {
            $sectionHeroBg = $sectionHeroBg[0] ?? null;
        }

        if (is_array($sectionHeroMain)) {
            $sectionHeroMain = $sectionHeroMain[0] ?? null;
        }

        $sectionHeroBgUrl = $sectionHeroBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($sectionHeroBg)
            : null;

        $sectionHeroMainUrl = $sectionHeroMain
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($sectionHeroMain)
            : null;

        $lastSection = $staticPage?->getBlock('last_section') ?? [];
        $lastTitle = $lastSection['title'] ?? null;
        $lastSubtitle = $lastSection['subtitle'] ?? null;
        $lastImage = $lastSection['image'] ?? null;
        $lastButtonLink = $lastSection['button_link'] ?? null;
        $lastLeftText = $lastSection['left_text'] ?? null;
        $lastRightText = $lastSection['right_text'] ?? null;

        if (is_array($lastImage)) {
            $lastImage = $lastImage[0] ?? null;
        }

        $lastImageUrl = $lastImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($lastImage)
            : null;

        $galleryTextBlock = $staticPage?->getBlock('gallery_text_block') ?? [];
        $galleryTextLeftTitle = $galleryTextBlock['left_title'] ?? null;
        $galleryTextLeft = $galleryTextBlock['left_text'] ?? null;
        $galleryTextRightTitle = $galleryTextBlock['right_title'] ?? null;
        $galleryTextRight = $galleryTextBlock['right_text'] ?? null;

        $videosSection = $staticPage?->getBlock('videos_section') ?? [];
        $videosTitle = $videosSection['title'] ?? null;
        $videosSubtitle = $videosSection['subtitle'] ?? null;
        $leftYoutubeUrl = $videosSection['left_youtube_url'] ?? null;
        $rightYoutubeUrl = $videosSection['right_youtube_url'] ?? null;
        $leftThumb = $videosSection['left_thumbnail_image'] ?? null;
        $rightThumb = $videosSection['right_thumbnail_image'] ?? null;
        $videosLeftText = $videosSection['left_text'] ?? null;
        $videosRightText = $videosSection['right_text'] ?? null;

        if (is_array($leftThumb)) {
            $leftThumb = $leftThumb[0] ?? null;
        }
        if (is_array($rightThumb)) {
            $rightThumb = $rightThumb[0] ?? null;
        }

        $leftThumbUrl = $leftThumb ? \Illuminate\Support\Facades\Storage::disk('public')->url($leftThumb) : null;
        $rightThumbUrl = $rightThumb ? \Illuminate\Support\Facades\Storage::disk('public')->url($rightThumb) : null;

        $extractYoutubeId = function ($url) {
            if (!is_string($url) || $url === '') return null;
            $u = parse_url($url);
            $host = strtolower((string) ($u['host'] ?? ''));
            $path = (string) ($u['path'] ?? '');
            parse_str((string) ($u['query'] ?? ''), $q);
            if (isset($q['v']) && is_string($q['v']) && $q['v'] !== '') return $q['v'];
            if (str_contains($host, 'youtu.be')) return ltrim($path, '/');
            if (str_contains($host, 'youtube.com') && str_starts_with($path, '/embed/')) {
                return trim(substr($path, strlen('/embed/')));
            }
            return null;
        };

        $leftYoutubeId = $extractYoutubeId($leftYoutubeUrl);
        $rightYoutubeId = $extractYoutubeId($rightYoutubeUrl);

        $topSections = ($sections ?? collect())
            ->filter(fn ($s) => ($s->items ?? collect())->first()?->image)
            ->values()
            ->take(2);
    ?>

    <?php $__env->startSection('meta_description', strip_tags((string) $heroSubtitle)); ?>

    <section class="collection-hero-fixed" aria-label="Collection hero">
        <div class="collection-hero-fixed__inner">
            <h1 class="collection-hero-fixed__title">
                <?php echo e($sectionHeroTitle ?: $heroTitle); ?>

            </h1>

            <?php
                $subtitle = $sectionHeroSubtitle ?: $heroSubtitle;
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($subtitle)): ?>
                <p class="collection-hero-fixed__subtitle">
                    <?php echo e($subtitle); ?>

                </p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="collection-hero-fixed__art">
            <div class="collection-hero-fixed__bg">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sectionHeroBgUrl): ?>
                    <img
                        src="<?php echo e($sectionHeroBgUrl); ?>"
                        alt="<?php echo e($sectionHeroTitle ?: $heroTitle); ?>"
                    >
                <?php elseif($heroItem && !empty($heroItem->image)): ?>
                    <img
                        src="<?php echo e(asset('assets/images/gallery.hero.bg.png')); ?>"
                        alt="<?php echo e($heroItem->localized('title')); ?>"
                    >
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <svg class="collection-hero-fixed__wave-top" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
                <path
                    d="M0 68
                       C110 120 220 20 360 48
                       C520 80 640 20 790 54
                       C965 92 1090 72 1225 36
                       C1320 12 1385 22 1440 8
                       L1440 0
                       L0 0
                       Z"
                    fill="#f7f5ef"
                />
            </svg>

            <svg class="collection-hero-fixed__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
                <path
                    d="M0 104
                       C120 138 240 54 366 84
                       C520 120 660 88 798 106
                       C960 126 1084 92 1216 70
                       C1312 54 1382 72 1440 62"
                    fill="none"
                    stroke="#ffffff"
                    stroke-width="5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sectionHeroMainUrl || ($heroItem && !empty($heroItem->image))): ?>
                <?php
                    $featuredImg = $sectionHeroMainUrl ?: \Illuminate\Support\Facades\Storage::disk('public')->url($heroItem->image);
                    $featuredAlt = $sectionHeroTitle ?: ($heroItem?->localized('title') ?? $heroTitle);
                ?>

                <div class="collection-hero-fixed__content-wrap">
                    <article class="collection-hero-fixed__featured">
                        <div class="collection-hero-fixed__image">
                            <img src="<?php echo e($featuredImg); ?>" alt="<?php echo e($featuredAlt); ?>">
                        </div>
                    </article>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sectionHeroCardTitle || $sectionHeroCardText): ?>
                        <div class="collection-hero-fixed__text">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sectionHeroCardTitle): ?>
                                <h2 class="collection-hero-fixed__card-title">
                                    “<?php echo e(strtoupper((string) $sectionHeroCardTitle)); ?>”
                                </h2>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sectionHeroCardText): ?>
                                <div class="collection-hero-fixed__card-copy">
                                    <?php echo $sectionHeroCardText; ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sections->count()): ?>
        <section id="collection" class="gallery gallery-index collection-after-hero" aria-label="Collection index">
            <div class="gallery-inner">
                <?php $head = $topSections->first(); ?>

                <div class="gallery-head">
                    <h2 class="gallery-title"><?php echo e($head?->localized('title')); ?></h2>

                    <div class="gallery-toptexts">
                        <div class="gallery-toptext gallery-toptext--left">
                            <?php echo nl2br(e($head?->localized('description') ?? '')); ?>

                        </div>
                        <div class="gallery-toptext gallery-toptext--right">
                        </div>
                    </div>
                </div>

                <div class="gallery-section-grid" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $topSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('collection.partials.section-card', ['section' => $section], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastTitle || $lastSubtitle || $lastImageUrl || $lastLeftText || $lastRightText): ?>
        <section class="collection-last" aria-label="Collection last section">
            <div class="collection-last__inner">
                <header class="collection-last__head">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastTitle): ?>
                        <h2 class="collection-last__title"><?php echo e($lastTitle); ?></h2>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastSubtitle): ?>
                        <p class="collection-last__subtitle"><?php echo e($lastSubtitle); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </header>

                <div class="collection-last__divider" aria-hidden="true"></div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastImageUrl): ?>
                    <div class="collection-last__media">
                        <img class="collection-last__image" src="<?php echo e($lastImageUrl); ?>" alt="<?php echo e($lastTitle ?? 'Collection image'); ?>">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastButtonLink): ?>
                            <a class="collection-last__arrow" href="<?php echo e($lastButtonLink); ?>" aria-label="Open">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M5 12H18" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M13 7L18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="collection-last__texts">
                    <div class="collection-last__text">
                        <?php echo nl2br(e((string) ($lastLeftText ?? ''))); ?>

                    </div>
                    <div class="collection-last__text">
                        <?php echo nl2br(e((string) ($lastRightText ?? ''))); ?>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($gallerySections ?? collect())->count()): ?>
        <section id="gallery" class="gallery" aria-label="Gallery">
            <div class="gallery-inner">
                <?php
                    $head = $gallerySections->first();
                ?>

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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $gallerySections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('gallery.partials.section-card', ['section' => $section], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="gallery-footer">
                    <div class="gallery-more">
                        <span class="gallery-more-text"><?php echo e($gallerySections->first()->localized('more_button_text')); ?></span>
                        <a class="gallery-more-btn" href="<?php echo e(route('gallery.index')); ?>" aria-label="More">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M5 12H18" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                <path d="M13 7L18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryTextLeftTitle || $galleryTextLeft || $galleryTextRightTitle || $galleryTextRight): ?>
        <section class="collection-gallery-text" aria-label="Gallery text block">
            <div class="collection-gallery-text__inner">
                <div class="collection-gallery-text__grid">
                    <div class="collection-gallery-text__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryTextLeftTitle): ?>
                            <div class="collection-gallery-text__title">“<?php echo e(strtoupper((string) $galleryTextLeftTitle)); ?>”</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryTextLeft): ?>
                            <div class="collection-gallery-text__text">
                                <?php echo nl2br(e((string) $galleryTextLeft)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="collection-gallery-text__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryTextRightTitle): ?>
                            <div class="collection-gallery-text__title">“<?php echo e(strtoupper((string) $galleryTextRightTitle)); ?>”</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($galleryTextRight): ?>
                            <div class="collection-gallery-text__text">
                                <?php echo nl2br(e((string) $galleryTextRight)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($leftYoutubeId || $rightYoutubeId || $videosLeftText || $videosRightText): ?>
        <section class="collection-videos" aria-label="Collection videos">
            <div class="collection-videos__inner">
                <header class="collection-videos__head">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videosTitle): ?>
                        <h2 class="collection-videos__title"><?php echo e($videosTitle); ?></h2>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videosSubtitle): ?>
                        <p class="collection-videos__subtitle"><?php echo e($videosSubtitle); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </header>

                <div class="collection-videos__grid" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($leftYoutubeId): ?>
                        <div class="collection-videos__media" role="listitem" data-collection-video>
                            <iframe
                                class="collection-videos__iframe"
                                src="https://www.youtube-nocookie.com/embed/<?php echo e($leftYoutubeId); ?>"
                                title="YouTube video"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen
                            ></iframe>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($leftThumbUrl): ?>
                                <div class="collection-videos__thumb" aria-hidden="true">
                                    <img src="<?php echo e($leftThumbUrl); ?>" alt="">
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <button class="collection-videos__play" type="button" aria-label="Play video" data-collection-video-play></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rightYoutubeId): ?>
                        <div class="collection-videos__media" role="listitem" data-collection-video>
                            <iframe
                                class="collection-videos__iframe"
                                src="https://www.youtube-nocookie.com/embed/<?php echo e($rightYoutubeId); ?>"
                                title="YouTube video"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen
                            ></iframe>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rightThumbUrl): ?>
                                <div class="collection-videos__thumb" aria-hidden="true">
                                    <img src="<?php echo e($rightThumbUrl); ?>" alt="">
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <button class="collection-videos__play" type="button" aria-label="Play video" data-collection-video-play></button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="collection-videos__texts">
                    <div class="collection-videos__text">
                        <?php echo nl2br(e((string) ($videosLeftText ?? ''))); ?>

                    </div>
                    <div class="collection-videos__text">
                        <?php echo nl2br(e((string) ($videosRightText ?? ''))); ?>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <style>
        .collection-hero-fixed {
            background: #f7f5ef;
            position: relative;
            overflow: hidden;
            padding-top: 28px;
        }

        .collection-hero-fixed__inner {
            max-width: 980px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 3;
            padding: 0 20px;
        }

        .collection-hero-fixed__title {
            margin: 0;
            font-family: var(--serif, "Cormorant Garamond", "Times New Roman", serif);
            font-size: clamp(56px, 8vw, 110px);
            line-height: .92;
            font-weight: 500;
            color: #bf8730;
            letter-spacing: -.02em;
        }

        .collection-hero-fixed__subtitle {
            margin: 20px auto 0;
            max-width: 560px;
            font-size: 15px;
            line-height: 1.7;
            color: #5c5c5c;
            font-weight: 400;
        }

        .collection-hero-fixed__art {
            position: relative;
            margin-top: 34px;
            min-height: 760px;
        }

        .collection-hero-fixed__bg {
            position: relative;
            width: 100%;
            height: 310px;
            overflow: hidden;
            z-index: 1;
            opacity: .58;
        }

        .collection-hero-fixed__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .collection-hero-fixed__wave-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 180px;
            z-index: 2;
            pointer-events: none;
        }

        .collection-hero-fixed__stroke {
            position: absolute;
            top: 92px;
            left: 0;
            width: 100%;
            height: 170px;
            z-index: 2;
            pointer-events: none;
        }

        .collection-hero-fixed__content-wrap {
            position: relative;
            z-index: 4;
            max-width: 1240px;
            margin: -68px auto 0;
            padding: 0 35px 70px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 58px;
            align-items: start;
        }

        .collection-hero-fixed__featured {
            width: 100%;
        }

        .collection-hero-fixed__image {
            width: 100%;
            aspect-ratio: 560 / 235;
            overflow: hidden;
            background: #2b1b14;
        }

        .collection-hero-fixed__image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .collection-hero-fixed__text {
            padding-top: 86px;
            max-width: 520px;
        }

        .collection-hero-fixed__card-title {
            margin: 0 0 20px;
            font-family: var(--serif, "Cormorant Garamond", "Times New Roman", serif);
            font-size: clamp(34px, 4vw, 58px);
            line-height: .95;
            font-weight: 500;
            color: #bf8730;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .collection-hero-fixed__card-copy {
            font-size: 14px;
            line-height: 1.9;
            color: #2f2f2f;
            font-weight: 400;
        }

        .collection-hero-fixed__card-copy p {
            margin: 0 0 14px;
        }

        .collection-hero-fixed__card-copy p:last-child {
            margin-bottom: 0;
        }

        .collection-after-hero {
            padding-top: 40px !important;
            position: relative;
            z-index: 1;
            background: #f7f5ef;
        }

        @media (max-width: 1200px) {
            .collection-hero-fixed__content-wrap {
                max-width: 1120px;
                gap: 40px;
                padding-left: 28px;
                padding-right: 28px;
            }

            .collection-hero-fixed__text {
                padding-top: 60px;
            }
        }

        @media (max-width: 991px) {
            .collection-hero-fixed {
                padding-top: 20px;
            }

            .collection-hero-fixed__art {
                min-height: auto;
            }

            .collection-hero-fixed__bg {
                height: 240px;
            }

            .collection-hero-fixed__stroke {
                top: 78px;
                height: 145px;
            }

            .collection-hero-fixed__content-wrap {
                margin-top: -42px;
                grid-template-columns: 1fr;
                gap: 28px;
                padding: 0 20px 50px;
            }

            .collection-hero-fixed__text {
                padding-top: 0;
                max-width: 100%;
            }

            .collection-hero-fixed__card-title {
                margin-bottom: 16px;
            }

            .collection-after-hero {
                padding-top: 20px !important;
            }
        }

        @media (max-width: 640px) {
            .collection-hero-fixed__title {
                font-size: 54px;
            }

            .collection-hero-fixed__subtitle {
                font-size: 13px;
                line-height: 1.6;
            }

            .collection-hero-fixed__bg {
                height: 180px;
            }

            .collection-hero-fixed__wave-top {
                height: 130px;
            }

            .collection-hero-fixed__stroke {
                top: 52px;
                height: 120px;
            }

            .collection-hero-fixed__content-wrap {
                margin-top: -24px;
                padding: 0 16px 36px;
            }

            .collection-hero-fixed__image {
                aspect-ratio: 16 / 9;
            }

            .collection-hero-fixed__card-title {
                font-size: 34px;
            }

            .collection-hero-fixed__card-copy {
                font-size: 13px;
                line-height: 1.75;
            }
        }

        /* Last section (editable from Static Pages -> collection -> last_section) */
        .collection-last{
            background:#f7f5ef;
            padding:72px 20px 84px;
        }

        .collection-last__inner{
            max-width:1240px;
            margin:0 auto;
        }

        .collection-last__title{
            margin:0;
            color:#cf9130;
            font-family:"Zen Old Mincho", serif;
            font-size:clamp(34px, 4.2vw, 56px);
            font-weight:400;
            line-height:1.05;
            letter-spacing:.02em;
            text-transform:uppercase;
        }

        .collection-last__subtitle{
            margin:14px 0 0;
            max-width:640px;
            font-size:12px;
            line-height:1.7;
            font-weight:300;
            color:#2a2a2a;
        }

        .collection-last__divider{
            margin-top:22px;
            height:1px;
            width:100%;
            background:rgba(20,20,20,.12);
        }

        .collection-last__media{
            margin-top:26px;
            position:relative;
            width:100%;
            overflow:hidden;
            background:#eee7d7;
            aspect-ratio: 1240 / 420;
        }

        .collection-last__image{
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            object-position:center;
        }

        .collection-last__arrow{
            position:absolute;
            right:18px;
            top:50%;
            transform:translateY(-50%);
            width:56px;
            height:56px;
            border-radius:999px;
            display:grid;
            place-items:center;
            background:#cf9130;
            text-decoration:none;
        }

        .collection-last__texts{
            margin-top:26px;
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:44px;
        }

        .collection-last__text{
            font-size:11px;
            line-height:1.7;
            font-weight:300;
            color:#2a2a2a;
            max-width:520px;
        }

        @media (max-width: 991px){
            .collection-last__media{
                aspect-ratio: 16 / 7;
            }

            .collection-last__texts{
                grid-template-columns:1fr;
                gap:18px;
            }
        }

        /* Gallery text block (editable from Static Pages -> collection -> gallery_text_block) */
        .collection-gallery-text{
            background:#f7f5ef;
            padding:52px 20px 74px;
        }

        .collection-gallery-text__inner{
            max-width:1240px;
            margin:0 auto;
        }

        .collection-gallery-text__grid{
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:44px;
            align-items:start;
        }

        .collection-gallery-text__title{
            font-family:var(--serif, "Cormorant Garamond", "Times New Roman", serif);
            color:#bf8730;
            font-size:clamp(34px, 4vw, 58px);
            line-height:.95;
            font-weight:500;
            letter-spacing:.03em;
            text-transform:uppercase;
        }

        .collection-gallery-text__text{
            margin-top:14px;
            font-size:12px;
            line-height:1.9;
            color:#2f2f2f;
            font-weight:400;
        }

        @media (max-width: 991px){
            .collection-gallery-text__grid{
                grid-template-columns:1fr;
                gap:22px;
            }
        }

        /* Videos section (editable from Static Pages -> collection -> videos_section) */
        .collection-videos{
            background:#f7f5ef;
            padding: 0 0 96px;
        }

        .collection-videos__inner{
            max-width:1240px;
            margin:0 auto;
            padding: 0 20px;
        }

        /*.collection-videos__head{*/
        /*    margin-top: 34px;*/
        /*}*/

        .collection-videos__title{
            margin:0;
            color:#cf9130;
            font-family:"Zen Old Mincho", serif;
            font-size:clamp(34px, 4.2vw, 56px);
            font-weight:400;
            line-height:1.05;
            letter-spacing:.02em;
            text-transform:uppercase;
        }

        .collection-videos__subtitle{
            margin:14px 0 0;
            max-width:640px;
            font-size:12px;
            line-height:1.7;
            font-weight:300;
            color:#2a2a2a;
        }

        .collection-videos__grid{
            margin-top: 26px;
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap: 34px;
        }

        .collection-videos__media{
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 7;
            background: rgba(255,255,255,.35);
            overflow: hidden;
            border: 1px solid rgba(20,20,20,.08);
        }

        .collection-videos__iframe{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            display:block;
            z-index:1;
        }

        .collection-videos__thumb{
            position:absolute;
            inset:0;
            z-index:2;
        }

        .collection-videos__thumb img{
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            object-position:center;
        }

        .collection-videos__play{
            position:absolute;
            left:50%;
            top:50%;
            transform:translate(-50%, -50%);
            width:58px;
            height:58px;
            border-radius:999px;
            border:0;
            background:rgba(255,255,255,.9);
            box-shadow:0 12px 22px rgba(0,0,0,.18);
            cursor:pointer;
            z-index:3;
        }

        .collection-videos__play::before{
            content:'';
            position:absolute;
            left:23px;
            top:18px;
            width:0;
            height:0;
            border-left:18px solid #cf9130;
            border-top:11px solid transparent;
            border-bottom:11px solid transparent;
        }

        .collection-videos__media.is-playing .collection-videos__thumb,
        .collection-videos__media.is-playing .collection-videos__play{
            display:none;
        }

        .collection-videos__texts{
            margin-top: 26px;
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:44px;
        }

        .collection-videos__text{
            font-size:11px;
            line-height:1.7;
            font-weight:300;
            color:#2a2a2a;
            max-width:520px;
        }

        @media (max-width: 991px){
            .collection-videos__grid{
                grid-template-columns:1fr;
                gap: 18px;
            }
            .collection-videos__texts{
                grid-template-columns:1fr;
                gap: 18px;
            }
        }
    </style>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function () {
            function play(mediaEl) {
                if (!mediaEl) return;
                mediaEl.classList.add('is-playing');
                var iframe = mediaEl.querySelector('iframe');
                if (!iframe) return;
                var src = iframe.getAttribute('src') || '';
                if (src.indexOf('autoplay=1') !== -1) return;
                iframe.setAttribute('src', src + (src.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1');
            }

            document.addEventListener('click', function (e) {
                var btn = e.target.closest('[data-collection-video-play]');
                if (!btn) return;
                var media = btn.closest('[data-collection-video]');
                play(media);
            });
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/balasona/public_html/resources/views/collection/index.blade.php ENDPATH**/ ?>