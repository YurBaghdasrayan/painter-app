<?php $__env->startSection('title', $staticPage->title ?? 'About'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $content = $staticPage->localizedContent() ?? [];
        $hero = $content['hero'] ?? [];
        $profile = $content['profile_section'] ?? [];
        $videoSection = $content['video_section'] ?? [];

        $heroTitle = $hero['title'] ?? 'ABOUT ME';
        $heroSubtitle = $hero['subtitle'] ?? '';
        $heroBg = $hero['background_image'] ?? null;

        if (is_array($heroBg)) {
            $heroBg = $heroBg[0] ?? null;
        }

        $heroBgUrl = $heroBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBg)
            : null;

        $profileImage = $profile['image'] ?? null;
        if (is_array($profileImage)) {
            $profileImage = $profileImage[0] ?? null;
        }
        $profileImageUrl = $profileImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($profileImage)
            : null;
        $profileName = $profile['name'] ?? '';
        $profileText = $profile['text'] ?? '';

        $youtubeUrl = $videoSection['youtube_url'] ?? '';
        $videoThumb = $videoSection['thumbnail_image'] ?? null;
        if (is_array($videoThumb)) {
            $videoThumb = $videoThumb[0] ?? null;
        }
        $videoThumbUrl = $videoThumb
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($videoThumb)
            : null;

        $videoColumns = collect($videoSection['columns'] ?? [])->filter()->values();

        $youtubeId = null;
        if (is_string($youtubeUrl) && $youtubeUrl !== '') {
            $u = parse_url($youtubeUrl);
            $host = strtolower((string) ($u['host'] ?? ''));
            $path = (string) ($u['path'] ?? '');
            parse_str((string) ($u['query'] ?? ''), $q);

            if (isset($q['v']) && is_string($q['v']) && $q['v'] !== '') {
                $youtubeId = $q['v'];
            } elseif (str_contains($host, 'youtu.be')) {
                $youtubeId = ltrim($path, '/');
            } elseif (str_contains($host, 'youtube.com') && str_starts_with($path, '/embed/')) {
                $youtubeId = trim(substr($path, strlen('/embed/')));
            }
        }

        $feature = $content['feature_section'] ?? [];
        $featureTitle = $feature['title'] ?? '';
        $featureTopLeft = $feature['top_left'] ?? '';
        $featureTopRight = $feature['top_right'] ?? '';
        $featureBottomLeft = $feature['bottom_left'] ?? '';
        $featureBottomRight = $feature['bottom_right'] ?? '';
        $featureButtonLink = $feature['button_link'] ?? null;
        $featureImage = $feature['image'] ?? null;
        if (is_array($featureImage)) {
            $featureImage = $featureImage[0] ?? null;
        }
        $featureImageUrl = $featureImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($featureImage)
            : null;

        $duo = $content['duo_section'] ?? [];
        $duoLeft = $duo['left'] ?? [];
        $duoRight = $duo['right'] ?? [];

        $duoLeftTitle = $duoLeft['title'] ?? '';
        $duoLeftText = $duoLeft['text'] ?? '';
        $duoLeftImage = $duoLeft['image'] ?? null;
        if (is_array($duoLeftImage)) {
            $duoLeftImage = $duoLeftImage[0] ?? null;
        }
        $duoLeftImageUrl = $duoLeftImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($duoLeftImage)
            : null;

        $duoRightTitle = $duoRight['title'] ?? '';
        $duoRightText = $duoRight['text'] ?? '';
        $duoRightImage = $duoRight['image'] ?? null;
        if (is_array($duoRightImage)) {
            $duoRightImage = $duoRightImage[0] ?? null;
        }
        $duoRightImageUrl = $duoRightImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($duoRightImage)
            : null;

        $quad = $content['quad_section'] ?? [];
        $quadCenterImage = $quad['center_image'] ?? null;
        if (is_array($quadCenterImage)) {
            $quadCenterImage = $quadCenterImage[0] ?? null;
        }
        $quadCenterImageUrl = $quadCenterImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($quadCenterImage)
            : null;

        $quadLeftTop = $quad['left_top'] ?? [];
        $quadLeftBottom = $quad['left_bottom'] ?? [];
        $quadRightTop = $quad['right_top'] ?? [];
        $quadRightBottom = $quad['right_bottom'] ?? [];

        $quadBlocks = [
            [
                'title' => $quadLeftTop['title'] ?? '',
                'text' => $quadLeftTop['text'] ?? '',
            ],
            [
                'title' => $quadLeftBottom['title'] ?? '',
                'text' => $quadLeftBottom['text'] ?? '',
            ],
            [
                'title' => $quadRightTop['title'] ?? '',
                'text' => $quadRightTop['text'] ?? '',
            ],
            [
                'title' => $quadRightBottom['title'] ?? '',
                'text' => $quadRightBottom['text'] ?? '',
            ],
        ];

        $hasQuad = !empty($quadCenterImageUrl);
        if (!$hasQuad) {
            foreach ($quadBlocks as $b) {
                if (trim((string) ($b['title'] ?? '')) !== '' || trim((string) ($b['text'] ?? '')) !== '') {
                    $hasQuad = true;
                    break;
                }
            }
        }

        $final = $content['final_section'] ?? [];
        $finalLeft = $final['left'] ?? [];
        $finalRight = $final['right'] ?? [];
        $finalLeftTitle = $finalLeft['title'] ?? '';
        $finalLeftText = $finalLeft['text'] ?? '';
        $finalRightTitle = $finalRight['title'] ?? '';
        $finalRightText = $finalRight['text'] ?? '';

        $finalImage = $final['image'] ?? null;
        if (is_array($finalImage)) {
            $finalImage = $finalImage[0] ?? null;
        }
        $finalImageUrl = $finalImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($finalImage)
            : null;

        $hasFinal =
            !empty($finalImageUrl) ||
            trim((string) $finalLeftTitle) !== '' ||
            trim((string) $finalRightTitle) !== '' ||
            trim((string) $finalLeftText) !== '' ||
            trim((string) $finalRightText) !== '';
    ?>

    <?php $__env->startSection('meta_description', $heroSubtitle); ?>

    <section class="about-page-hero" aria-label="About hero">
        <div class="about-page-hero__top">
            <div class="about-page-hero__inner">
                <h1 class="about-page-hero__title"><?php echo e($heroTitle); ?></h1>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                    <div class="about-page-hero__subtitle"><?php echo e($heroSubtitle); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="about-page-hero__visual" aria-hidden="true">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroBgUrl): ?>
                <img class="about-page-hero__bg" src="<?php echo e($heroBgUrl); ?>" alt="">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <svg class="about-page-hero__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
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

            <svg class="about-page-hero__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
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

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profileImageUrl || $profileName || $profileText): ?>
        <section class="about-page-profile" aria-label="About profile">
            <div class="about-page-profile__inner">
                <?php
                    $profileHtml = (string) $profileText;
                    $topHtml = $profileHtml;
                    $bottomHtml = '';

                    preg_match_all('/<p\\b[^>]*>.*?<\\/p>/is', $profileHtml, $m);
                    $paragraphs = $m[0] ?? [];

                    if (count($paragraphs) >= 3) {
                        $topParas = array_slice($paragraphs, 0, 2);
                        $topHtml = implode('', $topParas);

                        $rest = $profileHtml;
                        foreach ($topParas as $p) {
                            $rest = \Illuminate\Support\Str::replaceFirst($p, '', $rest);
                        }
                        $bottomHtml = trim($rest);
                    }
                ?>

                <div class="about-page-profile__grid">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profileImageUrl): ?>
                        <div class="about-page-profile__image">
                            <img src="<?php echo e($profileImageUrl); ?>" alt="<?php echo e($profileName ?: 'Profile image'); ?>" loading="lazy">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="about-page-profile__card">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($profileName): ?>
                            <h2 class="about-page-profile__name"><?php echo e($profileName); ?></h2>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(trim(strip_tags($topHtml)) !== ''): ?>
                            <div class="about-page-profile__cols">
                                <div class="about-page-profile__text about-page-profile__text--cols">
                                    <?php echo $topHtml; ?>

                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(trim(strip_tags($bottomHtml)) !== ''): ?>
                    <div class="about-page-profile__bottom">
                        <div class="about-page-profile__text about-page-profile__text--bottom">
                            <?php echo $bottomHtml; ?>

                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="about-page-profile__divider" aria-hidden="true"></div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($youtubeId || $videoColumns->count()): ?>
        <section class="about-page-video" aria-label="About video">
            <div class="about-page-video__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($youtubeId): ?>
                    <div class="about-page-video__media">
                        <iframe
                            class="about-page-video__iframe"
                            src="https://www.youtube-nocookie.com/embed/<?php echo e($youtubeId); ?>"
                            title="YouTube video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videoThumbUrl): ?>
                            <div class="about-page-video__thumb" aria-hidden="true">
                                <img src="<?php echo e($videoThumbUrl); ?>" alt="">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <button class="about-page-video__play" type="button" aria-label="Play video" data-about-video-play></button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($videoColumns->count()): ?>
                    <div class="about-page-video__columns" role="list" aria-label="About video text columns">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $videoColumns->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="about-page-video__col" role="listitem">
                                <?php echo $col; ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php
        $hasFeature =
            trim((string) $featureTitle) !== '' ||
            trim((string) $featureTopLeft) !== '' ||
            trim((string) $featureTopRight) !== '' ||
            trim((string) $featureBottomLeft) !== '' ||
            trim((string) $featureBottomRight) !== '' ||
            !empty($featureImageUrl);
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasFeature): ?>
        <section class="about-page-feature" aria-label="About feature">
            <div class="about-page-feature__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featureTitle): ?>
                    <h2 class="about-page-feature__title"><?php echo e($featureTitle); ?></h2>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="about-page-feature__top">
                    <div class="about-page-feature__text">
                        <?php echo $featureTopLeft; ?>

                    </div>
                    <div class="about-page-feature__text">
                        <?php echo $featureTopRight; ?>

                    </div>
                </div>

                <div class="about-page-feature__media">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featureImageUrl): ?>
                        <img class="about-page-feature__img" src="<?php echo e($featureImageUrl); ?>" alt="<?php echo e($featureTitle ?: 'Feature image'); ?>" loading="lazy">
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featureButtonLink): ?>
                        <a class="about-page-feature__arrow" href="<?php echo e($featureButtonLink); ?>" aria-label="Open">
                            <span>→</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="about-page-feature__bottom">
                    <div class="about-page-feature__text">
                        <?php echo $featureBottomLeft; ?>

                    </div>
                    <div class="about-page-feature__text">
                        <?php echo $featureBottomRight; ?>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php
        $hasDuo =
            !empty($duoLeftImageUrl) ||
            !empty($duoRightImageUrl) ||
            trim((string) $duoLeftTitle) !== '' ||
            trim((string) $duoRightTitle) !== '' ||
            trim((string) $duoLeftText) !== '' ||
            trim((string) $duoRightText) !== '';
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasDuo): ?>
        <section class="about-page-duo" aria-label="About duo">
            <div class="about-page-duo__inner">
                <div class="about-page-duo__grid">
                    <article class="about-page-duo__card">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($duoLeftImageUrl): ?>
                            <div class="about-page-duo__image">
                                <img src="<?php echo e($duoLeftImageUrl); ?>" alt="<?php echo e($duoLeftTitle ?: 'Image'); ?>" loading="lazy">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="about-page-duo__content">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($duoLeftTitle): ?>
                                <h3 class="about-page-duo__title"><?php echo e($duoLeftTitle); ?></h3>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="about-page-duo__text"><?php echo $duoLeftText; ?></div>
                        </div>
                    </article>

                    <article class="about-page-duo__card">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($duoRightImageUrl): ?>
                            <div class="about-page-duo__image">
                                <img src="<?php echo e($duoRightImageUrl); ?>" alt="<?php echo e($duoRightTitle ?: 'Image'); ?>" loading="lazy">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="about-page-duo__content">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($duoRightTitle): ?>
                                <h3 class="about-page-duo__title"><?php echo e($duoRightTitle); ?></h3>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="about-page-duo__text"><?php echo $duoRightText; ?></div>
                        </div>
                    </article>
                </div>


            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasQuad): ?>
        <section class="about-page-quad" aria-label="About quad">
            <div class="about-page-quad__inner">
                <div class="about-page-quad__grid">
                    <div class="about-page-quad__side about-page-quad__side--left">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($quadBlocks, 0, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="about-page-quad__block">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(trim((string) $block['title']) !== ''): ?>
                                    <div class="about-page-quad__title"><?php echo e($block['title']); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="about-page-quad__text"><?php echo $block['text'] ?? ''; ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="about-page-quad__center">
                        <div class="about-page-quad__top-line" aria-hidden="true"></div>
                        <div class="about-page-quad__center-line" aria-hidden="true"></div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($quadCenterImageUrl): ?>
                            <div class="about-page-quad__image">
                                <img src="<?php echo e($quadCenterImageUrl); ?>" alt="Center image" loading="lazy">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="about-page-quad__side about-page-quad__side--right">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($quadBlocks, 2, 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="about-page-quad__block">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(trim((string) $block['title']) !== ''): ?>
                                    <div class="about-page-quad__title"><?php echo e($block['title']); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="about-page-quad__text"><?php echo $block['text'] ?? ''; ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasFinal): ?>
        <section class="about-page-final" aria-label="About final">
            <div class="about-page-final__inner">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($finalImageUrl): ?>
                    <div class="about-page-final__image">
                        <img src="<?php echo e($finalImageUrl); ?>" alt="Final image" loading="lazy">
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="about-page-final__grid">
                    <div class="about-page-final__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($finalLeftTitle): ?>
                            <div class="about-page-final__title"><?php echo e($finalLeftTitle); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="about-page-final__text"><?php echo $finalLeftText; ?></div>
                    </div>

                    <div class="about-page-final__col">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($finalRightTitle): ?>
                            <div class="about-page-final__title"><?php echo e($finalRightTitle); ?></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="about-page-final__text"><?php echo $finalRightText; ?></div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function () {
            var playBtn = document.querySelector('[data-about-video-play]');
            if (!playBtn) return;
            playBtn.addEventListener('click', function () {
                var wrap = playBtn.closest('.about-page-video__media');
                if (!wrap) return;
                wrap.classList.add('is-playing');

                var iframe = wrap.querySelector('iframe');
                if (!iframe) return;
                var src = iframe.getAttribute('src') || '';
                if (src.indexOf('autoplay=1') !== -1) return;
                iframe.setAttribute('src', src + (src.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1');
            });
        })();
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/painter-app/resources/views/about.blade.php ENDPATH**/ ?>