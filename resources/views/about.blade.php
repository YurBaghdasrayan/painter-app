@extends('layouts.app')

@section('title', $staticPage->title ?? 'About')

@section('content')
    @php
        $hasHtml = function ($html): bool {
            $text = trim((string) strip_tags((string) $html));
            // normalize non-breaking spaces
            $text = trim(str_replace("\xc2\xa0", ' ', $text));
            return $text !== '';
        };

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
        $profileTextSide = $profile['text'] ?? '';
        $profileTextBottom = $profile['bottom_text'] ?? '';

        $youtubeUrl = $videoSection['youtube_url'] ?? '';
        $videoThumb = $videoSection['thumbnail_image'] ?? null;
        if (is_array($videoThumb)) {
            $videoThumb = $videoThumb[0] ?? null;
        }
        $videoThumbUrl = $videoThumb
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($videoThumb)
            : null;

        $videoColumns = collect($videoSection['columns'] ?? [])
            ->filter(fn ($col) => $hasHtml($col))
            ->values();

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
                if (trim((string) ($b['title'] ?? '')) !== '' || $hasHtml($b['text'] ?? '')) {
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
            $hasHtml($finalLeftText) ||
            $hasHtml($finalRightText);
    @endphp

    @section('meta_description', $heroSubtitle)

    <section class="about-page-hero" aria-label="About hero">
        <div class="about-page-hero__top">
            <div class="about-page-hero__inner">
                <h1 class="about-page-hero__title">{{ $heroTitle }}</h1>

                @if($heroSubtitle)
                    <div class="about-page-hero__subtitle">{{ $heroSubtitle }}</div>
                @endif
            </div>
        </div>

        <div class="about-page-hero__visual" aria-hidden="true">
            @if($heroBgUrl)
                <img class="about-page-hero__bg" src="{{ $heroBgUrl }}" alt="">
            @endif

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

    @if($profileImageUrl || $profileName || $profileTextSide || $profileTextBottom)
        <section class="about-page-profile" aria-label="About profile">
            <div class="about-page-profile__inner">
                @php
                    $topHtml = (string) $profileTextSide;
                    $bottomHtml = (string) $profileTextBottom;

                    // Back-compat: if bottom field is empty, split legacy HTML from side text.
                    if (trim((string) strip_tags($bottomHtml)) === '' && trim((string) strip_tags($topHtml)) !== '') {
                        $profileHtml = (string) $topHtml;
                        $topHtml = $profileHtml;
                        $bottomHtml = '';

                        preg_match_all('/<p\\b[^>]*>.*?<\\/p>/is', $profileHtml, $m);
                        $paragraphs = $m[0] ?? [];

                        if (count($paragraphs) >= 2) {
                            $topParas = array_slice($paragraphs, 0, 1);
                            $topHtml = implode('', $topParas);

                            $rest = $profileHtml;
                            foreach ($topParas as $p) {
                                $rest = \Illuminate\Support\Str::replaceFirst($p, '', $rest);
                            }
                            $bottomHtml = trim($rest);
                        }

                        // Force top block to be exactly one <p> (Figma-like).
                        $topInner = trim((string) $topHtml);
                        $topInner = preg_replace('/^<p\\b[^>]*>/i', '', $topInner);
                        $topInner = preg_replace('/<\\/p>$/i', '', $topInner);
                        $topInner = preg_replace('/<\\/?p\\b[^>]*>/i', ' ', $topInner);
                        $topInner = preg_replace('/<br\\s*\\/?>/i', ' ', $topInner);
                        $topInner = trim(preg_replace('/\\s+/u', ' ', $topInner) ?? $topInner);
                        $topHtml = $topInner !== '' ? ('<p>' . $topInner . '</p>') : '';
                    }
                @endphp

                <div class="about-page-profile__grid">
                    @if($profileImageUrl)
                        <div class="about-page-profile__media">
                            <div class="about-page-profile__image">
                                <img src="{{ $profileImageUrl }}" alt="{{ $profileName ?: 'Profile image' }}" loading="lazy">
                            </div>
                        </div>
                    @endif

                    <div class="about-page-profile__card">
                        @if($profileName)
                            <h2 class="about-page-profile__name">{{ $profileName }}</h2>
                        @endif

                        @if(trim(strip_tags($topHtml)) !== '')
                            <div class="about-page-profile__cols">
                                <div class="about-page-profile__text about-page-profile__text--cols">
                                    {!! $topHtml !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <img class="about-page-profile__line" src="{{ asset('assets/images/line.png') }}" alt="" aria-hidden="true">

                @if(trim(strip_tags($bottomHtml)) !== '')
                    <div class="about-page-profile__bottom">
                        <div class="about-page-profile__text about-page-profile__text--bottom">
                            {!! $bottomHtml !!}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if($youtubeId || $videoColumns->count())
        <section class="about-page-video" aria-label="About video">
            <div class="about-page-video__inner">
                @if($youtubeId)
                    <div class="about-page-video__media">
                        <iframe
                            class="about-page-video__iframe"
                            src="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}"
                            title="YouTube video"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>

                        @if($videoThumbUrl)
                            <div class="about-page-video__thumb" aria-hidden="true">
                                <img src="{{ $videoThumbUrl }}" alt="">
                            </div>
                        @endif

                        <button class="about-page-video__play" type="button" aria-label="Play video" data-about-video-play></button>
                    </div>
                @endif

                @if($videoColumns->count())
                    <div class="about-page-video__columns" role="list" aria-label="About video text columns">
                        @foreach($videoColumns->take(3) as $col)
                            <div class="about-page-video__col" role="listitem">
                                {!! $col !!}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif

    @php
        $hasFeature =
            trim((string) $featureTitle) !== '' ||
            $hasHtml($featureTopLeft) ||
            $hasHtml($featureTopRight) ||
            $hasHtml($featureBottomLeft) ||
            $hasHtml($featureBottomRight) ||
            !empty($featureImageUrl);
    @endphp

    @if($hasFeature)
        <section class="about-page-feature" aria-label="About feature">
            <div class="about-page-feature__inner">
                @if($featureTitle)
                    <h2 class="about-page-feature__title">{{ $featureTitle }}</h2>
                @endif

                <div class="about-page-feature__top">
                    <div class="about-page-feature__text">
                        {!! $featureTopLeft !!}
                    </div>
                    <div class="about-page-feature__text">
                        {!! $featureTopRight !!}
                    </div>
                </div>

                <div class="about-page-feature__media">
                    @if($featureImageUrl)
                        <img class="about-page-feature__img" src="{{ $featureImageUrl }}" alt="{{ $featureTitle ?: 'Feature image' }}" loading="lazy">
                    @endif

                    @if($featureButtonLink)
                        <a class="about-page-feature__arrow" href="{{ $featureButtonLink }}" aria-label="Open">
                            <span>→</span>
                        </a>
                    @endif
                </div>

                <div class="about-page-feature__bottom">
                    <div class="about-page-feature__text">
                        {!! $featureBottomLeft !!}
                    </div>
                    <div class="about-page-feature__text">
                        {!! $featureBottomRight !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    @php
        $hasDuo =
            !empty($duoLeftImageUrl) ||
            !empty($duoRightImageUrl) ||
            trim((string) $duoLeftTitle) !== '' ||
            trim((string) $duoRightTitle) !== '' ||
            $hasHtml($duoLeftText) ||
            $hasHtml($duoRightText);
    @endphp

    @if($hasDuo)
        <section class="about-page-duo" aria-label="About duo">
            <div class="about-page-duo__inner">
                <div class="about-page-duo__grid">
                    <article class="about-page-duo__card">
                        @if($duoLeftImageUrl)
                            <div class="about-page-duo__image">
                                <img src="{{ $duoLeftImageUrl }}" alt="{{ $duoLeftTitle ?: 'Image' }}" loading="lazy">
                            </div>
                        @endif

                        <div class="about-page-duo__content">
                            @if($duoLeftTitle)
                                <h3 class="about-page-duo__title">{{ $duoLeftTitle }}</h3>
                            @endif
                            <div class="about-page-duo__text">{!! $duoLeftText !!}</div>
                        </div>
                    </article>

                    <article class="about-page-duo__card">
                        @if($duoRightImageUrl)
                            <div class="about-page-duo__image">
                                <img src="{{ $duoRightImageUrl }}" alt="{{ $duoRightTitle ?: 'Image' }}" loading="lazy">
                            </div>
                        @endif

                        <div class="about-page-duo__content">
                            @if($duoRightTitle)
                                <h3 class="about-page-duo__title">{{ $duoRightTitle }}</h3>
                            @endif
                            <div class="about-page-duo__text">{!! $duoRightText !!}</div>
                        </div>
                    </article>
                </div>

{{--                <div class="about-page-duo__center-line" aria-hidden="true"></div>--}}
            </div>
        </section>
    @endif

    @if($hasQuad)
        <section class="about-page-quad" aria-label="About quad">
            <div class="about-page-quad__inner">
                <div class="about-page-quad__grid">
                    <div class="about-page-quad__side about-page-quad__side--left">
                        @foreach(array_slice($quadBlocks, 0, 2) as $block)
                            <div class="about-page-quad__block">
                                @if(trim((string) $block['title']) !== '')
                                    <div class="about-page-quad__title">{{ $block['title'] }}</div>
                                @endif
                                <div class="about-page-quad__text">{!! $block['text'] ?? '' !!}</div>
                            </div>
                        @endforeach
                    </div>

                    <div class="about-page-quad__center">
                        <div class="about-page-quad__top-line" aria-hidden="true"></div>
                        <div class="about-page-quad__center-line" aria-hidden="true"></div>

                        @if($quadCenterImageUrl)
                            <div class="about-page-quad__image">
                                <img src="{{ $quadCenterImageUrl }}" alt="Center image" loading="lazy">
                            </div>
                        @endif
                    </div>

                    <div class="about-page-quad__side about-page-quad__side--right">
                        @foreach(array_slice($quadBlocks, 2, 2) as $block)
                            <div class="about-page-quad__block">
                                @if(trim((string) $block['title']) !== '')
                                    <div class="about-page-quad__title">{{ $block['title'] }}</div>
                                @endif
                                <div class="about-page-quad__text">{!! $block['text'] ?? '' !!}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($hasFinal)
        <section class="about-page-final" aria-label="About final">
            <div class="about-page-final__inner">
                @if($finalImageUrl)
                    <div class="about-page-final__image">
                        <img src="{{ $finalImageUrl }}" alt="Final image" loading="lazy">
                    </div>
                @endif
                <div class="about-page-final__grid">
                    <div class="about-page-final__col">
                        @if($finalLeftTitle)
                            <div class="about-page-final__title">{{ $finalLeftTitle }}</div>
                        @endif
                        <div class="about-page-final__text">{!! $finalLeftText !!}</div>
                    </div>

                    <div class="about-page-final__col">
                        @if($finalRightTitle)
                            <div class="about-page-final__title">{{ $finalRightTitle }}</div>
                        @endif
                        <div class="about-page-final__text">{!! $finalRightText !!}</div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
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
@endpush

