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
                <img
                    src="{{ $heroBgUrl }}"
                    alt="{{ $heroTitle }}"
                >
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
                            <img
                                src="{{ $featuredImgUrl }}"
                                alt="{{ $featuredAlt }}"
                            >
                        </a>
                    @else
                        <div class="gallery-hero-featured-link">
                            <img
                                src="{{ $featuredImgUrl }}"
                                alt="{{ $featuredAlt }}"
                            >
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
                            $desc = trim((string) ($item->localized('full_description') ?? $item->localized('short_description') ?? ''));
                        @endphp

                        @if($img && !empty($item->slug))
                            <article class="gallery-section-card" role="listitem">
                                <a class="gallery-section-card-link" href="{{ route('gallery.show', $item->slug) }}" aria-label="{{ $title }}">
                                    <div class="gallery-section-card-image">
                                        <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" />
                                    </div>

                                    <div class="gallery-section-card-meta">
                                        <div class="gallery-section-card-title">
                                            “{{ strtoupper((string) $title) }}”
                                        </div>

                                        @if($desc !== '')
                                            <div class="gallery-section-card-desc">
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
        </section>
    @endif
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
                display: grid !important;
                grid-template-columns: 1fr !important;
                gap: 56px !important;
            }

            .gallery-section-card,
            .gallery-section-card-link,
            .gallery-section-card-image {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
            }

            .gallery-section-card-image img {
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                display: block !important;
                object-fit: cover !important;
            }

            .gallery-section-card-title,
            .gallery-section-card-desc {
                max-width: 100% !important;
                overflow-wrap: break-word !important;
            }
        }

        @media (max-width: 768px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }

            .gallery-section-grid {
                grid-template-columns: 1fr !important;
                gap: 44px !important;
            }
        }

        @media (max-width: 480px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }

            .gallery-section-grid {
                grid-template-columns: 1fr !important;
                gap: 36px !important;
            }
        }

        @media (max-width: 390px) {
            .gallery-inner,
            .gallery-hero-inner {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            .gallery-section-grid {
                gap: 30px !important;
            }
        }
    </style>@endsection



