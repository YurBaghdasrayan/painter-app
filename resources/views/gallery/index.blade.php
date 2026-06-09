@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    @php
        $heroBlock = $staticPage?->getBlock('hero') ?? [];
        $heroTitle = match (app()->getLocale()) {
            'hy' => 'ՊԱՏԿԵՐԱՍՐԱՀ',
            'ru' => 'ГАЛЕРЕЯ',
            default => 'GALLERY',
        };
        $heroSubtitle = $heroBlock['subtitle'] ?? '';

        $heroBg = $heroBlock['background_image'] ?? null;
        $heroMain = $heroBlock['main_image'] ?? null;

        if (is_array($heroBg)) $heroBg = $heroBg[0] ?? null;
        if (is_array($heroMain)) $heroMain = $heroMain[0] ?? null;

        $heroBgUrl = !empty($heroBg)
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBg)
            : asset('assets/images/gallery.hero.bg.png');

        $heroMainUrl = !empty($heroMain)
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMain)
            : null;

        $locale = app()->getLocale();

        $moreText = match ($locale) {
            'hy' => 'Ավելին',
            'ru' => 'Подробнее',
            default => 'More',
        };

        $lessText = match ($locale) {
            'hy' => 'Փակել',
            'ru' => 'Скрыть',
            default => 'Less',
        };
    @endphp

    @section('meta_description', strip_tags((string) $heroSubtitle))

    <section class="gallery-hero" aria-label="Gallery hero">
        <div class="gallery-hero-inner">
            <h1 class="gallery-hero-title">
                {{ $heroTitle }}
            </h1>

            @if(!empty($heroSubtitle) && trim((string) strip_tags((string) $heroSubtitle)) !== '')
                <div class="gallery-hero-subtitle">{!! (string) $heroSubtitle !!}</div>
            @endif
        </div>

        <div class="gallery-hero-art">
            <div class="gallery-hero-art-bg">
                <img src="{{ $heroBgUrl }}" alt="{{ $heroTitle }}">
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

            @if($heroMainUrl || ($heroItem && !empty($heroItem->image)))
                <article class="gallery-hero-featured">
                    @php
                        $featuredUsesItemImage = ! $heroMainUrl && $heroItem && ! empty($heroItem->image);
                        $featuredImgUrl = $heroMainUrl ?: $heroItem->mainImagePublicUrl();
                        $featuredAlt = $featuredUsesItemImage
                            ? ($heroItem->localized('title') ?? $heroTitle)
                            : $heroTitle;
                        $featuredHref = $featuredUsesItemImage && ! empty($heroItem->slug)
                            ? route('gallery.show', $heroItem->slug)
                            : null;
                    @endphp

                    @if($featuredHref)
                        <a href="{{ $featuredHref }}" class="gallery-hero-featured-link" aria-label="{{ $featuredAlt }}">
                            <img src="{{ $featuredImgUrl }}" alt="{{ $featuredAlt }}">
                        </a>
                    @else
                        <div class="gallery-hero-featured-link" aria-hidden="true">
                            <img src="{{ $featuredImgUrl }}" alt="{{ $featuredAlt }}">
                        </div>
                    @endif
                </article>
            @endif
        </div>
    </section>

    @php
        /** Figma: row counts for first 32 items, then rows of 3 */
        $galleryIndexRowSpec = [
            ['n' => 2, 'h' => 840],
            ['n' => 4, 'h' => 529],
            ['n' => 3, 'h' => 460],
            ['n' => 4, 'h' => 370],
            ['n' => 4, 'h' => 370],
            ['n' => 4, 'h' => 370],
            ['n' => 2, 'h' => 840],
            ['n' => 3, 'h' => 460],
            ['n' => 3, 'h' => 460],
            ['n' => 3, 'h' => 460],
        ];
        $list = (($items ?? collect())
            ->filter(static function ($item) {
                return ! empty($item->image) && ! empty($item->slug);
            })
            ->values());
        $galleryRows = [];
        $offset = 0;
        foreach ($galleryIndexRowSpec as $spec) {
            if ($offset >= $list->count()) {
                break;
            }
            $chunk = $list->slice($offset, $spec['n']);
            if ($chunk->isEmpty()) {
                break;
            }
            $galleryRows[] = ['items' => $chunk, 'h' => (int) $spec['h']];
            $offset += $chunk->count();
        }
        while ($offset < $list->count()) {
            $chunk = $list->slice($offset, 3);
            if ($chunk->isEmpty()) {
                break;
            }
            $galleryRows[] = ['items' => $chunk, 'h' => 460];
            $offset += $chunk->count();
        }
    @endphp

    @if(count($galleryRows))
        <section class="gallery-index" aria-label="Gallery index">
            <div class="gallery-inner">
                <div class="gallery-index-matrix">
                    @foreach($galleryRows as $row)
                        <div
                            class="gallery-index-row{{ $row['items']->count() === 2 ? ' gallery-index-row--duo' : '' }}"
                            data-target-h="{{ $row['h'] }}"
                            style="--gallery-row-h: {{ $row['h'] }}px"
                        >
                            @foreach($row['items'] as $item)
                                @php
                                    $img = !empty($item->image) ? $item->mainImagePublicUrl() : null;
                                    $title = $item->localized('title') ?? 'Gallery';
                                    $size = trim((string) ($item->localized('size') ?? ''));
                                    $material = trim((string) ($item->localized('material') ?? ''));
                                @endphp
                                    <article class="gallery-section-card" role="article">
                                        <a class="gallery-section-card-image" href="{{ route('gallery.show', $item->slug) }}" aria-label="{{ $title }}">
                                            <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" />
                                        </a>

                                        <div class="gallery-section-card-meta">
                                            <a class="gallery-section-card-title" href="{{ route('gallery.show', $item->slug) }}">
                                                “{{ strtoupper((string) $title) }}”
                                            </a>

                                            @if(trim(strip_tags($size)) !== '' || trim(strip_tags($material)) !== '')
                                                <div class="gallery-section-card-desc js-gallery-desc">
                                                    @if(trim(strip_tags($size)) !== '')
                                                        <div class="gallery-section-card-desc-line">{!! $size !!}</div>
                                                    @endif
                                                    @if(trim(strip_tags($material)) !== '')
                                                        <div class="gallery-section-card-desc-line">{!! $material !!}</div>
                                                    @endif
                                                </div>

                                                <button
                                                    type="button"
                                                    class="gallery-more-btn js-gallery-more"
                                                    data-more="{{ $moreText }}"
                                                    data-less="{{ $lessText }}"
                                                >
                                                    {{ $moreText }}
                                                </button>
                                            @endif
                                        </div>
                                    </article>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-gallery-more').forEach(function (button) {
                const card = button.closest('.gallery-section-card');
                const desc = card ? card.querySelector('.js-gallery-desc') : null;

                if (!desc) return;

                if (desc.scrollHeight <= desc.clientHeight + 5) {
                    button.style.display = 'none';
                }

                button.addEventListener('click', function () {
                    desc.classList.toggle('is-expanded');

                    button.textContent = desc.classList.contains('is-expanded')
                        ? button.dataset.less
                        : button.dataset.more;
                });
            });

            (function () {
                const GAP = 28;
                const mq = window.matchMedia('(min-width: 1025px)');

                function debounce(fn, ms) {
                    let t;
                    return function () {
                        clearTimeout(t);
                        t = setTimeout(fn, ms);
                    };
                }

                function rowGap(row) {
                    const g = parseFloat(getComputedStyle(row).columnGap || getComputedStyle(row).gap, 10);
                    return Number.isFinite(g) && g >= 0 ? g : GAP;
                }

                function rowWidthAtHeight(imgs, h, gap) {
                    let sum = 0;
                    for (let i = 0; i < imgs.length; i++) {
                        const img = imgs[i];
                        const nw = img.naturalWidth;
                        const nh = img.naturalHeight;
                        if (!nw || !nh) {
                            return null;
                        }
                        sum += nw * (h / nh);
                    }
                    return sum + gap * Math.max(0, imgs.length - 1);
                }

                function fitRow(row) {
                    if (!mq.matches) {
                        row.style.removeProperty('--gallery-row-h');
                        return;
                    }
                    const imgs = Array.prototype.slice.call(row.querySelectorAll('.gallery-section-card-image img'));
                    if (!imgs.length) return;
                    const tgt = parseFloat(row.getAttribute('data-target-h'), 10);
                    if (!tgt || tgt <= 0) return;
                    const cw = row.clientWidth;
                    if (cw <= 0) return;

                    const gap = rowGap(row);
                    let sumw = rowWidthAtHeight(imgs, tgt, gap);
                    if (sumw == null) return;
                    if (sumw <= 0) return;

                    const isDuo = row.classList.contains('gallery-index-row--duo');
                    let h;
                    if (isDuo) {
                        /* Figma rows 1 & 7: target height, centered — do not stretch to fill row width */
                        h = sumw > cw ? tgt * (cw / sumw) : tgt;
                    } else {
                        h = tgt * (cw / sumw);
                    }
                    row.style.setProperty('--gallery-row-h', h.toFixed(2) + 'px');
                }

                function fitAll() {
                    document.querySelectorAll('.gallery-index-row').forEach(fitRow);
                }

                fitAll();
                window.addEventListener('resize', debounce(fitAll, 120));
                if (mq.addEventListener) {
                    mq.addEventListener('change', fitAll);
                } else if (mq.addListener) {
                    mq.addListener(fitAll);
                }

                document.querySelectorAll('.gallery-index-row img').forEach(function (img) {
                    if (!img.complete) {
                        img.addEventListener('load', fitAll, { once: true });
                    }
                });
            })();
        });
    </script>

    <style>
        @media (min-width: 1025px) {
            .gallery-index-row--duo {
                box-sizing: border-box !important;
                width: 100% !important;
                max-width: min(1180px, 78%) !important;
                margin-left: auto !important;
                margin-right: auto !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                justify-content: center !important;
                gap: clamp(32px, 3vw, 52px) !important;
            }
        }

        @media (max-width: 1024px) {
            .gallery-inner,
            .gallery-hero-inner {
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 24px !important;
                padding-right: 24px !important;
                box-sizing: border-box !important;
            }

            .gallery-index-matrix{
                gap: 26px !important;
            }

            .gallery-index-row{
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 22px !important;
            }

            .gallery-index-row--duo{
                max-width: none !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .gallery-index-row .gallery-section-card{
                width: 100% !important;
                max-width: 100% !important;
            }

            .gallery-index-row .gallery-section-card-image{
                width: 100% !important;
                height: auto !important;
                max-width: 100% !important;
            }

            .gallery-index-row .gallery-section-card-image img{
                height: auto !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .gallery-index-row .gallery-section-card{
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
            }

            .gallery-section-card-meta {
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                padding: 0 8px !important;
                box-sizing: border-box !important;
                text-align: center !important;
                overflow: visible !important;
            }

            .gallery-section-card-title {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 0 8px 0 !important;
                font-size: 20px !important;
                line-height: 1.35 !important;
                overflow-wrap: break-word !important;
                word-break: normal !important;
            }

            .gallery-section-card-desc {
                display: flex !important;
                flex-direction: column !important;
                gap: 4px !important;
                width: 100% !important;
                max-width: 100% !important;
                font-size: 16px !important;
                line-height: 1.5 !important;
                max-height: none !important;
                overflow: visible !important;
                overflow-wrap: break-word !important;
                word-break: normal !important;
            }

            .gallery-section-card-desc-line {
                margin: 0 !important;
                padding: 0 !important;
                font-size: 16px !important;
                line-height: 1.5 !important;
                font-weight: 800 !important;
            }

            .gallery-section-card-desc-line :is(p, div, span, li) {
                margin: 0 !important;
                padding: 0 !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }

            .gallery-more-btn {
                display: inline-block !important;
                margin-top: 8px !important;
                padding: 0 !important;
                border: 0 !important;
                background: transparent !important;
                color: #b77b2b !important;
                font-size: 16px !important;
                font-weight: 600 !important;
                line-height: 1.2 !important;
                white-space: nowrap !important;
                overflow-wrap: normal !important;
                word-break: keep-all !important;
                cursor: pointer !important;
                font-family: inherit !important;
            }
        }

        @media (max-width: 768px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }

            .gallery-index-matrix{
                gap: 22px !important;
            }

            .gallery-section-card-title {
                font-size: 18px !important;
            }

            .gallery-section-card-desc {
                font-size: 16px !important;
            }
        }

        @media (max-width: 480px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }

            .gallery-index-matrix{
                gap: 20px !important;
            }

            .gallery-section-card-title {
                font-size: 17px !important;
                line-height: 1.3 !important;
            }

            .gallery-section-card-desc {
                font-size: 16px !important;
                line-height: 1.5 !important;
            }
        }

        @media (max-width: 390px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .gallery-index-matrix{
                gap: 18px !important;
            }

            .gallery-section-card-title {
                font-size: 16px !important;
            }

            .gallery-section-card-desc {
                font-size: 16px !important;
            }
        }
    </style>
@endsection
