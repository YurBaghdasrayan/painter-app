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
            aspect-ratio: auto !important;
            max-height: none !important;
            min-width: 0;
            max-width: 100%;
            box-sizing: border-box;
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

                    @if($size !== '' || $material !== '')
                        <div class="artwork-lead">
                            {{ trim(implode(' • ', array_values(array_filter([$size, $material])))) }}
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
                        <div class="artwork-detail-gallery" role="list" aria-label="Artwork detail images">
                            @foreach($detailImageUrls as $detailUrl)
                                <div class="artwork-detail-gallery__cell" role="listitem">
                                    <img
                                        src="{{ $detailUrl }}"
                                        alt="{{ $mainImageAlt }} — detail"
                                        class="js-zoomable-image"
                                        data-zoom-src="{{ $detailUrl }}"
                                        loading="lazy"
                                    />
                                </div>
                            @endforeach
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
                <section class="related" aria-label="Related artworks">
                    <div class="related-head">
                        <h2 class="related-title">
                            {{ match ($locale) {
                                'am' => 'Նույն գծից',
                                'ru' => 'С той же линии',
                                default => 'From the same line',
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
    <script>
        (function () {
            var imgs = document.querySelectorAll('.js-zoomable-image');
            if (!imgs.length) return;

            function closeModal(modal) {
                if (!modal) return;
                modal.remove();
                document.documentElement.classList.remove('is-zoom-open');
            }

            function openModal(src, alt) {
                document.documentElement.classList.add('is-zoom-open');

                var modal = document.createElement('div');
                modal.className = 'zoom-modal';
                modal.setAttribute('role', 'dialog');
                modal.setAttribute('aria-modal', 'true');

                modal.innerHTML =
                    '<div class="zoom-modal__backdrop" data-zoom-close></div>' +
                    '<div class="zoom-modal__panel" role="document">' +
                        '<button class="zoom-modal__close" type="button" aria-label="Close" data-zoom-close>×</button>' +
                        '<img class="zoom-modal__img" src="' + String(src).replace(/"/g, '&quot;') + '" alt="' + String(alt || '').replace(/"/g, '&quot;') + '">' +
                    '</div>';

                document.body.appendChild(modal);

                function onKeyDown(e) {
                    if (e.key === 'Escape') {
                        closeModal(modal);
                        document.removeEventListener('keydown', onKeyDown);
                    }
                }
                document.addEventListener('keydown', onKeyDown);

                modal.addEventListener('click', function (e) {
                    var t = e.target;
                    if (t && t.closest && t.closest('[data-zoom-close]')) {
                        closeModal(modal);
                        document.removeEventListener('keydown', onKeyDown);
                    }
                });
            }

            imgs.forEach(function (img) {
                img.style.cursor = 'zoom-in';
                img.addEventListener('click', function () {
                    var src = img.getAttribute('data-zoom-src') || img.getAttribute('src');
                    openModal(src, img.getAttribute('alt') || '');
                });
            });
        })();
    </script>
@endpush
