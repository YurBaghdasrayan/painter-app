<?php $__env->startSection('title', 'Articles'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $articlesContent = $articlesPage?->localizedContent() ?? [];

        $hero = $articlesContent['hero'] ?? [];
        $intro = $articlesContent['intro_section'] ?? [];

        $heroTitle = $hero['title'] ?? 'Articles';
        $heroSubtitle = $hero['subtitle'] ?? 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs';
        $heroBgImage = $hero['background_image'] ?? null;
        $heroMainImage = $hero['main_image'] ?? null;

        $introColumns = collect($intro['columns'] ?? [])->filter()->values();

        if (is_array($heroBgImage)) {
            $heroBgImage = $heroBgImage[0] ?? null;
        }

        if (is_array($heroMainImage)) {
            $heroMainImage = $heroMainImage[0] ?? null;
        }

        $heroBgImageUrl = $heroBgImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBgImage) : null;
        $heroMainImageUrl = $heroMainImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMainImage) : null;

        $articlesForCards = $articles ?? collect();
        $useSlider = $articlesForCards->count() > 3;
    ?>

    <?php $__env->startSection('meta_description', strip_tags((string) $heroSubtitle)); ?>

    <section class="articles-hero-page" aria-label="Articles hero">
        <div class="articles-hero-page__top">
            <div class="articles-hero-page__inner">
                <h1 class="articles-hero-page__title"><?php echo e($heroTitle); ?></h1>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($heroSubtitle)): ?>
                    <p class="articles-hero-page__subtitle">
                        <?php echo e($heroSubtitle); ?>

                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="articles-hero-page__visual">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroBgImageUrl): ?>
                <img
                    src="<?php echo e($heroBgImageUrl); ?>"
                    alt="<?php echo e($heroTitle); ?>"
                    class="articles-hero-page__bg"
                >
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="articles-hero-page__shape"></div>

            <svg class="articles-hero-page__line" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
                <path
                    d="M0 110
                       C90 130 170 60 280 84
                       C410 112 520 82 640 98
                       C760 114 900 130 1040 100
                       C1160 74 1260 56 1360 66
                       C1400 70 1422 54 1440 40"
                    fill="none"
                    stroke="#ffffff"
                    stroke-width="5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>

            <div class="articles-hero-page__inner articles-hero-page__image-wrap">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroMainImageUrl): ?>
                    <div class="articles-hero-page__main-image-box">
                        <img
                            src="<?php echo e($heroMainImageUrl); ?>"
                            alt="<?php echo e($heroTitle); ?>"
                            class="articles-hero-page__main-image"
                        >
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($introColumns->count()): ?>
        <section class="articles-intro-section" aria-label="Articles intro">
            <div class="articles-intro-section__inner">
                <div class="articles-intro-section__grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $introColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="articles-intro-section__col">
                            <div class="articles-intro-section__text">
                                <?php echo $column; ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($articlesForCards->count()): ?>
        <section class="articles-card-section" aria-label="Articles cards">
            <div class="articles-card-section__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($useSlider): ?>
                    <div class="swiper articles-card-swiper">
                        <div class="swiper-wrapper">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $articlesForCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $locale = app()->getLocale() === 'hy' ? 'am' : app()->getLocale();
                                    $contentField = 'content_' . $locale;
                                    $fallbackField = 'content_en';

                                    $content = $article->{$contentField} ?: $article->{$fallbackField} ?: [];
                                    $card = $content['card'] ?? [];

                                    $cardImage = $card['image'] ?? null;
                                    $cardTitle = $card['title'] ?? $article->localized('title');
                                    $cardDescription = $card['description'] ?? $article->localized('short_description');

                                    $cardImageUrl = $cardImage
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($cardImage)
                                        : null;
                                ?>

                                <div class="swiper-slide">
                                    <article class="articles-card">
                                        <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="articles-card__link">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardImageUrl): ?>
                                                <div class="articles-card__image-wrap">
                                                    <img src="<?php echo e($cardImageUrl); ?>" alt="<?php echo e($cardTitle); ?>" class="articles-card__image">
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardTitle): ?>
                                                <h3 class="articles-card__title">“<?php echo e($cardTitle); ?>”</h3>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardDescription): ?>
                                                <div class="articles-card__description">
                                                    <?php echo e($cardDescription); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </a>
                                    </article>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="articles-card-swiper__nav">
                            <div class="articles-card-swiper__prev">←</div>
                            <div class="articles-card-swiper__next">→</div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="articles-card-grid">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $articlesForCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $locale = app()->getLocale() === 'hy' ? 'am' : app()->getLocale();
                                $contentField = 'content_' . $locale;
                                $fallbackField = 'content_en';

                                $content = $article->{$contentField} ?: $article->{$fallbackField} ?: [];
                                $card = $content['card'] ?? [];

                                $cardImage = $card['image'] ?? null;
                                $cardTitle = $card['title'] ?? $article->localized('title');
                                $cardDescription = $card['description'] ?? $article->localized('short_description');

                                $cardImageUrl = $cardImage
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($cardImage)
                                    : null;
                            ?>

                            <article class="articles-card">
                                <a href="<?php echo e(route('articles.show', $article->slug)); ?>" class="articles-card__link">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardImageUrl): ?>
                                        <div class="articles-card__image-wrap">
                                            <img src="<?php echo e($cardImageUrl); ?>" alt="<?php echo e($cardTitle); ?>" class="articles-card__image">
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardTitle): ?>
                                        <h3 class="articles-card__title">“<?php echo e($cardTitle); ?>”</h3>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cardDescription): ?>
                                        <div class="articles-card__description">
                                            <?php echo e($cardDescription); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </a>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php
        $homePage = \App\Models\StaticPage::query()
            ->where('slug', 'home')
            ->where('is_active', true)
            ->first();

        $homeContent = $homePage?->localizedContent() ?? [];
        $homeArticlesSection = $homeContent['articles_section'] ?? [];

        $homeArticlesTitle = $homeArticlesSection['title'] ?? '';
        $homeArticlesLeftText = $homeArticlesSection['left_text'] ?? '';
        $homeArticlesRightText = $homeArticlesSection['right_text'] ?? '';
        $homeArticlesMainImage = $homeArticlesSection['main_image'] ?? null;
        $homeArticlesSideImage = $homeArticlesSection['side_image'] ?? null;
        $homeArticlesCardTitle = $homeArticlesSection['card_title'] ?? '';
        $homeArticlesCardText = $homeArticlesSection['card_text'] ?? '';
        $homeArticlesMoreText = $homeArticlesSection['more_text'] ?? 'more';
        $homeArticlesMoreLink = $homeArticlesSection['more_link'] ?? '/articles';

        if (is_array($homeArticlesMainImage)) {
            $homeArticlesMainImage = $homeArticlesMainImage[0] ?? null;
        }

        if (is_array($homeArticlesSideImage)) {
            $homeArticlesSideImage = $homeArticlesSideImage[0] ?? null;
        }

    ?>
    <?php echo $__env->make('partials.articles-section', [
    'sectionId' => 'articles',
    'sectionClass' => 'home-articles',
    'articlesTitle' => $homeArticlesTitle,
    'articlesLeftText' => $homeArticlesLeftText,
    'articlesRightText' => $homeArticlesRightText,
    'articlesSideImage' => $homeArticlesSideImage,
    'articlesMainImage' => $homeArticlesMainImage,
    'articlesCardTitle' => $homeArticlesCardTitle,
    'articlesCardText' => $homeArticlesCardText,
    'articlesMoreText' => $homeArticlesMoreText,
    'articlesMoreLink' => $homeArticlesMoreLink,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.articles-card-swiper');

            if (!slider) return;

            new Swiper(slider, {
                slidesPerView: 1.15,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.articles-card-swiper__next',
                    prevEl: '.articles-card-swiper__prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 28,
                    },
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/articles/index.blade.php ENDPATH**/ ?>