@extends('layouts.app')

@section('title', $exhibition->localized('title') ?? 'Exhibition')

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

        $img = !empty($exhibition->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($exhibition->image) : null;
        $items = collect($exhibition->items ?? []);
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

        @once
            <style>
                /* Center hero featured image + prevent overlap with next block */
                .gallery-hero-featured{
                    left:50%;
                    right:auto;
                    transform:translateX(-50%);
                    /* hang a bit lower so it never covers next title */
                    bottom:-140px;
                    /* wide horizontal block (not square) */
                    width:min(980px, calc(100% - 48px));
                    height:260px;
                }

                .gallery-hero-featured-link{
                    height:100%;
                }

                .gallery-hero-featured img{
                    width:100%;
                    height:100%;
                    object-fit:cover;
                    object-position:center;
                }

                .artwork{
                    /* hero featured image hangs below the hero */
                    padding-top:230px;
                }

                @media (max-width: 991px){
                    .gallery-hero-featured{ bottom:-110px; }
                    .artwork{ padding-top:210px; }
                }
            </style>
        @endonce
    @endif

    <section class="artwork" aria-label="Exhibition">
        <div class="artwork-inner">
{{--            <header class="artwork-hero">--}}
{{--                <div class="artwork-hero-left">--}}
{{--                    <h2 class="artwork-title">{{ $exhibition->localized('title') }}</h2>--}}

{{--                    @if(!empty($exhibition->localized('description')))--}}
{{--                        <div class="artwork-lead">--}}
{{--                            {!! nl2br(e((string) $exhibition->localized('description'))) !!}--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--                <div class="artwork-hero-right">--}}
{{--                    @if($img)--}}
{{--                        <div class="artwork-hero-image">--}}
{{--                            <img src="{{ $img }}" alt="{{ $exhibition->localized('title') }}" loading="lazy" />--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </header>--}}

            @if($items->count())
                <div class="exhibition-items" aria-label="Exhibition items">
                    @foreach($items as $it)
                        @php
                            $images = array_values(array_filter([
                                $it->image,
                                $it->secondary_image ?? null,
                                $it->third_image ?? null,
                                $it->fourth_image ?? null,
                            ]));

                            $imageUrls = array_map(
                                fn (string $p) => \Illuminate\Support\Facades\Storage::disk('public')->url($p),
                                $images
                            );

                            $title = $it->localized('title') ?? '';
                            $desc = $it->localized('description') ?? '';
                        @endphp

                        @if($imageUrls !== [] || trim((string) $title) !== '' || trim((string) $desc) !== '')
                            <article class="exhibition-item" aria-label="{{ $title ?: 'Exhibition item' }}">
                                <div class="exhibition-item__grid">
                                    <div class="exhibition-item__media">
                                        @if($imageUrls !== [])
                                            <div class="exhibition-collage">
                                                <div class="exhibition-collage__main">
                                                    <img src="{{ $imageUrls[0] }}" alt="{{ $title }}" loading="lazy" />
                                                </div>

                                                @if(count($imageUrls) > 1)
                                                    <div class="exhibition-collage__thumbs" aria-label="Additional images">
                                                        @foreach(array_slice($imageUrls, 1, 3) as $u)
                                                            <div class="exhibition-collage__thumb">
                                                                <img src="{{ $u }}" alt="{{ $title }}" loading="lazy" />
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="exhibition-item__text">
                                        @if(trim((string) $title) !== '')
                                            <div class="exhibition-item__title">“{{ strtoupper((string) $title) }}”</div>
                                        @endif

                                        @if(trim((string) $desc) !== '')
                                            <div class="exhibition-item__desc">
                                                {!! nl2br(e((string) $desc)) !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>

                @once
                    <style>
                        .exhibition-items{
                            margin-top:56px;
                            display:flex;
                            flex-direction:column;
                            gap:64px;
                        }

                        .exhibition-item__grid{
                            display:grid;
                            grid-template-columns: 1.15fr .85fr;
                            gap:64px;
                            align-items:start;
                        }

                        .exhibition-item__title{
                            font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                            color:var(--gallery-gold, #c88b2a);
                            font-size:clamp(28px, 3vw, 46px);
                            line-height:.95;
                            font-weight:500;
                            letter-spacing:.03em;
                            text-transform:uppercase;
                        }

                        .exhibition-item__desc{
                            margin-top:14px;
                            font-size:12px;
                            line-height:1.9;
                            color:#2f2f2f;
                            font-weight:300;
                            overflow-wrap:anywhere;
                            word-break:break-word;
                            hyphens:auto;
                        }

                        .exhibition-collage{
                            display:grid;
                            gap:18px;
                        }

                        .exhibition-collage__main{
                            width:100%;
                            overflow:hidden;
                            border: 1px solid rgba(20,20,20,.08);
                            background: rgba(255,255,255,.35);
                            aspect-ratio: 1026 / 746;
                        }

                        .exhibition-collage__thumbs{
                            display:grid;
                            grid-template-columns:repeat(4, minmax(0, 1fr));
                            gap:18px;
                        }

                        .exhibition-collage__thumb{
                            width:100%;
                            overflow:hidden;
                            border: 1px solid rgba(20,20,20,.08);
                            background: rgba(255,255,255,.35);
                            aspect-ratio: 1 / 1;
                        }

                        /* Figma-like bottom row: 1 normal, 2 wider, 3 normal */
                        .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(1){
                            grid-column: 1;
                        }
                        .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(2){
                            grid-column: 2 / span 2;
                            aspect-ratio: 2 / 1;
                        }
                        .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(3){
                            grid-column: 4;
                        }

                        .exhibition-collage img{
                            width:100%;
                            height:100%;
                            display:block;
                            object-fit:cover;
                            object-position:center;
                        }

                        @media (max-width: 991px){
                            .exhibition-item__grid{
                                grid-template-columns:1fr;
                                gap:28px;
                            }
                        }
                    </style>
                @endonce
            @endif
        </div>
    </section>
@endsection

