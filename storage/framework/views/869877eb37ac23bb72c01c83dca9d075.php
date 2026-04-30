<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $homePage = \App\Models\StaticPage::query()
            ->where('slug', 'home')
            ->where('is_active', true)
            ->first();

        $homeContent = $homePage?->localizedContent() ?? [];
        $hero = $homeContent['hero'] ?? [];
        $homeHeroTitle = $hero['title'] ?? "Your digital twin\nsolution with AI model";
        $homeHeroSubtitle = $hero['subtitle'] ?? 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs';

        // SEO
        $__metaDescription = $homeHeroSubtitle;

        $about = $homeContent['about_section'] ?? [];
        $aboutKicker = $about['kicker'] ?? 'ARTIST';
        $aboutTitle = $about['title'] ?? 'ABOUT ME';
        $aboutLead = $about['lead'] ?? 'Smarttrak is a AI Technology Solutions company focused on';
        $aboutItems = collect($about['items'] ?? [])->filter()->values();
        $aboutLowerText = $about['lower_text'] ?? 'Grow smarter with clear strategy, clean design, and dependable delivery. We craft experiences that feel premium, minimal, and precise—built for modern desktop-first performance.';
        $aboutButtonText = $about['button_text'] ?? 'Read more';
        $aboutButtonLink = $about['button_link'] ?? '/about';
        $aboutBg = $about['background_image'] ?? null;

        if (is_array($aboutBg)) {
            $aboutBg = $aboutBg[0] ?? null;
        }

        $aboutBgIsVideo = false;
        if (is_string($aboutBg) && $aboutBg !== '') {
            $aboutBgIsVideo = (bool) preg_match('/\.(mp4|webm|mov)$/i', $aboutBg);
        }

        $aboutBgUrl = $aboutBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($aboutBg)
            : asset('assets/images/about-bg.png');

        $articlesSection = $homeContent['articles_section'] ?? [];

        $articlesTitle = $articlesSection['title'] ?? '';
        $articlesLeftText = $articlesSection['left_text'] ?? '';
        $articlesRightText = $articlesSection['right_text'] ?? '';
        $articlesMainImage = $articlesSection['main_image'] ?? null;
        $articlesSideImage = $articlesSection['side_image'] ?? null;
        $articlesCardTitle = $articlesSection['card_title'] ?? '';
        $articlesCardText = $articlesSection['card_text'] ?? '';
        $articlesMoreText = $articlesSection['more_text'] ?? 'more';
        $articlesMoreLink = $articlesSection['more_link'] ?? '/articles';

        $collectionSection = $homeContent['collection_section'] ?? [];
        $collectionTitle = $collectionSection['title'] ?? '';
        $collectionLeftText = $collectionSection['left_text'] ?? '';
        $collectionRightText = $collectionSection['right_text'] ?? '';
        $collectionMoreText = $collectionSection['more_text'] ?? null;
        $collectionMoreLink = $collectionSection['more_link'] ?? null;

        $exhibitions = $homeContent['exhibitions_section'] ?? [];
        $exhibitionsTitle = $exhibitions['title'] ?? 'EXHIBITIONS';
        $exhibitionsLeftHeading = $exhibitions['left_heading'] ?? '';
        $exhibitionsBullets = collect($exhibitions['bullets'] ?? [])->filter()->values();
        $exhibitionsLeftText = $exhibitions['left_text'] ?? '';
        $exhibitionsRightText = $exhibitions['right_text'] ?? '';
        $exhibitionsButtonText = $exhibitions['button_text'] ?? 'Read more';
        $exhibitionsButtonLink = $exhibitions['button_link'] ?? '/exhibitions';
        $exhibitionsBg = $exhibitions['background_image'] ?? null;

        if (is_array($exhibitionsBg)) {
            $exhibitionsBg = $exhibitionsBg[0] ?? null;
        }

        $exhibitionsBgUrl = $exhibitionsBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($exhibitionsBg)
            : null;

        if (is_array($articlesMainImage)) {
            $articlesMainImage = $articlesMainImage[0] ?? null;
        }

        if (is_array($articlesSideImage)) {
            $articlesSideImage = $articlesSideImage[0] ?? null;
        }

        $contactPage = \App\Models\StaticPage::query()
            ->where('slug', 'contact')
            ->where('is_active', true)
            ->first();
        $contactContent = $contactPage?->localizedContent() ?? [];
        $contactHeroTitle = $contactContent['contact']['hero_title'] ?? 'CONTACT WE';
        $contactHeroSubtitle = $contactContent['contact']['hero_subtitle'] ?? null;

        $locale = app()->getLocale();
        if ($locale === 'hy') $locale = 'am';
        $i18n = [
            'am' => [
                'first_name' => 'Անուն',
                'last_name' => 'Ազգանուն',
                'email' => 'Էլ․ հասցե',
                'phone' => 'Հեռախոսահամար',
                'message' => 'Հաղորդագրություն',
                'message_placeholder' => 'Գրեք ձեր հաղորդագրությունը',
                'send' => 'Ուղարկել',
            ],
            'ru' => [
                'first_name' => 'Имя',
                'last_name' => 'Фамилия',
                'email' => 'Email',
                'phone' => 'Номер телефона',
                'message' => 'Сообщение',
                'message_placeholder' => 'Напишите ваше сообщение',
                'send' => 'Отправить',
            ],
            'en' => [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'phone' => 'Phone Number',
                'message' => 'Message',
                'message_placeholder' => 'Write your message',
                'send' => 'Send Message',
            ],
        ];
        $t = $i18n[$locale] ?? $i18n['en'];
    ?>

    <?php $__env->startSection('meta_description', $__metaDescription); ?>

    <section class="hero" aria-label="Hero">
        <div class="hero-inner">
            <h1 class="hero-title">
                <?php echo nl2br(e((string) $homeHeroTitle)); ?>

            </h1>
            <p class="hero-subtitle">
                <?php echo e($homeHeroSubtitle); ?>

            </p>
        </div>
    </section>

    <section id="about" class="about" aria-label="About">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aboutBgIsVideo): ?>
            <video class="about-bg about-bg--video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
                <source src="<?php echo e($aboutBgUrl); ?>">
            </video>
        <?php else: ?>
            <img src="<?php echo e($aboutBgUrl); ?>" alt="About background" class="about-bg" />
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <img src="<?php echo e(asset('assets/images/line.svg')); ?>" alt="About background" class="line" />

        <div class="about-content">
            <div class="about-card">
                <div class="about-kicker"><?php echo e($aboutKicker); ?></div>
                <div class="about-title"><?php echo e($aboutTitle); ?></div>
                <div class="about-lead"><?php echo e($aboutLead); ?></div>

                <ul class="about-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $aboutItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $li): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($li); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>

                <p class="about-lower">
                    <?php echo e($aboutLowerText); ?>

                </p>

                <a class="about-btn" href="<?php echo e($aboutButtonLink); ?>"><?php echo e($aboutButtonText); ?></a>
            </div>
        </div>
    </section>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gallerySections->count()): ?>
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

    <?php echo $__env->make('partials.articles-section', [
        'sectionId' => 'articles',
        'sectionClass' => 'home-articles',
        'articlesTitle' => $articlesTitle,
        'articlesLeftText' => $articlesLeftText,
        'articlesRightText' => $articlesRightText,
        'articlesSideImage' => $articlesSideImage,
        'articlesMainImage' => $articlesMainImage,
        'articlesCardTitle' => $articlesCardTitle,
        'articlesCardText' => $articlesCardText,
        'articlesMoreText' => $articlesMoreText,
        'articlesMoreLink' => $articlesMoreLink,
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($collectionSections ?? collect())->count()): ?>
        <section id="collection" class="gallery" aria-label="Collection">
            <div class="gallery-inner">
                <?php
                    $head = $collectionSections->first();
                    $collectionTitleFinal = $collectionTitle ?: ($head?->localized('title') ?? '');
                    $collectionLeftTextFinal = $collectionLeftText ?: ($head?->localized('description') ?? '');
                    $collectionRightTextFinal = $collectionRightText ?: '';
                    $collectionMoreTextFinal = $collectionMoreText ?: ($head?->localized('more_button_text') ?? 'more');
                    $collectionMoreLinkFinal = $collectionMoreLink ?: (route('collection.index'));
                ?>

                <div class="gallery-head">
                    <h2 class="gallery-title"><?php echo e($collectionTitleFinal); ?></h2>

                    <div class="gallery-toptexts">
                        <div class="gallery-toptext gallery-toptext--left">
                            <?php echo nl2br(e((string) $collectionLeftTextFinal)); ?>

                        </div>
                        <div class="gallery-toptext gallery-toptext--right">
                            <?php echo nl2br(e((string) $collectionRightTextFinal)); ?>

                        </div>
                    </div>
                </div>

                <div class="gallery-section-grid" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $collectionSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('collection.partials.section-card', ['section' => $section], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="gallery-footer">
                    <div class="gallery-more">
                        <span class="gallery-more-text"><?php echo e($collectionMoreTextFinal); ?></span>
                        <a class="gallery-more-btn" href="<?php echo e($collectionMoreLinkFinal); ?>" aria-label="More">
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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exhibitionsTitle || $exhibitionsLeftHeading || $exhibitionsLeftText || $exhibitionsRightText || $exhibitionsBgUrl): ?>
        <section id="exhibitions" class="home-exhibitions" aria-label="Exhibitions">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exhibitionsBgUrl): ?>
                <img class="home-exhibitions__bg" src="<?php echo e($exhibitionsBgUrl); ?>" alt="" aria-hidden="true">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <svg class="home-exhibitions__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

            <div class="home-exhibitions__inner">
                <div class="home-exhibitions__grid">
                    <div class="home-exhibitions__left">
                        <h2 class="home-exhibitions__title"><?php echo e($exhibitionsTitle); ?></h2>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exhibitionsLeftHeading): ?>
                            <div class="home-exhibitions__heading">
                                <?php echo nl2br(e((string) $exhibitionsLeftHeading)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exhibitionsBullets->count()): ?>
                            <ul class="home-exhibitions__bullets">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $exhibitionsBullets->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($b); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </ul>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exhibitionsLeftText): ?>
                            <div class="home-exhibitions__copy">
                                <?php echo nl2br(e((string) $exhibitionsLeftText)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="home-exhibitions__right">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($exhibitionsRightText): ?>
                            <div class="home-exhibitions__copy home-exhibitions__copy--right">
                                <?php echo nl2br(e((string) $exhibitionsRightText)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <a class="home-exhibitions__btn" href="<?php echo e($exhibitionsButtonLink); ?>">
                            <?php echo e($exhibitionsButtonText); ?>

                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <section class="home-contact" aria-label="Contact form">
        <div class="home-contact__hero-wrap" aria-label="Contact header">
            <div class="home-contact__hero-inner">
                <header class="home-contact__hero">
                    <h2 class="home-contact__title"><?php echo e($contactHeroTitle); ?></h2>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($contactHeroSubtitle): ?>
                        <p class="home-contact__subtitle"><?php echo e($contactHeroSubtitle); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </header>
            </div>
        </div>

        <svg class="home-contact__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
            <path
                d="M0 104
                   C120 132 210 58 332 86
                   C476 118 620 90 760 110
                   C910 132 1050 92 1188 74
                   C1302 58 1376 76 1440 66
                   L1440 180
                   L0 180
                   Z"
                fill="#e8e6e1"
            />
        </svg>
        <svg class="home-contact__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

        <div class="home-contact__inner">
            <form class="contact-form contact-form--home" method="post" action="#">
                <?php echo csrf_field(); ?>

                <div class="contact-form__grid">
                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['first_name']); ?></span>
                        <input class="contact-field__input" type="text" name="first_name" autocomplete="given-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['last_name']); ?></span>
                        <input class="contact-field__input" type="text" name="last_name" autocomplete="family-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['email']); ?></span>
                        <input class="contact-field__input" type="email" name="email" autocomplete="email">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['phone']); ?></span>
                        <input class="contact-field__input" type="tel" name="phone" autocomplete="tel">
                    </label>

                    <label class="contact-field contact-field--message">
                        <span class="contact-field__label"><?php echo e($t['message']); ?></span>
                        <textarea class="contact-field__textarea" name="message" rows="3" placeholder="<?php echo e($t['message_placeholder']); ?>"></textarea>
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button class="contact-form__submit" type="submit"><?php echo e($t['send']); ?></button>
                </div>
            </form>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/balasona/public_html/resources/views/home.blade.php ENDPATH**/ ?>