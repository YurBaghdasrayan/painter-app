@extends('layouts.app')

@section('title', $heroSection?->localized('title') ?? 'Gallery')

@section('content')
    @php
        $heroTitle = $staticPage?->getBlock('hero')['title'] ?? ($heroSection?->localized('title') ?? 'Art Gallery');
        $heroSubtitle = $staticPage?->getBlock('hero')['subtitle'] ?? ($heroSection?->localized('left_text') ?? '');

    $bottomFeature = $staticPage?->getBlock('bottom_feature_section') ?? [];
    $bottomFeatureTitle = $bottomFeature['title'] ?? null;
    $bottomFeatureItems = collect($bottomFeature['items'] ?? [])->filter()->values();
    $bottomFeatureButtonLink = $bottomFeature['button_link'] ?? null;

    $bottomFeatureImage = $bottomFeature['image'] ?? null;

    if (is_array($bottomFeatureImage)) {
        $bottomFeatureImage = $bottomFeatureImage[0] ?? null;
    }

    if (empty($bottomFeatureImage) && $staticPage) {
        foreach (['en', 'ru', 'am'] as $fallbackLocale) {
            $fallbackBlock = $staticPage->getBlock('bottom_feature_section', $fallbackLocale);
            $candidateImage = $fallbackBlock['image'] ?? null;

            if (is_array($candidateImage)) {
                $candidateImage = $candidateImage[0] ?? null;
            }

            if (!empty($candidateImage)) {
                $bottomFeatureImage = $candidateImage;
                break;
            }
        }
    }
    @endphp

    <section class="gallery-hero" aria-label="Gallery hero">
        <div class="gallery-hero-inner">
            <h1 class="gallery-hero-title">
                {{ $heroTitle }}
            </h1>

            @if(!empty($heroSubtitle))
                <p class="gallery-hero-subtitle">
                    {{ $heroSubtitle }}
                </p>
            @endif
        </div>

        <div class="gallery-hero-art">
            <div class="gallery-hero-art-bg">
                @if($heroItem && !empty($heroItem->image))
                    <img
                        src="{{ asset('assets/images/gallery.hero.bg.png') }}"
                        alt="{{ $heroItem->localized('title') }}"
                    >
                @endif
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

            @if($heroItem && !empty($heroItem->image))
                <article class="gallery-hero-featured">
                    @if($heroSection)
                        <a href="{{ route('gallery.section', $heroSection) }}" class="gallery-hero-featured-link">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($heroItem->image) }}"
                                alt="{{ $heroItem->localized('title') }}"
                            >
                        </a>
                    @else
                        <div class="gallery-hero-featured-link">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($heroItem->image) }}"
                                alt="{{ $heroItem->localized('title') }}"
                            >
                        </div>
                    @endif
                </article>
            @endif
        </div>
    </section>

    @if($sections->count())
        @php
            $head = $sections->first();
            $topGridSections = $sections->count() > 5 ? $sections->take(5) : $sections;
            $sliderSections = $sections->take(5);
            $tailSections = $sections->count() > 5 ? $sections->slice(5)->values() : collect();
            $sectionsSliderId = 'gallery-index-sections-slider';
        @endphp

        <section class="gallery-index" aria-label="Gallery index">
            <div class="gallery-inner">
                <div class="gallery-head">
                    <h2 class="gallery-title">{{ $head->localized('title') }}</h2>

                    <div class="gallery-toptexts">
                        <div class="gallery-toptext gallery-toptext--left">
                            {!! nl2br(e($head->localized('left_text') ?? '')) !!}
                        </div>
                        <div class="gallery-toptext gallery-toptext--right">
                            {!! nl2br(e($head->localized('right_text') ?? '')) !!}
                        </div>
                    </div>
                </div>

                <div class="gallery-section-grid" role="list">
                    @foreach($topGridSections as $section)
                        @include('gallery.partials.section-card', ['section' => $section])
                    @endforeach
                </div>
            </div>
        </section>

        @if($sections->count() > 1)
            <section class="gallery-index-slider" aria-label="All gallery sections">
                <div class="gallery-index-slider-inner">
                    <div class="gallery-index-slider-wrap">
                        <button
                            class="gallery-index-slider-arrow gallery-index-slider-arrow--left"
                            type="button"
                            data-gallery-slider-prev="{{ $sectionsSliderId }}"
                            data-gallery-index-slider-nav="prev"
                            hidden
                            aria-hidden="true"
                            aria-label="Previous"
                        ></button>

                        <button
                            class="gallery-index-slider-arrow gallery-index-slider-arrow--right"
                            type="button"
                            data-gallery-slider-next="{{ $sectionsSliderId }}"
                            data-gallery-index-slider-nav="next"
                            hidden
                            aria-hidden="true"
                            aria-label="Next"
                        ></button>

                        <div
                            class="gallery-index-slider-track"
                            id="{{ $sectionsSliderId }}"
                            data-gallery-index-slider-track="{{ $sectionsSliderId }}"
                            role="list"
                        >
                            @foreach($sliderSections as $section)
                                @php
                                    $coverItem = ($section->items ?? collect())->first();
                                @endphp

                                @if($coverItem && !empty($coverItem->image))
                                    <article class="gallery-index-slider-card" role="listitem">
                                        <a class="gallery-index-slider-card-link" href="{{ route('gallery.section', $section) }}">
                                            <div class="gallery-index-slider-image">
                                                <img
                                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image) }}"
                                                    alt="{{ $section->localized('title') }}"
                                                    loading="lazy"
                                                >
                                            </div>

                                            <div class="gallery-index-slider-meta">
                                                <div class="gallery-index-slider-section-title">
                                                    “{{ strtoupper((string) ($section->localized('title') ?? 'Gallery')) }}”
                                                </div>

                                                @php
                                                    $desc = trim((string) ($section->localized('left_text') ?? ''));
                                                    if ($desc === '') {
                                                        $desc = trim((string) ($section->localized('right_text') ?? ''));
                                                    }
                                                @endphp

                                                @if($desc !== '')
                                                    <div class="gallery-index-slider-section-desc">
                                                        {{ $desc }}
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </article>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            @if($tailSections->count())
                <section class="gallery-index-tail" aria-label="More gallery sections">
                    <div class="gallery-index-tail-inner">
                        <div class="gallery-masonry" role="list">
                            @foreach($tailSections as $section)
                                @php
                                    $coverItem = ($section->items ?? collect())->first();
                                @endphp

                                @if($coverItem && !empty($coverItem->image))
                                    <article class="gallery-masonry-card" role="listitem">
                                        <a class="gallery-masonry-card-link" href="{{ route('gallery.section', $section) }}">
                                            <div class="gallery-masonry-image">
                                                <img
                                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image) }}"
                                                    alt="{{ $section->localized('title') }}"
                                                    loading="lazy"
                                                >
                                            </div>

                                            <div class="gallery-masonry-meta">
                                                <div class="gallery-masonry-title">“GALLERY”</div>

                                                @php
                                                    $desc = trim((string) ($section->localized('left_text') ?? ''));
                                                    if ($desc === '') {
                                                        $desc = trim((string) ($section->localized('right_text') ?? ''));
                                                    }
                                                @endphp

                                                @if($desc !== '')
                                                    <div class="gallery-masonry-desc">{{ $desc }}</div>
                                                @endif
                                            </div>
                                        </a>
                                    </article>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif

    @if($bottomFeatureTitle || $bottomFeatureItems->count() || $bottomFeatureImage)

        <section class="gallery-bottom-feature" aria-label="Gallery bottom feature">
            <div class="gallery-bottom-feature-inner">
                <div class="gallery-bottom-feature-content">
                    @if($bottomFeatureTitle)
                        <h2 class="gallery-bottom-feature-title">“{{ $bottomFeatureTitle }}”</h2>
                    @endif

                    @if($bottomFeatureItems->count())
                        <ul class="gallery-bottom-feature-list">
                            @foreach($bottomFeatureItems as $featureText)
                                <li>{!! $featureText !!}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="gallery-bottom-feature-media">
                    @if($bottomFeatureImage)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($bottomFeatureImage) }}"
                            alt="{{ $bottomFeatureTitle ?? 'Gallery feature image' }}"
                            class="gallery-bottom-feature-image"
                        >
                    @endif

                    @if($bottomFeatureButtonLink)
                        <a href="{{ $bottomFeatureButtonLink }}" class="gallery-bottom-feature-arrow" aria-label="Open feature">
                            <span>→</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        (function () {
            function scrollSlider(sliderEl, direction) {
                if (!sliderEl) return;
                var card = sliderEl.querySelector('.gallery-index-slider-card');
                var step = card ? (card.getBoundingClientRect().width + 18) : 320;
                sliderEl.scrollBy({ left: direction * step, behavior: 'smooth' });
            }

            function updateGalleryIndexSliderNav(sliderId) {
                var track = document.querySelector('[data-gallery-index-slider-track="' + sliderId + '"]');
                if (!track) return;

                var wrap = track.closest('.gallery-index-slider-wrap');
                if (!wrap) return;

                var prev = wrap.querySelector('[data-gallery-index-slider-nav="prev"]');
                var next = wrap.querySelector('[data-gallery-index-slider-nav="next"]');
                if (!prev || !next) return;

                var overflowing = track.scrollWidth - track.clientWidth > 1;

                track.classList.toggle('is-overflowing', overflowing);

                prev.hidden = !overflowing;
                next.hidden = !overflowing;
                prev.setAttribute('aria-hidden', overflowing ? 'false' : 'true');
                next.setAttribute('aria-hidden', overflowing ? 'false' : 'true');
            }

            function bindGalleryIndexSlider(sliderId) {
                var track = document.querySelector('[data-gallery-index-slider-track="' + sliderId + '"]');
                if (!track) return;

                var ro = null;
                if (typeof ResizeObserver !== 'undefined') {
                    ro = new ResizeObserver(function () {
                        updateGalleryIndexSliderNav(sliderId);
                    });
                    ro.observe(track);
                }

                window.addEventListener('resize', function () {
                    updateGalleryIndexSliderNav(sliderId);
                });

                track.addEventListener('scroll', function () {
                    updateGalleryIndexSliderNav(sliderId);
                }, { passive: true });

                window.addEventListener('load', function () {
                    updateGalleryIndexSliderNav(sliderId);
                });

                Array.prototype.forEach.call(track.querySelectorAll('img'), function (img) {
                    if (img.complete) return;
                    img.addEventListener('load', function () {
                        updateGalleryIndexSliderNav(sliderId);
                    }, { once: true });
                });

                requestAnimationFrame(function () {
                    updateGalleryIndexSliderNav(sliderId);
                });
            }

            document.addEventListener('click', function (e) {
                var prev = e.target.closest('[data-gallery-slider-prev]');
                if (prev) {
                    if (prev.hidden) return;
                    var id = prev.getAttribute('data-gallery-slider-prev');
                    scrollSlider(document.getElementById(id), -1);
                    return;
                }

                var next = e.target.closest('[data-gallery-slider-next]');
                if (next) {
                    if (next.hidden) return;
                    var id2 = next.getAttribute('data-gallery-slider-next');
                    scrollSlider(document.getElementById(id2), 1);
                }
            });

            bindGalleryIndexSlider(@json($sectionsSliderId ?? 'gallery-index-sections-slider'));
        })();
    </script>
@endpush
