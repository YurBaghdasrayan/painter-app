@extends('layouts.app')

@section('title', ($staticPage?->getBlock('hero')['title'] ?? 'Photos & Videos'))

@section('content')
    @php
        $hero = $staticPage?->getBlock('hero') ?? [];
        $heroTitle = $hero['title'] ?? 'Photos & Videos';
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBg = $hero['background_image'] ?? null;
        if (is_array($heroBg)) {
            $heroBg = $heroBg[0] ?? null;
        }
        $heroBgUrl = $heroBg ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBg) : null;

        $imagePath = is_array($item) ? ($item['image'] ?? null) : null;
        $imageUrl = $imagePath ? \Illuminate\Support\Facades\Storage::disk('public')->url($imagePath) : null;

        $locale = app()->getLocale();
        if ($locale === 'hy') $locale = 'am';
        $descKey = 'description_' . $locale;
        $desc = is_array($item) ? ($item[$descKey] ?? ($item['description_en'] ?? '')) : '';
        if (!is_string($desc) || trim($desc) === '') {
            $textKey = 'text_' . $locale;
            $desc = is_array($item) ? ($item[$textKey] ?? ($item['text_en'] ?? '')) : '';
        }
    @endphp

    <section class="gallery-hero" aria-label="Photos & Videos hero">
        <div class="gallery-hero-inner">
            @if($heroTitle)
                <h1 class="gallery-hero-title">{{ $heroTitle }}</h1>
            @endif

            @if($heroSubtitle)
                <p class="gallery-hero-subtitle">{{ $heroSubtitle }}</p>
            @endif
        </div>

        <div class="gallery-hero-art">
            <div class="gallery-hero-art-bg">
                @if($heroBgUrl)
                    <img src="{{ $heroBgUrl }}" alt="{{ $heroTitle }}">
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
        </div>
    </section>

    <section class="artwork" aria-label="Photo / Video">
        <div class="artwork-inner">
            @if($imageUrl)
                <div class="pv-show-image">
                    <img src="{{ $imageUrl }}" alt="" loading="lazy" />
                </div>
            @endif

            @if(trim((string) $desc) !== '')
                <div class="pv-show-desc">
                    {!! $desc !!}
                </div>
            @endif
        </div>
    </section>

    @once
        <style>
            .pv-show-image{
                width:100%;
                overflow:hidden;
                border: 1px solid rgba(20,20,20,.08);
                background: rgba(255,255,255,.35);
                aspect-ratio: 1026 / 746;
            }
            .pv-show-image img{
                width:100%;
                height:100%;
                display:block;
                object-fit:cover;
                object-position:center;
            }
            .pv-show-desc{
                margin-top:24px;
                font-size:12px;
                line-height:1.9;
                color:var(--gallery-text, #2a2a2a);
                font-weight:300;
            }
        </style>
    @endonce
@endsection

