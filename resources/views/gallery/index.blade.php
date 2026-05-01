@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
    @php
        $heroTitle = $staticPage?->getBlock('hero')['title'] ?? 'Art Gallery';
        $heroSubtitle = $staticPage?->getBlock('hero')['subtitle'] ?? '';
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
                    @if(!empty($heroItem->slug))
                        <a href="{{ route('gallery.show', $heroItem->slug) }}" class="gallery-hero-featured-link">
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

@endsection
