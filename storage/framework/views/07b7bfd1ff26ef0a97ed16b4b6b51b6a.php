<?php $__env->startSection('title', $article->localizedTitle() ?? 'Article'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $heroTitle = $hero['title'] ?? $article->localizedTitle();
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBgImage = $hero['background_image'] ?? null;
        $heroMainImage = $hero['main_image'] ?? null;

        $textBlock1LeftTitle = $textBlock1['left_title'] ?? '';
        $textBlock1LeftText = $textBlock1['left_text'] ?? '';
        $textBlock1RightTitle = $textBlock1['right_title'] ?? '';
        $textBlock1RightText = $textBlock1['right_text'] ?? '';

        $imageBlock1Image = $imageBlock1['image'] ?? null;

        $textBlock2Title = $textBlock2['title'] ?? '';
        $textBlock2LeftText = $textBlock2['left_text'] ?? '';
        $textBlock2RightText = $textBlock2['right_text'] ?? '';

        $imageBlock2Image = $imageBlock2['image'] ?? null;

        $afterImage2LeftText = $afterImage2['left_text'] ?? '';
        $afterImage2RightText = $afterImage2['right_text'] ?? '';

        $bottomBlockTitle = $bottomBlock['title'] ?? '';
        $bottomBlockLeftText = $bottomBlock['left_text'] ?? '';
        $bottomBlockRightText = $bottomBlock['right_text'] ?? '';

        $heroBgImageUrl = $heroBgImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBgImage) : null;
        $heroMainImageUrl = $heroMainImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMainImage) : null;
        $imageBlock1ImageUrl = $imageBlock1Image ? \Illuminate\Support\Facades\Storage::disk('public')->url($imageBlock1Image) : null;
        $imageBlock2ImageUrl = $imageBlock2Image ? \Illuminate\Support\Facades\Storage::disk('public')->url($imageBlock2Image) : null;
    ?>

    <section class="article-show-hero" aria-label="Article hero">
        <div class="article-show-hero__top">
            <div class="article-show-hero__inner">
                <h1 class="article-show-hero__title">“<?php echo e($heroTitle); ?>”</h1>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                    <p class="article-show-hero__subtitle"><?php echo e($heroSubtitle); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="article-show-hero__visual">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroBgImageUrl): ?>
                <img src="<?php echo e($heroBgImageUrl); ?>" alt="<?php echo e($heroTitle); ?>" class="article-show-hero__bg">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="article-show-hero__shape"></div>

            <svg class="article-show-hero__line" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

            <div class="article-show-hero__inner article-show-hero__image-wrap">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroMainImageUrl): ?>
                    <div class="article-show-hero__main-image-box">
                        <img
                            src="<?php echo e($heroMainImageUrl); ?>"
                            alt="<?php echo e($heroTitle); ?>"
                            class="article-show-hero__main-image"
                        >
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock1LeftTitle || $textBlock1LeftText || $textBlock1RightTitle || $textBlock1RightText): ?>
        <section style="background-color:#FFFCF5 " class="article-show-text-block article-show-text-block--first" aria-label="Article text block 1">
            <div class="article-show-text-block__inner">
                <div class="article-show-text-block__grid article-show-text-block__grid--two">
                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock1LeftTitle): ?>
                            <h2 class="article-show-text-block__title">“<?php echo e($textBlock1LeftTitle); ?>”</h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock1LeftText): ?>
                            <div class="article-show-text-block__text"><?php echo $textBlock1LeftText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock1RightTitle): ?>
                            <h2 class="article-show-text-block__title">“<?php echo e($textBlock1RightTitle); ?>”</h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock1RightText): ?>
                            <div class="article-show-text-block__text"><?php echo $textBlock1RightText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imageBlock1ImageUrl): ?>
        <section style="background-color: #FFFCF5" class="article-show-image-block" aria-label="Article image block 1">
            <div class="article-show-image-block__inner">
                <div class="article-show-image-block__image-wrap">
                    <img src="<?php echo e($imageBlock1ImageUrl); ?>" alt="<?php echo e($heroTitle); ?>" class="article-show-image-block__image">
                </div>

                <a href="<?php echo e(route('articles.index')); ?>" class="article-show-image-block__arrow" aria-label="Back to articles">
                    <span>→</span>
                </a>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock2Title || $textBlock2LeftText || $textBlock2RightText): ?>
        <section class="article-show-text-block" aria-label="Article text block 2">
            <div class="article-show-text-block__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock2Title): ?>
                    <div class="article-show-text-block__heading">
                        <h2 class="article-show-text-block__title article-show-text-block__title--large"><?php echo e($textBlock2Title); ?></h2>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="article-show-text-block__content-grid">
                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock2LeftText): ?>
                            <div class="article-show-text-block__text"><?php echo $textBlock2LeftText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textBlock2RightText): ?>
                            <div class="article-show-text-block__text"><?php echo $textBlock2RightText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imageBlock2ImageUrl): ?>
        <section style="background-color: #FFFCF5" class="article-show-image-block article-show-image-block--second" aria-label="Article image block 2">
            <div class="article-show-image-block__inner">
                <div class="article-show-image-block__image-wrap article-show-image-block__image-wrap--large">
                    <img src="<?php echo e($imageBlock2ImageUrl); ?>" alt="<?php echo e($heroTitle); ?>" class="article-show-image-block__image">
                </div>

                <a href="<?php echo e(route('articles.index')); ?>" class="article-show-image-block__arrow" aria-label="Back to articles">
                    <span>→</span>
                </a>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterImage2LeftText || $afterImage2RightText): ?>
        <section style="background-color: #FFFCF5" class="article-show-text-block article-show-text-block--after-image" aria-label="Text under second image">
            <div class="article-show-text-block__inner">
                <div class="article-show-text-block__content-grid">
                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterImage2LeftText): ?>
                            <div class="article-show-text-block__text"><?php echo $afterImage2LeftText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterImage2RightText): ?>
                            <div class="article-show-text-block__text"><?php echo $afterImage2RightText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomBlockTitle || $bottomBlockLeftText || $bottomBlockRightText): ?>
        <section style="background-color: #FFFCF5" class="article-show-text-block article-show-text-block--last" aria-label="Bottom text block">
            <div class="article-show-text-block__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomBlockTitle): ?>
                    <div class="article-show-text-block__heading article-show-text-block__heading--bottom">
                        <h2 class="article-show-text-block__title article-show-text-block__title--large"><?php echo e($bottomBlockTitle); ?></h2>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="article-show-text-block__content-grid">
                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomBlockLeftText): ?>
                            <div class="article-show-text-block__text"><?php echo $bottomBlockLeftText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="article-show-text-block__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bottomBlockRightText): ?>
                            <div class="article-show-text-block__text"><?php echo $bottomBlockRightText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedArticles->count()): ?>
        <?php
            $useRelatedSlider = $relatedArticles->count() > 4;
        ?>

        <section style="background-color: #FFFCF5" class="article-related-section" aria-label="Related articles">
            <div class="article-related-section__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($useRelatedSlider): ?>
                    <div class="swiper article-related-swiper">
                        <div class="swiper-wrapper">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedArticle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $relatedContent = $relatedArticle->localizedContent();
                                    $relatedCard = $relatedContent['card'] ?? [];

                                    $relatedCardImage = $relatedCard['image'] ?? null;
                                    $relatedCardTitle = $relatedCard['title'] ?? $relatedArticle->localizedTitle();
                                    $relatedCardDescription = $relatedCard['description'] ?? $relatedArticle->localizedShortDescription();

                                    $relatedCardImageUrl = $relatedCardImage
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($relatedCardImage)
                                        : null;
                                ?>

                                <div class="swiper-slide">
                                    <article class="article-related-card">
                                        <a href="<?php echo e(route('articles.show', $relatedArticle->slug)); ?>" class="article-related-card__link">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCardImageUrl): ?>
                                                <div class="article-related-card__image-wrap">
                                                    <img
                                                        src="<?php echo e($relatedCardImageUrl); ?>"
                                                        alt="<?php echo e($relatedCardTitle); ?>"
                                                        class="article-related-card__image"
                                                    >
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCardTitle): ?>
                                                <h3 class="article-related-card__title">“<?php echo e($relatedCardTitle); ?>”</h3>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCardDescription): ?>
                                                <div class="article-related-card__description">
                                                    <?php echo e($relatedCardDescription); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </a>
                                    </article>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="article-related-swiper__next">→</div>
                    </div>
                <?php else: ?>
                    <div class="article-related-grid">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedArticle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $relatedContent = $relatedArticle->localizedContent();
                                $relatedCard = $relatedContent['card'] ?? [];

                                $relatedCardImage = $relatedCard['image'] ?? null;
                                $relatedCardTitle = $relatedCard['title'] ?? $relatedArticle->localizedTitle();
                                $relatedCardDescription = $relatedCard['description'] ?? $relatedArticle->localizedShortDescription();

                                $relatedCardImageUrl = $relatedCardImage
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($relatedCardImage)
                                    : null;
                            ?>

                            <article class="article-related-card">
                                <a href="<?php echo e(route('articles.show', $relatedArticle->slug)); ?>" class="article-related-card__link">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCardImageUrl): ?>
                                        <div class="article-related-card__image-wrap">
                                            <img
                                                src="<?php echo e($relatedCardImageUrl); ?>"
                                                alt="<?php echo e($relatedCardTitle); ?>"
                                                class="article-related-card__image"
                                            >
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCardTitle): ?>
                                        <h3 class="article-related-card__title">“<?php echo e($relatedCardTitle); ?>”</h3>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedCardDescription): ?>
                                        <div class="article-related-card__description">
                                            <?php echo e($relatedCardDescription); ?>

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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const relatedSlider = document.querySelector('.article-related-swiper');

            if (!relatedSlider) return;

            new Swiper(relatedSlider, {
                slidesPerView: 1.2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.article-related-swiper__next',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 28,
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/articles/show.blade.php ENDPATH**/ ?>