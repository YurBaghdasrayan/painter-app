<?php $__env->startSection('title', $staticPage?->getBlock('hero')['title'] ?? 'Photos & Videos'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $hero = $staticPage?->getBlock('hero') ?? [];
        $heroTitle = $hero['title'] ?? 'Photos & Videos';
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBg = $hero['background_image'] ?? null;
        if (is_array($heroBg)) {
            $heroBg = $heroBg[0] ?? null;
        }
        $heroBgUrl = $heroBg ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBg) : null;

        $items = $items ?? collect();

        // Fallback: if controller didn't pass normalized items (or old cache),
        // normalize here as well (id/type can be null in DB JSON).
        if ((!($items instanceof \Illuminate\Support\Collection)) || $items->count() === 0) {
            $items = collect(is_array($page?->items) ? $page->items : [])
                ->values()
                ->map(function ($it, int $idx) {
                    $it = is_array($it) ? $it : [];

                    $id = $it['id'] ?? null;
                    if (!is_string($id) || trim($id) === '') {
                        $id = "photo-{$idx}";
                    }

                    $image = $it['image'] ?? null;
                    if (is_array($image)) {
                        $image = $image[0] ?? null;
                    }

                    return [
                        ...$it,
                        'id' => $id,
                        'image' => is_string($image) && trim($image) !== '' ? $image : null,
                    ];
                })
                ->filter(fn (array $it) => !empty($it['image']))
                ->values()
                ->take(5);
        }

        $locale = app()->getLocale();
        if ($locale === 'hy') $locale = 'am';

        $second = is_array($page?->content) ? ($page->content['second_block'] ?? []) : [];
        $secondTitle = $second['title_' . $locale] ?? ($second['title_en'] ?? null);
        $secondText = $second['text_' . $locale] ?? ($second['text_en'] ?? null);
        $secondBottomText = $second['bottom_text_' . $locale] ?? ($second['bottom_text_en'] ?? null);

        $secondVideo = $second['video'] ?? null;
        if (is_array($secondVideo)) $secondVideo = $secondVideo[0] ?? null;
        $secondVideoUrl = $secondVideo ? \Illuminate\Support\Facades\Storage::disk('public')->url($secondVideo) : null;

        $secondPoster = $second['video_poster'] ?? null;
        if (is_array($secondPoster)) $secondPoster = $secondPoster[0] ?? null;
        $secondPosterUrl = $secondPoster ? \Illuminate\Support\Facades\Storage::disk('public')->url($secondPoster) : null;

        $secondItems = collect(is_array($second['items'] ?? null) ? $second['items'] : [])
            ->values()
            ->map(function ($it, int $idx) {
                $it = is_array($it) ? $it : [];
                $id = $it['id'] ?? null;
                if (!is_string($id) || trim($id) === '') $id = "block2-{$idx}";

                $img = $it['image'] ?? null;
                if (is_array($img)) $img = $img[0] ?? null;

                return [
                    ...$it,
                    'id' => $id,
                    'image' => (is_string($img) && trim($img) !== '') ? $img : null,
                ];
            })
            ->filter(fn (array $it) => !empty($it['image']))
            ->values();

        $third = is_array($page?->content) ? ($page->content['third_block'] ?? []) : [];
        $thirdTitle = $third['title_' . $locale] ?? ($third['title_en'] ?? null);

        $thirdTopLeft = $third['top_left_text_' . $locale] ?? ($third['top_left_text_en'] ?? null);
        $thirdTopRight = $third['top_right_text_' . $locale] ?? ($third['top_right_text_en'] ?? null);
        $thirdBottomLeft = $third['bottom_left_text_' . $locale] ?? ($third['bottom_left_text_en'] ?? null);
        $thirdBottomRight = $third['bottom_right_text_' . $locale] ?? ($third['bottom_right_text_en'] ?? null);

        $thirdLeftVideo = $third['left_video'] ?? null;
        if (is_array($thirdLeftVideo)) $thirdLeftVideo = $thirdLeftVideo[0] ?? null;
        $thirdLeftVideoUrl = $thirdLeftVideo ? \Illuminate\Support\Facades\Storage::disk('public')->url($thirdLeftVideo) : null;

        $thirdLeftPoster = $third['left_video_poster'] ?? null;
        if (is_array($thirdLeftPoster)) $thirdLeftPoster = $thirdLeftPoster[0] ?? null;
        $thirdLeftPosterUrl = $thirdLeftPoster ? \Illuminate\Support\Facades\Storage::disk('public')->url($thirdLeftPoster) : null;

        $thirdRightVideo = $third['right_video'] ?? null;
        if (is_array($thirdRightVideo)) $thirdRightVideo = $thirdRightVideo[0] ?? null;
        $thirdRightVideoUrl = $thirdRightVideo ? \Illuminate\Support\Facades\Storage::disk('public')->url($thirdRightVideo) : null;

        $thirdRightPoster = $third['right_video_poster'] ?? null;
        if (is_array($thirdRightPoster)) $thirdRightPoster = $thirdRightPoster[0] ?? null;
        $thirdRightPosterUrl = $thirdRightPoster ? \Illuminate\Support\Facades\Storage::disk('public')->url($thirdRightPoster) : null;

        $fourth = is_array($page?->content) ? ($page->content['fourth_block'] ?? []) : [];
        $fourthArrowLabel = $fourth['arrow_label'] ?? null;

        $sliderItems = collect(is_array($fourth['items'] ?? null) ? $fourth['items'] : [])
            ->values()
            ->map(function ($it, int $idx) {
                $it = is_array($it) ? $it : [];
                $id = $it['id'] ?? null;
                if (!is_string($id) || trim($id) === '') $id = "slider-{$idx}";

                $img = $it['image'] ?? null;
                if (is_array($img)) $img = $img[0] ?? null;

                return [
                    ...$it,
                    'id' => $id,
                    'image' => (is_string($img) && trim($img) !== '') ? $img : null,
                ];
            })
            ->filter(fn (array $it) => !empty($it['image']))
            ->values();

        // Final slider: all images (block 1 + block 2 + slider items)
        $allSliderItems = collect()
            ->concat($items instanceof \Illuminate\Support\Collection ? $items : collect())
            ->concat($secondItems)
            ->concat($sliderItems)
            ->unique('id')
            ->filter(fn (array $it) => !empty($it['image']))
            ->values();

        $afterSlider = is_array($page?->content) ? ($page->content['after_slider_block'] ?? []) : [];
        $afterTitle = $afterSlider['title_' . $locale] ?? ($afterSlider['title_en'] ?? null);
        $afterTopText = $afterSlider['top_text_' . $locale] ?? ($afterSlider['top_text_en'] ?? null);
        $afterBottomText = $afterSlider['bottom_text_' . $locale] ?? ($afterSlider['bottom_text_en'] ?? null);

        $afterVideo = $afterSlider['video'] ?? null;
        if (is_array($afterVideo)) $afterVideo = $afterVideo[0] ?? null;
        $afterVideoUrl = $afterVideo ? \Illuminate\Support\Facades\Storage::disk('public')->url($afterVideo) : null;

        $afterPoster = $afterSlider['video_poster'] ?? null;
        if (is_array($afterPoster)) $afterPoster = $afterPoster[0] ?? null;
        $afterPosterUrl = $afterPoster ? \Illuminate\Support\Facades\Storage::disk('public')->url($afterPoster) : null;
    ?>

    <?php $__env->startSection('meta_description', strip_tags((string) $heroSubtitle)); ?>

    <section class="gallery-hero" aria-label="Photos & Videos hero">
        <div class="gallery-hero-inner">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroTitle): ?>
                <h1 class="gallery-hero-title"><?php echo e($heroTitle); ?></h1>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                <p class="gallery-hero-subtitle"><?php echo e($heroSubtitle); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="gallery-hero-art">
            <div class="gallery-hero-art-bg">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroBgUrl): ?>
                    <img src="<?php echo e($heroBgUrl); ?>" alt="<?php echo e($heroTitle); ?>">
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
        </div>
    </section>

    <section class="gallery-index pv-index" aria-label="Photos & Videos index">
        <div class="gallery-inner">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items->count()): ?>
                <div class="pv-grid" role="list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $imgUrl = !empty($it['image']) ? \Illuminate\Support\Facades\Storage::disk('public')->url($it['image']) : null;
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgUrl): ?>
                            <article class="pv-card" role="listitem">
                                <a class="pv-link" href="<?php echo e(route('pictures-and-videos.show', $it['id'])); ?>" aria-label="Open">
                                    <div class="pv-image">
                                        <img src="<?php echo e($imgUrl); ?>" alt="" loading="lazy" />
                                    </div>
                                </a>
                            </article>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

    <?php if (! $__env->hasRenderedOnce('8aba9d07-40b9-46e3-a073-a4100ad1ea5d')): $__env->markAsRenderedOnce('8aba9d07-40b9-46e3-a073-a4100ad1ea5d'); ?>
        <style>
            /* Make the block slightly overlap the hero (like Figma) */
            .pv-index{
                margin-top:-90px;
                padding-top:120px;
            }

            @media (max-width: 768px){
                .pv-index{
                    margin-top:-50px;
                    padding-top:90px;
                }
            }

            .pv-grid{
                display:grid;
                /* 3 top + 2 bottom (equal widths) */
                grid-template-columns:repeat(6, minmax(0, 1fr));
                gap:24px;
                align-items:start;
            }

            .pv-image{
                width:100%;
                overflow:hidden;
                border: 1px solid rgba(20,20,20,.08);
                background: rgba(255,255,255,.35);
                aspect-ratio: 1 / 1;
            }

            /* Figma-like 5 photos layout:
               Row 1: 3 equal (each spans 2/6)
               Row 2: 2 equal (each spans 3/6)
            */
            .pv-card:nth-child(1){ grid-column: 1 / span 2; }
            .pv-card:nth-child(2){ grid-column: 3 / span 2; }
            .pv-card:nth-child(3){ grid-column: 5 / span 2; }
            .pv-card:nth-child(4){ grid-column: 1 / span 3; }
            .pv-card:nth-child(5){ grid-column: 4 / span 3; }

            .pv-image img{
                width:100%;
                height:100%;
                display:block;
                object-fit:cover;
                object-position:center;
            }

            @media (max-width: 991px){
                .pv-grid{ grid-template-columns:repeat(2, minmax(0, 1fr)); }

                .pv-card:nth-child(1),
                .pv-card:nth-child(2),
                .pv-card:nth-child(3),
                .pv-card:nth-child(4),
                .pv-card:nth-child(5){
                    grid-column:auto;
                }
            }
            @media (max-width: 640px){
                .pv-grid{ grid-template-columns:1fr; }
            }
        </style>
    <?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondTitle || $secondText || $secondVideoUrl || $secondItems->count()): ?>
        <section class="pv-block2" aria-label="Photos & Videos block 2">
            <div class="pv-block2__inner">
                <div class="pv-block2__head">
                    <div class="pv-block2__head-left">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondTitle): ?>
                            <h2 class="pv-block2__title"><?php echo e(strtoupper((string) $secondTitle)); ?></h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondText): ?>
                            <div class="pv-block2__text"><?php echo $secondText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="pv-block2__head-right" aria-hidden="true"></div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondVideoUrl): ?>
                    <div class="pv-block2__video">
                        <div class="pv-video" data-pv-video>
                            <video class="pv-video__el" preload="metadata" playsinline <?php if($secondPosterUrl): ?> poster="<?php echo e($secondPosterUrl); ?>" <?php endif; ?>>
                                <source src="<?php echo e($secondVideoUrl); ?>">
                            </video>
                            <button class="pv-video__play" type="button" aria-label="Play">▶</button>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondBottomText): ?>
                    <div class="pv-block2__bottom-text">
                        <?php echo $secondBottomText; ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($secondItems->count()): ?>
                    <?php $imgs = $secondItems->take(7)->values(); ?>
                    <div class="pv-block2__media" aria-label="Images">
                        <div class="pv2-top" role="list" aria-label="Top images">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $imgs->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $u = \Illuminate\Support\Facades\Storage::disk('public')->url($it['image']); ?>
                                <article class="pv2-card" role="listitem">
                                    <a class="pv2-link" href="<?php echo e(route('pictures-and-videos.show', $it['id'])); ?>" aria-label="Open">
                                        <div class="pv2-image pv2-image--sq">
                                            <img src="<?php echo e($u); ?>" alt="" loading="lazy">
                                        </div>
                                    </a>
                                </article>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgs->count() >= 5): ?>
                            <div class="pv2-bottom" aria-label="Bottom images">
                                <?php $u5 = \Illuminate\Support\Facades\Storage::disk('public')->url($imgs[4]['image']); ?>
                                <div class="pv2-bottom__left">
                                    <a class="pv2-link" href="<?php echo e(route('pictures-and-videos.show', $imgs[4]['id'])); ?>" aria-label="Open">
                                        <div class="pv2-image pv2-image--wide">
                                            <img src="<?php echo e($u5); ?>" alt="" loading="lazy">
                                        </div>
                                    </a>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgs->count() >= 6): ?>
                                    <?php $u6 = \Illuminate\Support\Facades\Storage::disk('public')->url($imgs[5]['image']); ?>
                                    <div class="pv2-bottom__mid">
                                        <a class="pv2-link" href="<?php echo e(route('pictures-and-videos.show', $imgs[5]['id'])); ?>" aria-label="Open">
                                            <div class="pv2-image pv2-image--sq">
                                                <img src="<?php echo e($u6); ?>" alt="" loading="lazy">
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgs->count() >= 7): ?>
                                    <?php $u7 = \Illuminate\Support\Facades\Storage::disk('public')->url($imgs[6]['image']); ?>
                                    <div class="pv2-bottom__right">
                                        <a class="pv2-link" href="<?php echo e(route('pictures-and-videos.show', $imgs[6]['id'])); ?>" aria-label="Open">
                                            <div class="pv2-image pv2-image--sq">
                                                <img src="<?php echo e($u7); ?>" alt="" loading="lazy">
                                            </div>
                                        </a>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>

        <?php if (! $__env->hasRenderedOnce('bccba0d8-0391-458b-bd9f-35d84929f382')): $__env->markAsRenderedOnce('bccba0d8-0391-458b-bd9f-35d84929f382'); ?>
            <style>
                .pv-block2{
                    background:#e8d5ac;
                    position:relative;
                    padding:74px 0 84px;
                }
                .pv-block2__inner{
                    max-width:1700px;
                    margin:0 auto;
                    padding:0 110px;
                }
                .pv-block2__head{
                    display:grid;
                    grid-template-columns: 1fr 1fr;
                    gap:40px;
                    align-items:start;
                }
                .pv-block2__title{
                    margin:0 0 10px;
                    font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                    color:var(--gallery-gold, #c88b2a);
                    font-size:28px;
                    font-weight:500;
                    letter-spacing:.04em;
                    text-transform:uppercase;
                    line-height:1.1;
                }
                .pv-block2__text{
                    font-size:12px;
                    line-height:1.75;
                    font-weight:300;
                    color:var(--gallery-text, #2a2a2a);
                    max-width:560px;
                }
                .pv-block2__head-right{
                    position:relative;
                }
                .pv-block2__head-right::before{
                    content:"";
                    position:absolute;
                    top:0;
                    right:0;
                    width:1px;
                    height:120px;
                    background: rgba(20,20,20,.18);
                }
                .pv-block2__video{
                    margin-top:22px;
                }
                .pv-video{
                    position:relative;
                    overflow:hidden;
                    border: 1px solid rgba(20,20,20,.08);
                    background: rgba(255,255,255,.35);
                    width:100%;
                }
                @media (max-width:768px){
                    .pv-video{ height:auto; aspect-ratio: 16 / 9; }
                }

                .pv2-link{ display:block; text-decoration:none; color:inherit; }
                .pv-video__el{
                    width:100%;
                    height:100%;
                    display:block;
                    object-fit:cover;
                    object-position:center;
                }
                .pv-video__play{
                    position:absolute;
                    left:50%;
                    top:50%;
                    transform:translate(-50%,-50%);
                    width:54px;
                    height:54px;
                    border-radius:999px;
                    border:0;
                    background:#fff;
                    box-shadow:0 12px 22px rgba(0,0,0,.18);
                    cursor:pointer;
                    font-size:18px;
                    line-height:1;
                }
                .pv-block2__bottom-text{
                    margin-top:18px;
                    font-size:12px;
                    line-height:1.75;
                    font-weight:300;
                    color:var(--gallery-text, #2a2a2a);
                    max-width:none;
                }
                .pv2-top{
                    margin-top:44px;
                    display:grid;
                    grid-template-columns:repeat(4, minmax(0, 1fr));
                    gap:18px;
                    align-items:start;
                }
                .pv2-image{
                    overflow:hidden;
                    border: 1px solid rgba(20,20,20,.08);
                    background: rgba(255,255,255,.35);
                }
                .pv2-image img{
                    width:100%;
                    height:100%;
                    display:block;
                    object-fit:cover;
                    object-position:center;
                }

                .pv2-image--sq{ aspect-ratio: 1 / 1; }
                .pv2-image--wide{ aspect-ratio: 2 / 1; }

                .pv2-bottom{
                    margin-top:18px;
                    display:grid;
                    grid-template-columns: 2fr 1fr 1fr;
                    gap:18px;
                    align-items:stretch;
                }

                .pv2-bottom__left{
                    min-width:0;
                }
                .pv2-bottom__mid,
                .pv2-bottom__right{
                    min-width:0;
                }

                @media (max-width:1200px){
                    .pv-block2__inner{ padding:0 70px; }
                    .pv-block2__head{ grid-template-columns:1fr; }
                    .pv-block2__head-right::before{ display:none; }
                }
                @media (max-width:768px){
                    .pv-block2__inner{ padding:0 18px; }
                    .pv2-top{ grid-template-columns:repeat(2, minmax(0, 1fr)); }
                    .pv2-bottom{ grid-template-columns:1fr; }
                    .pv2-bottom__mid,
                    .pv2-bottom__right{ grid-column:auto; }
                }
            </style>

            <script>
                (function () {
                    var wraps = document.querySelectorAll('[data-pv-video]');
                    if (!wraps || !wraps.length) return;
                    wraps.forEach(function (wrap) {
                        var video = wrap.querySelector('.pv-video__el');
                        var btn = wrap.querySelector('.pv-video__play');
                        if (!video || !btn) return;
                        btn.addEventListener('click', function () {
                            video.setAttribute('controls', 'controls');
                            video.play();
                            btn.style.display = 'none';
                        });
                    });
                })();
            </script>
        <?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdTitle || $thirdTopLeft || $thirdTopRight || $thirdLeftVideoUrl || $thirdRightVideoUrl || $thirdBottomLeft || $thirdBottomRight): ?>
        <section class="pv-block3" aria-label="Photos & Videos block 3">
            <div class="pv-block3__inner">
                <div class="pv-block3__top">
                    <div class="pv-block3__top-left">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdTitle): ?>
                            <h2 class="pv-block3__title"><?php echo e(strtoupper((string) $thirdTitle)); ?></h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdTopLeft): ?>
                            <div class="pv-block3__text"><?php echo $thirdTopLeft; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="pv-block3__top-right">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdTopRight): ?>
                            <div class="pv-block3__text"><?php echo $thirdTopRight; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="pv-block3__videos" aria-label="Two videos">
                    <div class="pv-block3__video">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdLeftVideoUrl): ?>
                            <div class="pv-video pv-video--sq" data-pv-video>
                                <video class="pv-video__el" preload="metadata" playsinline <?php if($thirdLeftPosterUrl): ?> poster="<?php echo e($thirdLeftPosterUrl); ?>" <?php endif; ?>>
                                    <source src="<?php echo e($thirdLeftVideoUrl); ?>">
                                </video>
                                <button class="pv-video__play" type="button" aria-label="Play">▶</button>
                            </div>
                        <?php else: ?>
                            <div class="pv-block3__video-placeholder" aria-hidden="true"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="pv-block3__video">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdRightVideoUrl): ?>
                            <div class="pv-video pv-video--sq" data-pv-video>
                                <video class="pv-video__el" preload="metadata" playsinline <?php if($thirdRightPosterUrl): ?> poster="<?php echo e($thirdRightPosterUrl); ?>" <?php endif; ?>>
                                    <source src="<?php echo e($thirdRightVideoUrl); ?>">
                                </video>
                                <button class="pv-video__play" type="button" aria-label="Play">▶</button>
                            </div>
                        <?php else: ?>
                            <div class="pv-block3__video-placeholder" aria-hidden="true"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="pv-block3__bottom">
                    <div class="pv-block3__bottom-left">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdBottomLeft): ?>
                            <div class="pv-block3__text"><?php echo $thirdBottomLeft; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="pv-block3__bottom-right">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($thirdBottomRight): ?>
                            <div class="pv-block3__text"><?php echo $thirdBottomRight; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php if (! $__env->hasRenderedOnce('61465f8d-d643-4893-89da-0250ea8ba1b9')): $__env->markAsRenderedOnce('61465f8d-d643-4893-89da-0250ea8ba1b9'); ?>
            <style>
                .pv-block3{
                    background:#f7f5ef;
                    padding:84px 0 96px;
                }
                .pv-block3__inner{
                    max-width:1700px;
                    margin:0 auto;
                    padding:0 110px;
                }
                .pv-block3__top{
                    display:grid;
                    grid-template-columns: 1fr 1fr;
                    gap:40px;
                    align-items:start;
                }
                .pv-block3__title{
                    margin:0 0 10px;
                    font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                    color:var(--gallery-gold, #c88b2a);
                    font-size:28px;
                    font-weight:500;
                    letter-spacing:.04em;
                    text-transform:uppercase;
                    line-height:1.1;
                }
                .pv-block3__text{
                    font-size:12px;
                    line-height:1.75;
                    font-weight:300;
                    color:var(--gallery-text, #2a2a2a);
                    max-width:560px;
                }
                .pv-block3__videos{
                    margin-top:36px;
                    display:grid;
                    grid-template-columns: 1fr 1fr;
                    gap:34px;
                    align-items:start;
                }
                .pv-video--sq{
                    height:auto;
                    aspect-ratio: 1 / 1;
                }
                .pv-block3__video-placeholder{
                    border: 1px solid rgba(20,20,20,.08);
                    background: rgba(255,255,255,.35);
                    aspect-ratio: 1 / 1;
                }
                .pv-block3__bottom{
                    margin-top:18px;
                    display:grid;
                    grid-template-columns: 1fr 1fr;
                    gap:40px;
                    align-items:start;
                }
                @media (max-width:1200px){
                    .pv-block3__inner{ padding:0 70px; }
                }
                @media (max-width:768px){
                    .pv-block3{ padding:64px 0 74px; }
                    .pv-block3__inner{ padding:0 18px; }
                    .pv-block3__top{ grid-template-columns:1fr; }
                    .pv-block3__videos{ grid-template-columns:1fr; gap:18px; }
                    .pv-block3__bottom{ grid-template-columns:1fr; }
                    .pv-block3__text{ max-width:none; }
                }
            </style>
        <?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sliderItems->count()): ?>
        <section class="pv-slider" aria-label="Slider">
            <div class="pv-slider__inner">
                <div class="pv-slider__viewport" data-pv-slider-viewport>
                    <div class="pv-slider__track" role="list">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sliderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $imgUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($it['image']);
                                $t = $it['title_' . $locale] ?? ($it['title_en'] ?? null);
                                $txt = $it['text_' . $locale] ?? ($it['text_en'] ?? null);
                            ?>
                            <article class="pv-slide" role="listitem">
                                <a class="pv-slide__link" href="<?php echo e(route('pictures-and-videos.show', $it['id'])); ?>" aria-label="Open">
                                    <div class="pv-slide__image">
                                        <img src="<?php echo e($imgUrl); ?>" alt="" loading="lazy">
                                    </div>
                                    <div class="pv-slide__meta">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($t): ?>
                                            <div class="pv-slide__title">“<?php echo e($t); ?>”</div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($txt): ?>
                                            <div class="pv-slide__text"><?php echo e($txt); ?></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </a>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <button class="pv-slider__next" type="button" data-pv-slider-next aria-label="Next">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_string($fourthArrowLabel) && trim($fourthArrowLabel) !== ''): ?>
                        <span class="pv-slider__next-label"><?php echo e($fourthArrowLabel); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="pv-slider__next-icon" aria-hidden="true">→</span>
                </button>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($allSliderItems->count()): ?>
        <section class="pv-slider pv-slider--all" aria-label="All images slider">
            <div class="pv-slider__inner">
                <div class="pv-slider__viewport" data-pv-slider2-viewport>
                    <div class="pv-slider__track" role="list">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $allSliderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $imgUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($it['image']);
                                $textKey = 'text_' . $locale;
                                $descKey = 'description_' . $locale;
                                $rawText = $it[$textKey] ?? ($it['text_en'] ?? null);
                                if (!is_string($rawText) || trim($rawText) === '') {
                                    $rawText = $it[$descKey] ?? ($it['description_en'] ?? null);
                                }
                                $plain = is_string($rawText) ? strip_tags($rawText) : '';
                                $plain = \Illuminate\Support\Str::limit(trim($plain), 120);
                            ?>
                            <article class="pv-slide" role="listitem">
                                <a class="pv-slide__link" href="<?php echo e(route('pictures-and-videos.show', $it['id'])); ?>" aria-label="Open">
                                    <div class="pv-slide__image">
                                        <img src="<?php echo e($imgUrl); ?>" alt="" loading="lazy">
                                    </div>
                                    <div class="pv-slide__meta">
                                        <div class="pv-slide__title">“GALLERY”</div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($plain !== ''): ?>
                                            <div class="pv-slide__text"><?php echo e($plain); ?></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </a>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <button class="pv-slider__next" type="button" data-pv-slider2-next aria-label="Next">
                    <span class="pv-slider__next-icon" aria-hidden="true">→</span>
                </button>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterTitle || $afterTopText || $afterVideoUrl || $afterBottomText): ?>
        <section class="pv-after-slider" aria-label="After slider block">
            <div class="pv-after-slider__inner">
                <div class="pv-after-slider__head">
                    <div class="pv-after-slider__head-left">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterTitle): ?>
                            <h2 class="pv-after-slider__title"><?php echo e(strtoupper((string) $afterTitle)); ?></h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterTopText): ?>
                            <div class="pv-after-slider__top-text"><?php echo $afterTopText; ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="pv-after-slider__head-right" aria-hidden="true"></div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterVideoUrl): ?>
                    <div class="pv-after-slider__video">
                        <div class="pv-video" data-pv-video>
                            <video class="pv-video__el" preload="metadata" playsinline <?php if($afterPosterUrl): ?> poster="<?php echo e($afterPosterUrl); ?>" <?php endif; ?>>
                                <source src="<?php echo e($afterVideoUrl); ?>">
                            </video>
                            <button class="pv-video__play" type="button" aria-label="Play">▶</button>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($afterBottomText): ?>
                    <div class="pv-after-slider__bottom-text"><?php echo $afterBottomText; ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>

        <?php if (! $__env->hasRenderedOnce('6912be09-892f-4411-9119-528e803564cb')): $__env->markAsRenderedOnce('6912be09-892f-4411-9119-528e803564cb'); ?>
            <style>
                .pv-after-slider{
                    background:#e8d5ac;
                    padding:74px 0 84px;
                }
                .pv-after-slider__inner{
                    max-width:1700px;
                    margin:0 auto;
                    padding:0 110px;
                }
                .pv-after-slider__head{
                    display:grid;
                    grid-template-columns: 1fr 1fr;
                    gap:40px;
                    align-items:start;
                }
                .pv-after-slider__title{
                    margin:0 0 10px;
                    font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                    color:var(--gallery-gold, #c88b2a);
                    font-size:28px;
                    font-weight:500;
                    letter-spacing:.04em;
                    text-transform:uppercase;
                    line-height:1.1;
                }
                .pv-after-slider__top-text{
                    font-size:12px;
                    line-height:1.75;
                    font-weight:300;
                    color:var(--gallery-text, #2a2a2a);
                    max-width:560px;
                }
                .pv-after-slider__head-right{
                    position:relative;
                }
                .pv-after-slider__head-right::before{
                    content:"";
                    position:absolute;
                    top:0;
                    right:0;
                    width:1px;
                    height:120px;
                    background: rgba(20,20,20,.18);
                }
                .pv-after-slider__video{
                    margin-top:22px;
                }
                .pv-after-slider__bottom-text{
                    margin-top:18px;
                    font-size:12px;
                    line-height:1.75;
                    font-weight:300;
                    color:var(--gallery-text, #2a2a2a);
                    max-width:none;
                }

                @media (max-width:1200px){
                    .pv-after-slider__inner{ padding:0 70px; }
                    .pv-after-slider__head{ grid-template-columns:1fr; }
                    .pv-after-slider__head-right::before{ display:none; }
                }
                @media (max-width:768px){
                    .pv-after-slider__inner{ padding:0 18px; }
                }
            </style>
        <?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if (! $__env->hasRenderedOnce('8a74c126-4764-4f32-b165-a6fd5c53be65')): $__env->markAsRenderedOnce('8a74c126-4764-4f32-b165-a6fd5c53be65'); ?>
        <style>
            .pv-slider{
                background:#f7f5ef;
                padding:74px 0 90px;
            }
            .pv-slider__inner{
                max-width:1700px;
                margin:0 auto;
                padding:0 110px;
                position:relative;
            }
            .pv-slider__viewport{
                overflow:hidden;
                padding-right:90px; /* space for arrow */
            }
            .pv-slider__track{
                display:flex;
                gap:22px;
                align-items:flex-start;
                will-change:transform;
            }
            .pv-slide{
                flex:0 0 auto;
                width: 320px;
            }
            .pv-slide__link{
                display:block;
                text-decoration:none;
                color:inherit;
            }
            .pv-slide__image{
                width:100%;
                aspect-ratio: 1 / 1;
                overflow:hidden;
                border: 1px solid rgba(20,20,20,.08);
                background: rgba(255,255,255,.35);
            }
            .pv-slide__image img{
                width:100%;
                height:100%;
                display:block;
                object-fit:cover;
                object-position:center;
            }
            .pv-slide__meta{
                margin-top:10px;
            }
            .pv-slide__title{
                font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                color:var(--gallery-gold, #c88b2a);
                font-size:16px;
                letter-spacing:.02em;
                font-weight:500;
                text-transform:uppercase;
            }
            .pv-slide__text{
                margin-top:6px;
                font-size:11px;
                line-height:1.75;
                font-weight:300;
                color:var(--gallery-text, #2a2a2a);
            }

            .pv-slider__next{
                position:absolute;
                top: calc(50% - 22px);
                right:110px;
                transform: translateY(-50%);
                width:44px;
                height:44px;
                border-radius:999px;
                border:1px solid rgba(20,20,20,.18);
                background:#fff;
                display:grid;
                place-items:center;
                cursor:pointer;
                box-shadow: 0 10px 18px rgba(0,0,0,.08);
            }
            .pv-slider__next-label{ display:none; }
            .pv-slider__next-icon{ font-size:18px; line-height:1; }

            .pv-slider--all{
                padding-top:20px;
            }
            .pv-slider--all .pv-slide{
                width: 280px;
            }

            @media (max-width:1200px){
                .pv-slider__inner{ padding:0 70px; }
                .pv-slider__next{ right:70px; }
            }
            @media (max-width:768px){
                .pv-slider__inner{ padding:0 18px; }
                .pv-slider__viewport{ padding-right:0; overflow:auto; scroll-snap-type:x mandatory; }
                .pv-slide{ width:260px; scroll-snap-align:start; }
                .pv-slider__next{ display:none; }
                .pv-slider--all .pv-slide{ width:240px; }
            }
        </style>

        <script>
            (function () {
                function init(nextSelector, viewportSelector, fallbackWidth) {
                    var nextBtn = document.querySelector(nextSelector);
                    var viewport = document.querySelector(viewportSelector);
                    if (!nextBtn || !viewport) return;
                    nextBtn.addEventListener('click', function () {
                        var slide = viewport.querySelector('.pv-slide');
                        var slideW = slide ? (slide.getBoundingClientRect().width + 22) : fallbackWidth;
                        viewport.scrollBy({ left: slideW * 1.2, behavior: 'smooth' });
                    });
                }

                init('[data-pv-slider-next]', '[data-pv-slider-viewport]', 340);
                init('[data-pv-slider2-next]', '[data-pv-slider2-viewport]', 300);
            })();
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/pictures-and-videos/index.blade.php ENDPATH**/ ?>