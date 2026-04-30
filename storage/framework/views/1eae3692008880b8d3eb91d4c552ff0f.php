<?php $__env->startSection('title', 'Exhibitions'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $hero = $staticPage?->getBlock('hero') ?? [];
        $heroTitle = $hero['title'] ?? 'Exhibitions';
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBg = $hero['background_image'] ?? null;
        $heroMain = $hero['main_image'] ?? null;

        if (is_array($heroBg)) {
            $heroBg = $heroBg[0] ?? null;
        }
        if (is_array($heroMain)) {
            $heroMain = $heroMain[0] ?? null;
        }

        $staticDisk = env('FILESYSTEM_DISK', 'public');
        $heroBgUrl = $heroBg ? \Illuminate\Support\Facades\Storage::disk($staticDisk)->url($heroBg) : null;
        $heroMainUrl = $heroMain ? \Illuminate\Support\Facades\Storage::disk($staticDisk)->url($heroMain) : null;

        $textBlock = $staticPage?->getBlock('text_block') ?? [];
        $textLeftTitle = $textBlock['left_title'] ?? null;
        $textLeft = $textBlock['left_text'] ?? null;
    ?>

    <?php $__env->startSection('meta_description', strip_tags((string) $heroSubtitle)); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroTitle || $heroSubtitle || $heroBgUrl || $heroMainUrl): ?>
        <section class="articles-hero-page" aria-label="Exhibitions hero">
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroBgUrl): ?>
                    <img
                        src="<?php echo e($heroBgUrl); ?>"
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroMainUrl): ?>
                        <div class="articles-hero-page__main-image-box">
                            <img
                                src="<?php echo e($heroMainUrl); ?>"
                                alt="<?php echo e($heroTitle); ?>"
                                class="articles-hero-page__main-image"
                            >
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textLeftTitle || $textLeft): ?>
        <section class="exhibitions-text" aria-label="Exhibitions text">
            <div class="exhibitions-text__inner">
                <div class="exhibitions-text__grid">
                    <div class="exhibitions-text__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textLeftTitle): ?>
                            <div class="exhibitions-text__title">“<?php echo e(strtoupper((string) $textLeftTitle)); ?>”</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($textLeft): ?>
                            <div class="exhibitions-text__text">
                                <?php echo nl2br(e((string) $textLeft)); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <section class="gallery-index" aria-label="Exhibitions index">
        <div class="gallery-inner">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($exhibitions ?? collect())->count()): ?>
                <div class="gallery-head">
                    <h2 class="gallery-title">EXHIBITIONS</h2>
                </div>

                <div class="exhibitions-cards" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $exhibitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $img = !empty($ex->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($ex->image) : null;
                        ?>
                        <article class="gallery-section-card" role="listitem">
                            <a class="gallery-section-card-link" href="<?php echo e(route('exhibitions.show', $ex)); ?>" aria-label="<?php echo e($ex->localized('title')); ?>">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                                    <div class="gallery-section-card-image">
                                        <img src="<?php echo e($img); ?>" alt="<?php echo e($ex->localized('title')); ?>" loading="lazy" />
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="gallery-section-card-meta">
                                    <div class="gallery-section-card-title">
                                        “<?php echo e(strtoupper((string) ($ex->localized('title') ?? 'Exhibitions'))); ?>”
                                    </div>

                                    <?php
                                        $desc = trim((string) ($ex->localized('description') ?? ''));
                                    ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($desc !== ''): ?>
                                        <div class="gallery-section-card-desc">
                                            <?php echo e($desc); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    <?php if (! $__env->hasRenderedOnce('87cebdcc-5a2c-47c0-a2f7-76e1dd57418d')): $__env->markAsRenderedOnce('87cebdcc-5a2c-47c0-a2f7-76e1dd57418d'); ?>
        <style>

            /* =====================================================
               EXHIBITIONS PAGE FULL STYLE + RESPONSIVE MEDIA
               paste at bottom of blade
            ===================================================== */

            /* ---------- Base ---------- */

            .gallery-index .gallery-inner{
                padding-left:70px;
                padding-right:70px;
            }

            .gallery-hero{
                position:relative;
                background:#f7f5ef;
                overflow:hidden;
            }

            .gallery-hero-inner{
                max-width:1240px;
                margin:0 auto;
                padding:62px 20px 30px;
                text-align:center;
                position:relative;
                z-index:3;
            }

            .gallery-hero-title{
                margin:0;
                font-family:var(--serif);
                color:var(--gold);
                font-size:86px;
                line-height:1;
                font-weight:500;
                letter-spacing:.02em;
                text-transform:uppercase;
            }

            .gallery-hero-subtitle{
                margin:18px auto 0;
                max-width:760px;
                font-size:14px;
                line-height:1.7;
                color:#2a2a2a;
                font-weight:300;
            }

            .gallery-hero-art{
                position:relative;
                min-height:420px;
            }

            .gallery-hero-art-bg{
                position:absolute;
                inset:0;
            }

            .gallery-hero-art-bg img{
                width:100%;
                height:100%;
                object-fit:cover;
            }

            .gallery-hero-wave,
            .gallery-hero-stroke{
                position:absolute;
                left:0;
                right:0;
                width:100%;
                height:140px;
                z-index:2;
            }

            .gallery-hero-wave{ top:0; }
            .gallery-hero-stroke{ top:0; }

            .gallery-hero-featured{
                position:absolute;
                left:50%;
                bottom:-130px;
                transform:translateX(-50%);
                width:min(980px, calc(100% - 48px));
                height:260px;
                z-index:4;
                overflow:hidden;
                background:#fff;
            }

            .gallery-hero-featured img{
                width:100%;
                height:100%;
                object-fit:cover;
            }

            .exhibitions-text{
                background:#f7f5ef;
                padding:170px 20px 74px;
            }

            .exhibitions-text__inner{
                max-width:1240px;
                margin:0 auto;
            }

            .exhibitions-text__grid{
                display:grid;
                grid-template-columns:1fr;
                gap:0;
                justify-items:center;
            }

            .exhibitions-text__title{
                font-family:var(--serif);
                color:var(--gold);
                font-size:58px;
                line-height:1;
                font-weight:500;
                text-transform:uppercase;
                text-align:center;
            }

            .exhibitions-text__text{
                margin-top:14px;
                font-size:12px;
                line-height:1.9;
                color:#2f2f2f;
                text-align:center;
                max-width: 760px;
                margin-left:auto;
                margin-right:auto;
            }

            .exhibitions-cards{
                margin-top:54px;
                display:grid;
                grid-template-columns:repeat(4,minmax(0,1fr));
                gap:44px 34px;
                grid-auto-flow:dense;
            }

            /* Figma: first row is 2 cards */
            .exhibitions-cards .gallery-section-card:nth-child(1){ grid-column: 1 / span 2; }
            .exhibitions-cards .gallery-section-card:nth-child(2){ grid-column: 3 / span 2; }

            .exhibitions-cards .gallery-section-card:nth-child(1) .gallery-section-card-image,
            .exhibitions-cards .gallery-section-card:nth-child(2) .gallery-section-card-image{
                aspect-ratio: 520 / 720;
            }

            /* Rest: return old layout (2 narrow + 1 wide) */
            .exhibitions-cards .gallery-section-card:nth-child(3n+3){ grid-column: 1; }
            .exhibitions-cards .gallery-section-card:nth-child(3n+4){ grid-column: 2; }
            .exhibitions-cards .gallery-section-card:nth-child(3n+5){ grid-column: 3 / span 2; }

            .exhibitions-cards .gallery-section-card:nth-child(3n+3) .gallery-section-card-image,
            .exhibitions-cards .gallery-section-card:nth-child(3n+4) .gallery-section-card-image{
                aspect-ratio:360/520;
            }

            .exhibitions-cards .gallery-section-card:nth-child(3n+5) .gallery-section-card-image{
                aspect-ratio:780/520;
            }

            .gallery-section-card-image img{
                width:100%;
                height:100%;
                object-fit:cover;
            }

            .gallery-section-card-title,
            .gallery-section-card-desc{
                overflow-wrap:anywhere;
            }

            /* ---------- 1600 ---------- */

            @media (max-width:1600px){

                .gallery-hero-title{font-size:78px;}
                .gallery-hero-featured{width:min(920px, calc(100% - 60px));height:240px;}
                .exhibitions-text{padding:155px 40px 70px;}

            }

            /* ---------- 1440 ---------- */

            @media (max-width:1440px){

                .gallery-index .gallery-inner{
                    padding-left:40px;
                    padding-right:40px;
                }

                .gallery-hero-title{font-size:72px;}

            }

            /* ---------- 1280 ---------- */

            @media (max-width:1280px){

                .gallery-hero-title{font-size:64px;}
                .gallery-hero-featured{
                    width:min(860px, calc(100% - 40px));
                    height:220px;
                }

                .exhibitions-text{
                    padding:145px 28px 60px;
                }

            }

            /* ---------- 1200 ---------- */

            @media (max-width:1200px){

                .gallery-index .gallery-inner{
                    padding-left:24px;
                    padding-right:24px;
                }

                .gallery-hero-title{font-size:58px;}
                .gallery-hero-subtitle{font-size:13px;}

                .exhibitions-cards{
                    grid-template-columns:repeat(2,minmax(0,1fr));
                    gap:28px 22px;
                }

                .exhibitions-cards .gallery-section-card{
                    grid-column:auto !important;
                }

                .exhibitions-cards .gallery-section-card-image{
                    aspect-ratio:4/3 !important;
                }

            }

            /* ---------- 1024 ---------- */

            @media (max-width:1024px){

                .gallery-hero-title{font-size:52px;}
                .gallery-hero-featured{
                    width:min(760px, calc(100% - 36px));
                    height:190px;
                }

                .exhibitions-text{
                    padding:125px 20px 54px;
                }

                .exhibitions-text__title{
                    font-size:42px;
                }

            }

            /* ---------- 992 ---------- */

            @media (max-width:992px){

                .gallery-hero-title{font-size:46px;}
                .gallery-hero-featured{
                    height:180px;
                    bottom:-90px;
                }

                .exhibitions-text{
                    padding:120px 18px 50px;
                }

                .exhibitions-text__grid{
                    grid-template-columns:1fr;
                    gap:24px;
                }

            }

            /* ---------- 768 ---------- */

            @media (max-width:768px){

                .gallery-hero-inner{
                    padding:48px 16px 24px;
                }

                .gallery-hero-title{
                    font-size:38px;
                }

                .gallery-hero-subtitle{
                    font-size:12px;
                    max-width:100%;
                }

                .gallery-hero-art{
                    min-height:320px;
                }

                .gallery-hero-featured{
                    width:calc(100% - 24px);
                    height:170px;
                    bottom:-84px;
                }

                .gallery-hero-wave,
                .gallery-hero-stroke{
                    height:90px;
                }

                .exhibitions-text{
                    padding:110px 16px 44px;
                }

                .exhibitions-text__title{
                    font-size:34px;
                }

                .gallery-index .gallery-inner{
                    padding-left:16px;
                    padding-right:16px;
                }

                .exhibitions-cards{
                    grid-template-columns:1fr;
                    gap:28px;
                }

            }

            /* ---------- 576 ---------- */

            @media (max-width:576px){

                .gallery-hero-title{font-size:32px;}
                .gallery-hero-featured{
                    height:150px;
                    bottom:-74px;
                }

                .exhibitions-text{
                    padding:96px 14px 40px;
                }

                .exhibitions-text__title{
                    font-size:30px;
                }

            }

            /* ---------- 430 ---------- */

            @media (max-width:430px){

                .gallery-hero-title{font-size:28px;}
                .gallery-hero-subtitle{font-size:11px;}
                .gallery-hero-featured{height:138px;}
                .exhibitions-text__title{font-size:28px;}

            }

            /* ---------- 390 ---------- */

            @media (max-width:390px){

                .gallery-hero-title{font-size:26px;}
                .gallery-hero-featured{height:128px;}
                .exhibitions-text{padding:88px 12px 34px;}

            }

            /* ---------- 360 ---------- */

            @media (max-width:360px){

                .gallery-hero-title{font-size:24px;}
                .gallery-hero-featured{height:118px;}
                .exhibitions-text__title{font-size:24px;}

            }

        </style>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/exhibitions/index.blade.php ENDPATH**/ ?>