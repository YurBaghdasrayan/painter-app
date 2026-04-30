@extends('layouts.app')

@section('title', $section->localized('title') ?? 'Gallery')

@section('content')
    @php
        $galleryPage = \App\Models\StaticPage::query()
            ->where('slug', 'gallery')
            ->where('is_active', true)
            ->first();

        $galleryContent = $galleryPage?->localizedContent() ?? [];
        $hero = $galleryContent['hero'] ?? [];

        $heroTitle = $hero['title'] ?? 'Art Gallery';
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBackgroundImage = $hero['background_image'] ?? null;
        $heroMainImage = $hero['main_image'] ?? null;

        $heroBackgroundImageUrl = $heroBackgroundImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBackgroundImage)
            : null;

        $heroMainImageUrl = $heroMainImage
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMainImage)
            : null;

        $items = $section->items ?? collect();
        $topItems = $items->take(5);
        $tailItems = $items->slice(5)->values();
    @endphp

    <section class="gallery-section-page">
        <section class="gallery-section-hero" aria-label="Gallery hero">
            <div class="gallery-section-hero__top">
                <div class="gallery-section-hero__inner">
                    <h1 class="gallery-section-hero__title">{{ $heroTitle }}</h1>

                    @if($heroSubtitle)
                        <p class="gallery-section-hero__subtitle">{{ $heroSubtitle }}</p>
                    @endif
                </div>
            </div>

            <div class="gallery-section-hero__visual">
                @if($heroBackgroundImageUrl)
                    <img
                        src="{{ $heroBackgroundImageUrl }}"
                        alt="{{ $heroTitle }}"
                        class="gallery-section-hero__bg"
                    >
                @endif

                <div class="gallery-section-hero__shape"></div>

                <svg class="gallery-section-hero__line" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

                @if($heroMainImageUrl)
                    <div class="gallery-section-hero__floating-image-wrap">
                        <div class="gallery-section-hero__floating-image-box">
                            <img
                                src="{{ $heroMainImageUrl }}"
                                alt="{{ $heroTitle }}"
                                class="gallery-section-hero__floating-image"
                            >
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="gallery-page" aria-label="Gallery section">
            <div class="gallery-page-inner">
                <header class="gallery-page-head">
                    <h2 class="gallery-page-section-title">
                        {{ $section->localized('title') ?? 'Gallery' }}
                    </h2>

                    <div class="gallery-page-toptexts">
                        <div class="gallery-page-toptext">
                            {!! nl2br(e($section->localized('left_text') ?? '')) !!}
                        </div>

                        <div class="gallery-page-toptext">
                            {!! nl2br(e($section->localized('right_text') ?? '')) !!}
                        </div>
                    </div>
                </header>

                @if($topItems->count())
                    <div class="gallery-page-grid" role="list">
                        @foreach($topItems as $item)
                            <article class="gallery-page-card" role="listitem">
                                <a class="gallery-page-card-link" href="{{ route('gallery.show', $item->slug) }}">
                                    <div class="gallery-page-image">
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}"
                                            alt="{{ $item->localized('title') }}"
                                            loading="lazy"
                                        >
                                    </div>

                                    <div class="gallery-page-meta">
                                        <div class="gallery-page-item-title">{{ $item->localized('title') }}</div>

                                        @if(!empty($item->localized('short_description')))
                                            <div class="gallery-page-item-desc">
                                                {{ $item->localized('short_description') }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

        @php
            $sectionsForCards = $sectionsForCards ?? collect();
            $sectionsSliderId = 'gallery-section-sections-slider';
        @endphp

        @if($sectionsForCards->count())
            <section class="gallery-index-slider" aria-label="All gallery sections">
                <div class="gallery-index-slider-inner gallery-page-inner">
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
                            @foreach($sectionsForCards as $cardSection)
                                @php
                                    $coverItem = ($cardSection->items ?? collect())->first();
                                @endphp

                                @if($coverItem && !empty($coverItem->image))
                                    <article class="gallery-index-slider-card" role="listitem">
                                        <a class="gallery-index-slider-card-link" href="{{ route('gallery.section', $cardSection) }}">
                                            <div class="gallery-index-slider-image">
                                                <img
                                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image) }}"
                                                    alt="{{ $cardSection->localized('title') }}"
                                                    loading="lazy"
                                                >
                                            </div>

                                            <div class="gallery-index-slider-meta">
                                                <div class="gallery-index-slider-section-title">
                                                    “{{ strtoupper((string) ($cardSection->localized('title') ?? 'Gallery')) }}”
                                                </div>

                                                @php
                                                    $desc = trim((string) ($cardSection->localized('left_text') ?? ''));
                                                    if ($desc === '') {
                                                        $desc = trim((string) ($cardSection->localized('right_text') ?? ''));
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
        @endif

        @if($tailItems->count())
            <section class="gallery-index-tail" aria-label="More artworks">
                <div class="gallery-index-tail-inner gallery-page-inner">
                    <div class="gallery-masonry" role="list">
                        @foreach($tailItems as $item)
                            <article class="gallery-masonry-card" role="listitem">
                                <a class="gallery-masonry-card-link" href="{{ route('gallery.show', $item->slug) }}">
                                    <div class="gallery-masonry-image">
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}"
                                            alt="{{ $item->localized('title') }}"
                                            loading="lazy"
                                        >
                                    </div>

                                    <div class="gallery-masonry-meta">
                                        <div class="gallery-masonry-title">“GALLERY”</div>

                                        @if(!empty($item->localized('short_description')))
                                            <div class="gallery-masonry-desc">
                                                {{ $item->localized('short_description') }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </section>

    <style>
        .gallery-section-page{
            background:#f7f5ef;
        }

        .gallery-section-hero{
            position:relative;
            background:#f7f5ef;
            overflow:visible;
            padding-top:28px;
        }

        .gallery-section-hero__top{
            position:relative;
            z-index:3;
            padding:0 20px;
        }

        .gallery-section-hero__inner{
            max-width:1240px;
            margin:0 auto;
            text-align:center;
        }

        .gallery-section-hero__title{
            margin:0;
            color:#cf9130;
            font-family:"Zen Old Mincho", serif;
            font-size:clamp(42px, 7vw, 86px);
            font-weight:400;
            line-height:1.08;
        }

        .gallery-section-hero__subtitle{
            margin:16px auto 0;
            max-width:760px;
            color:#2b241c;
            font-size:14px;
            line-height:1.6;
        }

        .gallery-section-hero__visual{
            position:relative;
            margin-top:26px;
            height:430px;
            overflow:visible;
        }

        .gallery-section-hero__bg{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            object-position:center;
            z-index:1;
        }

        .gallery-section-hero__shape{
            position:absolute;
            top:-1px;
            left:0;
            width:100%;
            height:118px;
            background:#f7f5ef;
            z-index:2;
            clip-path: polygon(
                0 0,
                100% 0,
                100% 26%,
                94% 20%,
                88% 34%,
                78% 44%,
                67% 40%,
                56% 42%,
                46% 30%,
                34% 22%,
                22% 26%,
                10% 18%,
                0 34%
            )
        }

        .gallery-section-hero__line{
            position:absolute;
            left:0;
            top:62px;
            width:100%;
            height:165px;
            z-index:4;
            pointer-events:none;
        }

        .gallery-section-hero__floating-image-wrap{
            position:absolute;
            right:10%;
            bottom:-58px;
            z-index:5;
        }

        .gallery-section-hero__floating-image-box{
            width:min(560px, 42vw);
            aspect-ratio: 560 / 230;
            overflow:hidden;
        }

        .gallery-section-hero__floating-image{
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            object-position:center;
        }

        .gallery-page{
            background:#f7f5ef;
            padding:110px 20px 70px;
        }

        .gallery-page-inner{
            max-width:1240px;
            margin:0 auto;
        }

        /* Keep bottom blocks same width as section content (override gallery.css) */
        .gallery-section-page .gallery-index-slider,
        .gallery-section-page .gallery-index-tail{
            padding-left:20px;
            padding-right:20px;
        }

        .gallery-section-page .gallery-index-slider-inner.gallery-page-inner,
        .gallery-section-page .gallery-index-tail-inner.gallery-page-inner{
            padding:0;
        }

        .gallery-section-page .gallery-masonry{
            grid-template-columns:repeat(2, minmax(0, 1fr));
            column-gap:34px;
            row-gap:38px;
        }

        .gallery-page-head{
            margin-bottom:44px;
        }

        .gallery-page-section-title{
            margin:0 0 22px;
            color:#cf9130;
            font-family:"Zen Old Mincho", serif;
            font-size:clamp(30px, 4vw, 56px);
            font-weight:400;
            line-height:1.08;
        }

        .gallery-page-toptexts{
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:44px;
        }

        .gallery-page-toptext{
            color:#2b241c;
            font-size:14px;
            line-height:1.7;
        }

        .gallery-page-grid{
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:38px 34px;
        }


        .gallery-page-card-link{
            display:block;
            text-decoration:none;
            color:inherit;
        }

        .gallery-page-image{
            width:100%;
            overflow:hidden;
            margin-bottom:14px;
            background:#eee7d7;
        }

        .gallery-page-image img{
            width:100%;
            height:auto;
            display:block;
            object-fit:cover;
            object-position:center;
        }

        .gallery-page-item-title{
            margin:0 0 8px;
            color:#cf9130;
            font-family:"Zen Old Mincho", serif;
            font-size:32px;
            line-height:1.08;
            font-weight:400;
        }

        .gallery-page-item-desc{
            color:#2b241c;
            font-size:13px;
            line-height:1.65;
        }

        @media (max-width:1200px){
            .gallery-section-hero__floating-image-wrap{
                right:6%;
            }

            .gallery-page-grid{
                gap:30px 24px;
            }
        }

        @media (max-width:991px){
            .gallery-section-hero__visual{
                height:330px;
            }

            .gallery-section-hero__shape{
                height:90px;
            }

            .gallery-section-hero__line{
                top:46px;
                height:120px;
            }

            .gallery-section-hero__floating-image-wrap{
                right:50%;
                transform:translateX(50%);
                bottom:-48px;
            }

            .gallery-section-hero__floating-image-box{
                width:min(620px, 90vw);
            }

            .gallery-page{
                padding-top:90px;
            }

            .gallery-page-toptexts{
                grid-template-columns:1fr;
                gap:18px;
            }

            .gallery-page-grid{
                grid-template-columns:1fr;
            }

            .gallery-section-page .gallery-masonry{
                grid-template-columns:1fr;
            }
        }

        @media (max-width:640px){
            .gallery-section-hero{
                padding-top:16px;
            }

            .gallery-section-hero__visual{
                height:250px;
            }

            .gallery-section-hero__shape{
                height:70px;
            }

            .gallery-section-hero__line{
                top:36px;
                height:90px;
            }

            .gallery-section-hero__floating-image-wrap{
                bottom:-34px;
            }

            .gallery-section-hero__floating-image-box{
                width:92vw;
                aspect-ratio:16 / 7;
            }

            .gallery-page{
                padding:74px 14px 44px;
            }

            .gallery-page-section-title{
                margin-bottom:16px;
            }

            .gallery-page-item-title{
                font-size:24px;
            }

            .gallery-page-item-desc{
                font-size:12px;
            }
        }
    </style>
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

            bindGalleryIndexSlider(@json($sectionsSliderId ?? 'gallery-section-sections-slider'));
        })();
    </script>
@endpush
