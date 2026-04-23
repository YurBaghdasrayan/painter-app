@extends('layouts.app')

@section('title', 'Exhibitions')

@section('content')
    @php
        $hero = $staticPage?->getBlock('hero') ?? [];
        $heroTitle = $hero['title'] ?? 'Exhibitions';
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBg = $hero['background_image'] ?? null;
        $heroMain = $hero['main_image'] ?? null;

        if (is_array($heroBg)) {
            $heroBg = $heroBg[0] ?? null;
        }
        if (is_array($heroMain)) {
            $heroMain = $heroMain[0] ?? null;
        }

        $heroBgUrl = $heroBg ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBg) : null;
        $heroMainUrl = $heroMain ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMain) : null;

        $textBlock = $staticPage?->getBlock('text_block') ?? [];
        $textLeftTitle = $textBlock['left_title'] ?? null;
        $textLeft = $textBlock['left_text'] ?? null;
        $textRightTitle = $textBlock['right_title'] ?? null;
        $textRight = $textBlock['right_text'] ?? null;
    @endphp

    @if($heroTitle || $heroSubtitle || $heroBgUrl || $heroMainUrl)
        <section class="gallery-hero" aria-label="Exhibitions hero">
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

                @if($heroMainUrl)
                    <article class="gallery-hero-featured">
                        <div class="gallery-hero-featured-link">
                            <img src="{{ $heroMainUrl }}" alt="{{ $heroTitle }}">
                        </div>
                    </article>
                @endif
            </div>
        </section>
    @endif

    @if($textLeftTitle || $textLeft || $textRightTitle || $textRight)
        <section class="exhibitions-text" aria-label="Exhibitions text">
            <div class="exhibitions-text__inner">
                <div class="exhibitions-text__grid">
                    <div class="exhibitions-text__col">
                        @if($textLeftTitle)
                            <div class="exhibitions-text__title">“{{ strtoupper((string) $textLeftTitle) }}”</div>
                        @endif
                        @if($textLeft)
                            <div class="exhibitions-text__text">
                                {!! nl2br(e((string) $textLeft)) !!}
                            </div>
                        @endif
                    </div>

                    <div class="exhibitions-text__col">
                        @if($textRightTitle)
                            <div class="exhibitions-text__title">“{{ strtoupper((string) $textRightTitle) }}”</div>
                        @endif
                        @if($textRight)
                            <div class="exhibitions-text__text">
                                {!! nl2br(e((string) $textRight)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="gallery-index" aria-label="Exhibitions index">
        <div class="gallery-inner">
            @if(($exhibitions ?? collect())->count())
                <div class="gallery-head">
                    <h2 class="gallery-title">EXHIBITIONS</h2>
                </div>

                <div class="exhibitions-cards" role="list">
                    @foreach($exhibitions as $ex)
                        @php
                            $img = !empty($ex->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($ex->image) : null;
                        @endphp
                        <article class="gallery-section-card" role="listitem">
                            <a class="gallery-section-card-link" href="{{ route('exhibitions.show', $ex) }}" aria-label="{{ $ex->localized('title') }}">
                                @if($img)
                                    <div class="gallery-section-card-image">
                                        <img src="{{ $img }}" alt="{{ $ex->localized('title') }}" loading="lazy" />
                                    </div>
                                @endif

                                <div class="gallery-section-card-meta">
                                    <div class="gallery-section-card-title">
                                        “{{ strtoupper((string) ($ex->localized('title') ?? 'Exhibitions')) }}”
                                    </div>

                                    @php
                                        $desc = trim((string) ($ex->localized('description') ?? ''));
                                    @endphp

                                    @if($desc !== '')
                                        <div class="gallery-section-card-desc">
                                            {{ $desc }}
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

    @once
        <style>
            /* Page padding (less space from sides) */
            .gallery-index .gallery-inner{
                padding-left:70px;
                padding-right:70px;
            }

            /* Hero featured image: centered + wide horizontal block */
            .gallery-hero-featured{
                left:50%;
                right:auto;
                transform:translateX(-50%);
                width:min(980px, calc(100% - 48px));
                height:260px;
            }

            .gallery-hero-featured img{
                width:100%;
                height:100%;
                object-fit:cover;
                object-position:center;
            }

            /* Exhibitions cards layout (Figma-like blocks) */
            .exhibitions-cards{
                margin-top:54px;
                display:grid;
                /* 3 cards per row: 1 + 1 + (span 2) */
                grid-template-columns:repeat(4, minmax(0, 1fr));
                gap:44px 34px;
                align-items:start;
                grid-auto-flow:dense;
            }

            .exhibitions-cards .gallery-section-card{
                grid-column:auto;
                grid-row:auto;
            }

            .exhibitions-cards .gallery-section-card-image{
                background:#eee7d7;
            }

            .exhibitions-cards .gallery-section-card-image img{
                width:100%;
                height:100%;
                display:block;
                object-fit:cover;
                object-position:center;
            }

            /* Prevent long titles/descriptions from breaking the grid */
            .exhibitions-cards .gallery-section-card-meta{
                max-width:100%;
                min-width:0;
            }

            .exhibitions-cards .gallery-section-card-title,
            .exhibitions-cards .gallery-section-card-desc{
                overflow-wrap:anywhere;
                word-break:break-word;
                hyphens:auto;
            }

            .exhibitions-cards .gallery-section-card-desc{
                display:-webkit-box;
                -webkit-box-orient:vertical;
                -webkit-line-clamp:4;
                overflow:hidden;
            }

            /*
             Base pattern (all rows): small, small, wide-right (3rd only).
             Uses a 4-col grid: [1] [2] [3-4 wide]
            */
            .exhibitions-cards .gallery-section-card:nth-child(3n+1){
                grid-column: 1;
            }
            .exhibitions-cards .gallery-section-card:nth-child(3n+2){
                grid-column: 2;
            }
            .exhibitions-cards .gallery-section-card:nth-child(3n){
                grid-column: 3 / span 2;
            }

            .exhibitions-cards .gallery-section-card:nth-child(3n+1) .gallery-section-card-image,
            .exhibitions-cards .gallery-section-card:nth-child(3n+2) .gallery-section-card-image{
                aspect-ratio: 360 / 520;
            }

            .exhibitions-cards .gallery-section-card:nth-child(3n) .gallery-section-card-image{
                aspect-ratio: 780 / 520;
            }

            /* Desktop-only per-row overrides (so tablet/mobile keep simpler layout) */
            @media (min-width: 1201px){
                /* ONLY 2nd row (cards 4-6): wide-left + 2 small */
                .exhibitions-cards .gallery-section-card:nth-child(4){
                    grid-column: 1 / span 2;
                }
                .exhibitions-cards .gallery-section-card:nth-child(5){
                    grid-column: 3;
                }
                .exhibitions-cards .gallery-section-card:nth-child(6){
                    grid-column: 4;
                }

                .exhibitions-cards .gallery-section-card:nth-child(4) .gallery-section-card-image{
                    aspect-ratio: 780 / 520;
                }
                .exhibitions-cards .gallery-section-card:nth-child(5) .gallery-section-card-image,
                .exhibitions-cards .gallery-section-card:nth-child(6) .gallery-section-card-image{
                    aspect-ratio: 360 / 520;
                }

                /* ONLY 3rd row (cards 7-9): center (8th) wider, others normal */
                .exhibitions-cards .gallery-section-card:nth-child(8){
                    grid-column: 2 / span 2;
                }
                .exhibitions-cards .gallery-section-card:nth-child(9){
                    grid-column: 4;
                }

                .exhibitions-cards .gallery-section-card:nth-child(8) .gallery-section-card-image{
                    aspect-ratio: 780 / 520;
                }
                .exhibitions-cards .gallery-section-card:nth-child(9) .gallery-section-card-image{
                    aspect-ratio: 360 / 520;
                }
            }

            @media (max-width: 1200px){
                .gallery-index .gallery-inner{
                    padding-left:18px;
                    padding-right:18px;
                }

                .exhibitions-cards{
                    grid-template-columns:repeat(2, minmax(0, 1fr));
                    gap:34px 24px;
                }

                .exhibitions-cards .gallery-section-card:nth-child(3n),
                .exhibitions-cards .gallery-section-card:nth-child(4){
                    grid-column:1 / -1;
                }
            }

            @media (max-width: 640px){
                .exhibitions-cards{
                    grid-template-columns:1fr;
                }

                .exhibitions-cards .gallery-section-card:nth-child(3n),
                .exhibitions-cards .gallery-section-card:nth-child(4){
                    grid-column:auto;
                }
            }

            .exhibitions-text{
                background:#f7f5ef;
                /* push down so hero featured image doesn't overlap */
                padding:160px 20px 74px;
            }

            .exhibitions-text__inner{
                max-width:1240px;
                margin:0 auto;
            }

            .exhibitions-text__grid{
                display:grid;
                grid-template-columns:repeat(2, minmax(0, 1fr));
                gap:44px;
                align-items:start;
            }

            .exhibitions-text__title{
                font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                color:var(--gallery-gold, #c88b2a);
                font-size:clamp(34px, 4vw, 58px);
                line-height:.95;
                font-weight:500;
                letter-spacing:.03em;
                text-transform:uppercase;
            }

            .exhibitions-text__text{
                margin-top:14px;
                font-size:12px;
                line-height:1.9;
                color:#2f2f2f;
                font-weight:400;
            }

            @media (max-width: 991px){
                .exhibitions-text__grid{
                    grid-template-columns:1fr;
                    gap:22px;
                }
            }
        </style>
    @endonce
@endsection

