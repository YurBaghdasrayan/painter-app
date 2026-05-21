@extends('layouts.app')

@section('title', $item->localized('title') ?? 'Artwork')

@section('content')
    <style>
        .artwork-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 20px;
            box-sizing: border-box;
            min-width: 0;
        }

        @media (max-width: 380px) {
            .artwork-inner {
                padding-left: max(10px, env(safe-area-inset-left, 0px));
                padding-right: max(10px, env(safe-area-inset-right, 0px));
            }
        }

        @media (max-width: 280px) {
            .artwork-inner {
                padding-left: max(6px, env(safe-area-inset-left, 0px));
                padding-right: max(6px, env(safe-area-inset-right, 0px));
            }
        }

        .artwork-hero {
            display: grid !important;   
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            align-items: start !important;
            column-gap: 42px;
            margin-top: 28px; /* keep comfortable distance from hero bg */
            min-width: 0;
        }

        .artwork-hero-right {
            grid-column: 1;
            grid-row: 1;
            align-self: start !important;
            margin-top: 10px !important;
            padding-top: 0 !important;
            min-width: 0;
        }

        .artwork-hero-left {
            grid-column: 2;
            grid-row: 1;
            align-self: start !important;
            min-width: 0;
        }

        .artwork-hero-image {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            aspect-ratio: auto !important;
            max-height: none !important;
            min-width: 0;
            max-width: 100%;
            box-sizing: border-box;
            line-height: 0;
        }

        .artwork-hero-image + .artwork-detail-gallery {
            margin-top: 60px !important;
            padding-top: 0 !important;
        }

        .artwork-detail-gallery {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow: hidden;
            box-sizing: border-box;
        }

        .artwork-detail-gallery__viewport {
            flex: 1 1 auto;
            min-width: 0;
            max-width: 100%;
        }

        @media (max-width: 900px) {
            .artwork-detail-gallery__viewport {
                --detail-gallery-per-page: 2;
            }
        }

        @media (max-width: 520px) {
            .artwork-detail-gallery__viewport {
                --detail-gallery-per-page: 1;
            }
        }

        .artwork-detail-gallery__cell {
            overflow: hidden !important;
        }

        .artwork-detail-gallery__frame img,
        .artwork-detail-gallery__cell .js-zoomable-image {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center center !important;
        }

        .artwork-hero-image img {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto !important;
            max-height: none !important;
            object-fit: contain !important;
            object-position: center;
            box-sizing: border-box;
        }

        /* Long tokens / URLs without spaces must not widen the page */
        .artwork-show-columns,
        .artwork-show-column {
            overflow-wrap: anywhere;
            max-width: 100%;
        }

        @media (max-width: 991px) {
            .artwork-hero {
                grid-template-columns: 1fr;
                margin-top: 0;
                row-gap: 30px;
            }

            .artwork-hero-right,
            .artwork-hero-left {
                grid-column: 1;
                grid-row: auto;
            }

            .artwork-hero-right {
                order: 1;
            }

            .artwork-hero-left {
                order: 2;
            }
        }
    </style>

    @php
        $galleryContent = $staticPage?->localizedContent() ?? [];
        $showHero = $galleryContent['show_hero'] ?? [];
        $showHeroTitle = $showHero['title'] ?? ($item->localized('title') ?? 'Artwork');
        $showHeroSubtitle = $showHero['subtitle'] ?? ($item->localized('short_description') ?? '');
        $locale = app()->getLocale();

        if ($locale === 'hy') {
            $locale = 'am';
        }

        $showColumnsRaw = $item->getAttribute('show_columns_' . $locale) ?? [];

        $showColumns = collect(is_array($showColumnsRaw) ? $showColumnsRaw : [])
            ->map(function ($row) {
                if (is_string($row)) return $row;
                if (is_array($row)) return (string) ($row['text'] ?? '');
                return '';
            })
            ->map(fn ($t) => trim((string) $t))
            ->filter(fn ($t) => trim((string) strip_tags($t)) !== '')
            ->values();

        $showHeroBg = $showHero['background_image'] ?? null;

        if (is_array($showHeroBg)) {
            $showHeroBg = $showHeroBg[0] ?? null;
        }

        $showHeroBgUrl = null;

        if (!empty($showHeroBg)) {
            $showHeroBgUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($showHeroBg);
        } elseif (!empty($item->image)) {
            $showHeroBgUrl = $item->listImagePublicUrl();
        }
    @endphp

    @if($showHeroBgUrl || $showHeroTitle || $showHeroSubtitle)
        <section class="artwork-show-hero" aria-label="Artwork hero">
            <div class="artwork-show-hero__top">
                <div class="artwork-show-hero__inner">
                    @if($showHeroTitle)
                        <h1 class="artwork-show-hero__title">{{ $showHeroTitle }}</h1>
                    @endif
                </div>
            </div>

            <div class="artwork-show-hero__visual" aria-hidden="true">
                @if($showHeroBgUrl)
                    <img class="artwork-show-hero__bg" src="{{ $showHeroBgUrl }}" alt="">
                @endif

                <svg class="artwork-show-hero__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path
                        d="M0 60 C120 105 220 15 360 42 C520 74 620 18 760 52 C930 92 1050 62 1180 34 C1280 12 1360 30 1440 10 L1440 0 L0 0 Z"
                        fill="var(--gallery-bg)"
                    />
                </svg>

                <svg class="artwork-show-hero__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path
                        d="M0 104 C120 132 210 58 332 86 C476 118 620 90 760 110 C910 132 1050 92 1188 74 C1302 58 1376 76 1440 66"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>
        </section>
    @endif

    <section class="artwork" aria-label="Artwork">
        <div class="artwork-inner">
            <header class="artwork-hero">
                <div class="artwork-hero-left">
                    <h2 class="artwork-title">{{ $item->localized('title') }}</h2>

                    @php
                        $size = trim((string) ($item->localized('size') ?? ''));
                        $material = trim((string) ($item->localized('material') ?? ''));
                        $leadText = (string) ($item->localized('short_description') ?? '');
                        $bodyText = (string) ($item->localized('full_description') ?? '');

                        if (trim((string) $bodyText) === '') {
                            $bodyText = $leadText;
                        }
                    @endphp

                    @if(trim(strip_tags($size)) !== '' || trim(strip_tags($material)) !== '')
                        <div class="artwork-meta artwork-lead">
                            @if(trim(strip_tags($size)) !== '')
                                <div class="artwork-meta__row">{!! $size !!}</div>
                            @endif
                            @if(trim(strip_tags($material)) !== '')
                                <div class="artwork-meta__row">{!! $material !!}</div>
                            @endif
                        </div>
                    @endif

                    @if(!empty($leadText))
                        @if(trim((string) strip_tags($leadText)) !== '')
                            <div class="artwork-lead">{!! $leadText !!}</div>
                        @endif
                    @endif

                    @if(trim((string) $bodyText) !== '')
                        @if(trim((string) strip_tags($bodyText)) !== '')
                            <div class="artwork-body-text">{!! $bodyText !!}</div>
                        @endif
                    @endif
                </div>

                <div class="artwork-hero-right">
                    <div class="artwork-hero-image">
                        @php
                            $mainImageUrl = $item->listImagePublicUrl();
                            $mainZoomUrl = $item->mainImagePublicUrl();
                            $mainImageAlt = (string) ($item->localized('title') ?? 'Artwork');
                        @endphp
                        <img
                            src="{{ $mainImageUrl }}"
                            alt="{{ $mainImageAlt }}"
                            class="js-zoomable-image"
                            data-zoom-src="{{ $mainZoomUrl }}"
                            loading="eager"
                        />
                    </div>

                    @php
                        $detailImageUrls = $item->detailImagesPublicUrls();
                    @endphp
                    @if(count($detailImageUrls))
                        @php
                            $detailGalleryPrevLabel = match ($locale) {
                                'am', 'hy' => 'Նախորդ մանրամասների նկարներ',
                                'ru' => 'Предыдущие детальные изображения',
                                default => 'Previous detail images',
                            };
                            $detailGalleryNextLabel = match ($locale) {
                                'am', 'hy' => 'Հաջորդ մանրամասների նկարներ',
                                'ru' => 'Следующие детальные изображения',
                                default => 'Next detail images',
                            };
                            $detailGalleryHasSlider = count($detailImageUrls) > 1;
                        @endphp
                        <div
                            class="artwork-detail-gallery"
                            data-artwork-detail-gallery
                            aria-label="Artwork detail images"
                        >
                            <button
                                type="button"
                                class="artwork-detail-gallery__prev"
                                data-artwork-detail-gallery-prev
                                aria-label="{{ $detailGalleryPrevLabel }}"
                                @if(!$detailGalleryHasSlider) hidden @endif
                            >
                                <img
                                    src="{{ asset('assets/images/arrow-left.png') }}"
                                    alt=""
                                    height="17"
                                    decoding="async"
                                />
                            </button>
                            <div class="artwork-detail-gallery__viewport">
                                <div class="artwork-detail-gallery__track" role="list">
                                    @foreach($detailImageUrls as $detailUrl)
                                        <div class="artwork-detail-gallery__cell" role="listitem">
                                            <div class="artwork-detail-gallery__frame">
                                                <img
                                                    src="{{ $detailUrl }}"
                                                    alt="{{ $mainImageAlt }} — detail"
                                                    class="js-zoomable-image"
                                                    data-zoom-src="{{ $detailUrl }}"
                                                    loading="lazy"
                                                />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button
                                type="button"
                                class="artwork-detail-gallery__next"
                                data-artwork-detail-gallery-next
                                aria-label="{{ $detailGalleryNextLabel }}"
                                @if(!$detailGalleryHasSlider) hidden @endif
                            >
                                <img
                                    src="{{ asset('assets/images/arrow-right.png') }}"
                                    alt=""
                                    height="17"
                                    decoding="async"
                                />
                            </button>
                        </div>
                    @endif

                    @if($showColumns->count())
                        <div class="artwork-show-columns" aria-label="Artwork text columns">
                            @foreach($showColumns->take(3) as $colText)
                                <div class="artwork-show-column">
                                    {!! $colText !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </header>

            @if($relatedItems->isNotEmpty())
                <section class="related related--same-line" aria-label="Related artworks">
                    <div class="related-head">
                        <h2 class="related-title">
                            {{ match ($locale) {
                                'am', 'hy' => 'Նույն շարքից',
                                'ru' => 'Из той же линии',
                                default => 'From the similar line',
                            } }}
                        </h2>
                    </div>

                    <div class="related-grid" role="list">
                        @foreach($relatedItems as $related)
                            <article class="related-card" role="listitem">
                                <a class="related-link" href="{{ route('gallery.show', $related->slug) }}" aria-label="{{ $related->localized('title') }}">
                                    <div class="related-image">
                                        <img src="{{ $related->listImagePublicUrl() }}" alt="{{ $related->localized('title') }}" loading="lazy" />
                                    </div>

                                    <div class="related-meta">
                                        <div class="related-item-title">{{ $related->localized('title') }}</div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    @php
        $zoomPrevLabel = match ($locale) {
            'am', 'hy' => 'Նախորդ նկար',
            'ru' => 'Предыдущее изображение',
            default => 'Previous image',
        };
        $zoomNextLabel = match ($locale) {
            'am', 'hy' => 'Հաջորդ նկար',
            'ru' => 'Следующее изображение',
            default => 'Next image',
        };
        $zoomCloseLabel = match ($locale) {
            'am', 'hy' => 'Փակել',
            'ru' => 'Закрыть',
            default => 'Close',
        };
    @endphp
    <script>
        (function () {
            var imgs = document.querySelectorAll('.js-zoomable-image');
            if (!imgs.length) return;

            var slides = [];
            imgs.forEach(function (img) {
                slides.push({
                    src: img.getAttribute('data-zoom-src') || img.getAttribute('src'),
                    alt: img.getAttribute('alt') || '',
                });
            });

            var prevLabel = @json($zoomPrevLabel);
            var nextLabel = @json($zoomNextLabel);
            var closeLabel = @json($zoomCloseLabel);
            var hasMany = slides.length > 1;

            function escAttr(value) {
                return String(value || '').replace(/"/g, '&quot;');
            }

            function closeModal(modal, onKeyDown) {
                if (!modal) return;
                modal.remove();
                document.documentElement.classList.remove('is-zoom-open');
                if (onKeyDown) {
                    document.removeEventListener('keydown', onKeyDown);
                }
            }

            function openModal(startIndex) {
                var current = Math.max(0, Math.min(startIndex, slides.length - 1));
                document.documentElement.classList.add('is-zoom-open');

                var modal = document.createElement('div');
                modal.className = 'zoom-modal';
                modal.setAttribute('role', 'dialog');
                modal.setAttribute('aria-modal', 'true');

                var iconClose =
                    '<svg class="zoom-modal__icon zoom-modal__icon--close" viewBox="0 0 24 24" aria-hidden="true">' +
                        '<path d="M7 7l10 10M17 7L7 17" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"/>' +
                    '</svg>';
                var iconPrev =
                    '<svg class="zoom-modal__icon zoom-modal__icon--arrow" viewBox="0 0 24 24" aria-hidden="true">' +
                        '<path d="M14 6L8 12l6 6" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"/>' +
                    '</svg>';
                var iconNext =
                    '<svg class="zoom-modal__icon zoom-modal__icon--arrow" viewBox="0 0 24 24" aria-hidden="true">' +
                        '<path d="M10 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round"/>' +
                    '</svg>';

                var navHtml = hasMany
                    ? '<button class="zoom-modal__nav zoom-modal__nav--prev" type="button" aria-label="' + escAttr(prevLabel) + '" data-zoom-prev>' + iconPrev + '</button>' +
                      '<button class="zoom-modal__nav zoom-modal__nav--next" type="button" aria-label="' + escAttr(nextLabel) + '" data-zoom-next>' + iconNext + '</button>'
                    : '';

                modal.innerHTML =
                    '<div class="zoom-modal__backdrop" data-zoom-close></div>' +
                    '<button class="zoom-modal__close" type="button" aria-label="' + escAttr(closeLabel) + '" data-zoom-close>' + iconClose + '</button>' +
                    navHtml +
                    '<div class="zoom-modal__panel" role="document">' +
                        '<img class="zoom-modal__img" src="' + escAttr(slides[current].src) + '" alt="' + escAttr(slides[current].alt) + '">' +
                    '</div>';

                document.body.appendChild(modal);

                var imgEl = modal.querySelector('.zoom-modal__img');

                function showSlide(index) {
                    current = (index + slides.length) % slides.length;
                    var slide = slides[current];
                    imgEl.src = slide.src;
                    imgEl.alt = slide.alt;
                }

                function goPrev() {
                    showSlide(current - 1);
                }

                function goNext() {
                    showSlide(current + 1);
                }

                function onKeyDown(e) {
                    if (e.key === 'Escape') {
                        closeModal(modal, onKeyDown);
                        return;
                    }
                    if (!hasMany) return;
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        goPrev();
                    }
                    if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        goNext();
                    }
                }

                document.addEventListener('keydown', onKeyDown);

                modal.addEventListener('click', function (e) {
                    var t = e.target;
                    if (!t || !t.closest) return;
                    if (t.closest('[data-zoom-close]')) {
                        closeModal(modal, onKeyDown);
                        return;
                    }
                    if (hasMany && t.closest('[data-zoom-prev]')) {
                        e.preventDefault();
                        goPrev();
                        return;
                    }
                    if (hasMany && t.closest('[data-zoom-next]')) {
                        e.preventDefault();
                        goNext();
                    }
                });

                if (hasMany) {
                    var prevBtn = modal.querySelector('[data-zoom-prev]');
                    var nextBtn = modal.querySelector('[data-zoom-next]');
                    if (prevBtn) prevBtn.addEventListener('click', function (e) { e.stopPropagation(); goPrev(); });
                    if (nextBtn) nextBtn.addEventListener('click', function (e) { e.stopPropagation(); goNext(); });
                }
            }

            imgs.forEach(function (img, index) {
                img.style.cursor = 'zoom-in';
                img.addEventListener('click', function () {
                    openModal(index);
                });
            });
        })();
    </script>
    <script>
        (function () {
            var root = document.querySelector('[data-artwork-detail-gallery]');
            if (!root) return;

            var viewport = root.querySelector('.artwork-detail-gallery__viewport');
            var track = root.querySelector('.artwork-detail-gallery__track');
            var prevBtn = root.querySelector('[data-artwork-detail-gallery-prev]');
            var nextBtn = root.querySelector('[data-artwork-detail-gallery-next]');
            var cells = track ? Array.prototype.slice.call(track.querySelectorAll('.artwork-detail-gallery__cell')) : [];
            if (!viewport || !track || !cells.length) return;

            var page = 0;

            function readPx(value, fallback) {
                var n = parseFloat(String(value || '').replace('px', ''));
                return isFinite(n) && n > 0 ? n : fallback;
            }

            function perPage() {
                var fromCss = readPx(getComputedStyle(root).getPropertyValue('--detail-gallery-per-page'), 3);
                return Math.max(1, Math.round(fromCss));
            }

            function thumbGap() {
                return readPx(getComputedStyle(track).gap, 17);
            }

            function thumbHeight() {
                return readPx(getComputedStyle(root).getPropertyValue('--detail-gallery-thumb-h'), 130);
            }

            function maxCellWidth() {
                return readPx(getComputedStyle(root).getPropertyValue('--detail-gallery-cell-width'), 200);
            }

            function viewportWidth() {
                return Math.round(viewport.getBoundingClientRect().width);
            }

            function syncThumbSizes() {
                var pp = perPage();
                var gap = thumbGap();
                var vw = viewportWidth();
                var cap = maxCellWidth();
                var h = thumbHeight() + 'px';
                if (vw <= 0) return;

                var gapsTotal = Math.round(gap * (pp - 1));
                var available = Math.max(0, vw - gapsTotal);
                var w = Math.min(cap, Math.max(1, Math.floor(available / pp)));

                cells.forEach(function (cell) {
                    var ws = w + 'px';
                    cell.style.flex = '0 0 ' + ws;
                    cell.style.width = ws;
                    cell.style.minWidth = ws;
                    cell.style.maxWidth = ws;
                    cell.style.height = h;
                });
            }

            function offsetForPage(targetPage) {
                var start = targetPage * perPage();
                if (start <= 0) return 0;

                var gap = thumbGap();
                var offset = 0;
                var i;

                for (i = 0; i < start && i < cells.length; i++) {
                    offset += Math.round(cells[i].getBoundingClientRect().width);
                    if (i < start - 1) {
                        offset += gap;
                    }
                }

                return offset;
            }

            function maxPage() {
                return Math.max(0, Math.ceil(cells.length / perPage()) - 1);
            }

            function updateNav() {
                var last = maxPage();
                var show = cells.length > perPage();

                if (prevBtn) {
                    prevBtn.hidden = !show;
                    prevBtn.disabled = page <= 0;
                }
                if (nextBtn) {
                    nextBtn.hidden = !show;
                    nextBtn.disabled = page >= last;
                }
            }

            function apply() {
                var last = maxPage();
                if (page > last) page = last;
                if (page < 0) page = 0;

                syncThumbSizes();

                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        track.style.transform = 'translate3d(-' + offsetForPage(page) + 'px, 0, 0)';
                        updateNav();
                    });
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    if (page > 0) {
                        page -= 1;
                        apply();
                    }
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    if (page < maxPage()) {
                        page += 1;
                        apply();
                    }
                });
            }

            var resizeTimer;
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(apply, 100);
            });

            if (typeof ResizeObserver !== 'undefined') {
                var ro = new ResizeObserver(function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(apply, 100);
                });
                ro.observe(viewport);
                ro.observe(root);
            }

            cells.forEach(function (cell) {
                var img = cell.querySelector('img');
                if (!img) return;
                if (img.complete) return;
                img.addEventListener('load', apply, { once: true });
            });

            apply();
        })();
    </script>
@endpush
