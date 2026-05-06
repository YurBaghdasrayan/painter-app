@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    @php
        $heroBlock = $staticPage?->getBlock('hero') ?? [];
        $heroTitle = $heroBlock['title'] ?? 'Art Gallery';
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

            @if(!empty($heroSubtitle))
                <p class="gallery-hero-subtitle">
                    {{ $heroSubtitle }}
                </p>
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
                        $featuredImgUrl = $heroMainUrl ?: \Illuminate\Support\Facades\Storage::disk('public')->url($heroItem->image);
                        $featuredAlt = $heroTitle ?: ($heroItem?->localized('title') ?? 'Gallery');
                    @endphp

                    @if($heroItem && !empty($heroItem->slug))
                        <a href="{{ route('gallery.show', $heroItem->slug) }}" class="gallery-hero-featured-link">
                            <img src="{{ $featuredImgUrl }}" alt="{{ $featuredAlt }}">
                        </a>
                    @else
                        <div class="gallery-hero-featured-link">
                            <img src="{{ $featuredImgUrl }}" alt="{{ $featuredAlt }}">
                        </div>
                    @endif
                </article>
            @endif
        </div>
    </section>

    @if(($items ?? collect())->count())
        <section class="gallery-index" aria-label="Gallery index">
            <div class="gallery-inner">
                <div class="gallery-section-grid" role="list">
                    @foreach(($items ?? collect()) as $item)
                        @php
                            $img = !empty($item->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) : null;
                            $title = $item->localized('title') ?? 'Gallery';
                            $desc = trim((string) ($item->localized('short_description') ?? ''));
                        @endphp

                        @if($img && !empty($item->slug))
                            <article class="gallery-section-card" role="listitem">
                                <a class="gallery-section-card-image" href="{{ route('gallery.show', $item->slug) }}" aria-label="{{ $title }}">
                                    <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" />
                                </a>

                                <div class="gallery-section-card-meta">
                                    <a class="gallery-section-card-title" href="{{ route('gallery.show', $item->slug) }}">
                                        “{{ strtoupper((string) $title) }}”
                                    </a>

                                    @if($desc !== '')
                                        <div class="gallery-section-card-desc js-gallery-desc">
                                            {{ $desc }}
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
                        @endif
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
        });
    </script>

    <style>
        @media (max-width: 1024px) {
            .gallery-inner,
            .gallery-hero-inner {
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 24px !important;
                padding-right: 24px !important;
                box-sizing: border-box !important;
            }

            .gallery-section-grid {
                display: flex !important;
                flex-direction: column !important;
                width: 100% !important;
                gap: 34px !important;
            }

            .gallery-section-card {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                float: none !important;
                clear: both !important;
            }

            .gallery-section-card-link,
            .gallery-section-card-image,
            .gallery-section-card-meta {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            .gallery-section-card-link {
                text-decoration: none !important;
            }

            .gallery-section-card-image {
                margin-bottom: 14px !important;
            }

            .gallery-section-card-image img {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                object-fit: contain !important;
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
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                font-size: 14px !important;
                line-height: 1.6 !important;
                max-height: 90px !important;
                overflow: hidden !important;
                overflow-wrap: break-word !important;
                word-break: normal !important;
                transition: max-height .25s ease !important;
            }

            .gallery-section-card-desc.is-expanded {
                max-height: 2000px !important;
            }

            .gallery-more-btn {
                display: inline-block !important;
                margin-top: 8px !important;
                padding: 0 !important;
                border: 0 !important;
                background: transparent !important;
                color: #b77b2b !important;
                font-size: 14px !important;
                font-weight: 600 !important;
                line-height: 1.2 !important;
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

            .gallery-section-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 30px !important;
            }

            .gallery-section-card {
                width: 100% !important;
                max-width: 100% !important;
            }

            .gallery-section-card-title {
                font-size: 18px !important;
            }

            .gallery-section-card-desc {
                font-size: 13.5px !important;
                max-height: 84px !important;
            }
        }

        @media (max-width: 480px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }

            .gallery-section-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 28px !important;
            }

            .gallery-section-card,
            .gallery-section-card-link,
            .gallery-section-card-image,
            .gallery-section-card-meta {
                width: 100% !important;
                max-width: 100% !important;
            }

            .gallery-section-card-title {
                font-size: 17px !important;
                line-height: 1.3 !important;
            }

            .gallery-section-card-desc {
                font-size: 13px !important;
                line-height: 1.55 !important;
                max-height: 80px !important;
            }
        }

        @media (max-width: 390px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .gallery-section-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 26px !important;
            }

            .gallery-section-card-title {
                font-size: 16px !important;
            }

            .gallery-section-card-desc {
                font-size: 12.5px !important;
                max-height: 76px !important;
            }
        }
    </style>@endsection
