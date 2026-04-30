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

        $staticDisk = env('FILESYSTEM_DISK', 'public');
        $heroBgUrl = $heroBg ? \Illuminate\Support\Facades\Storage::disk($staticDisk)->url($heroBg) : null;
        $heroMainUrl = $heroMain ? \Illuminate\Support\Facades\Storage::disk($staticDisk)->url($heroMain) : null;

        $items = collect($exhibition->items ?? []);
    @endphp

    @if($heroTitle || $heroSubtitle || $heroBgUrl || $heroMainUrl)
        <section class="articles-hero-page" aria-label="Exhibitions hero">
            <div class="articles-hero-page__top">
                <div class="articles-hero-page__inner">
                    <h1 class="articles-hero-page__title">{{ $heroTitle }}</h1>

                    @if(!empty($heroSubtitle))
                        <p class="articles-hero-page__subtitle">
                            {{ $heroSubtitle }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="articles-hero-page__visual">
                @if($heroBgUrl)
                    <img
                        src="{{ $heroBgUrl }}"
                        alt="{{ $heroTitle }}"
                        class="articles-hero-page__bg"
                    >
                @endif

                <div class="articles-hero-page__shape"></div>

                <svg class="articles-hero-page__line" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

                <div class="articles-hero-page__inner articles-hero-page__image-wrap">
                    @if($heroMainUrl)
                        <div class="articles-hero-page__main-image-box">
                            <img
                                src="{{ $heroMainUrl }}"
                                alt="{{ $heroTitle }}"
                                class="articles-hero-page__main-image"
                            >
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <section class="artwork" aria-label="Exhibition">
        <div class="artwork-inner">
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
            @endif
        </div>
    </section>

    @if(($relatedExhibitions ?? collect())->count())
        <section class="related related--exhibitions" aria-label="Related exhibitions">
            <div class="related-head">
                <h2 class="related-title">FROM THE SAME LINE</h2>
            </div>

            <div class="related-rail">
                <div class="related-grid related-grid--scroll" role="list" aria-label="Exhibitions">
                    @foreach($relatedExhibitions as $rel)
                        @php
                            $relImg = !empty($rel->image)
                                ? \Illuminate\Support\Facades\Storage::disk('public')->url($rel->image)
                                : null;
                        @endphp

                        @if($relImg)
                            <article class="related-card" role="listitem">
                                <a class="related-link" href="{{ route('exhibitions.show', $rel) }}" aria-label="{{ $rel->localized('title') }}">
                                    <div class="related-image">
                                        <img src="{{ $relImg }}" alt="{{ $rel->localized('title') }}" loading="lazy" />
                                    </div>

                                    <div class="related-meta">
                                        <div class="related-item-title">“{{ strtoupper((string) ($rel->localized('title') ?? '')) }}”</div>
                                    </div>
                                </a>
                            </article>
                        @endif
                    @endforeach
                </div>

                <button class="related-next" type="button" aria-label="Next">→</button>
            </div>
        </section>
    @endif

    @once
        <style>
            html,
            body{
                overflow-x:hidden;
            }

            .gallery-hero-featured{
                left:50%;
                right:auto;
                transform:translateX(-50%);
                bottom:-140px;
                width:min(980px, calc(100% - 48px));
                height:260px;
                box-shadow:0 18px 50px rgba(0,0,0,.12);
                overflow:hidden;
                z-index:4;
            }

            .gallery-hero-featured-link{
                display:block;
                height:100%;
            }

            .gallery-hero-featured img{
                width:100%;
                height:100%;
                object-fit:cover;
                object-position:center;
            }

            .artwork{
                padding-top:230px;
                overflow:hidden;
            }

            .artwork-inner,
            .exhibition-items,
            .exhibition-item,
            .exhibition-item__grid,
            .exhibition-item__media,
            .exhibition-collage{
                max-width:100%;
                min-width:0;
            }

            .exhibition-items{
                margin-top:56px;
                display:flex;
                flex-direction:column;
                gap:64px;
            }

            .exhibition-item__grid{
                display:grid;
                grid-template-columns:1.15fr .85fr;
                gap:64px;
                align-items:start;
            }

            .exhibition-item__text{
                min-width:0;
            }

            .exhibition-item__title{
                font-family:var(--gallery-serif, "Cormorant Garamond", "Times New Roman", serif);
                color:var(--gallery-gold, #c88b2a);
                font-size:clamp(28px, 3vw, 46px);
                line-height:.95;
                font-weight:500;
                letter-spacing:.03em;
                text-transform:uppercase;
                overflow-wrap:anywhere;
                word-break:break-word;
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
                width:100%;
                display:grid;
                gap:18px;
                overflow:hidden;
            }

            .exhibition-collage__main{
                width:100%;
                max-width:100%;
                overflow:hidden;
                border:1px solid rgba(20,20,20,.08);
                background:rgba(255,255,255,.35);
                aspect-ratio:1026 / 746;
            }

            .exhibition-collage__thumbs{
                width:100%;
                max-width:100%;
                display:grid;
                grid-template-columns:repeat(3, minmax(0, 1fr));
                gap:18px;
                overflow:hidden;
            }

            .exhibition-collage__thumb{
                width:100%;
                min-width:0;
                overflow:hidden;
                border:1px solid rgba(20,20,20,.08);
                background:rgba(255,255,255,.35);
                aspect-ratio:1 / 1;
            }

            .exhibition-collage__main img,
            .exhibition-collage__thumb img{
                width:100%;
                height:100%;
                display:block;
                object-fit:cover;
                object-position:center;
            }

            .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(1),
            .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(2),
            .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(3){
                grid-column:auto;
                aspect-ratio:1 / 1;
            }

            @media (min-width:992px){
                .exhibition-collage__thumbs{
                    grid-template-columns:repeat(4, minmax(0, 1fr));
                }

                .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(1){
                    grid-column:1;
                }

                .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(2){
                    grid-column:2 / span 2;
                    aspect-ratio:2 / 1;
                }

                .exhibition-collage__thumbs .exhibition-collage__thumb:nth-child(3){
                    grid-column:4;
                }
            }

            .related--exhibitions{
                position:relative;
                overflow:hidden;
            }

            .related--exhibitions .related-rail{
                position:relative;
                max-width:1440px;
                margin:0 auto;
                padding:0 70px;
                overflow:hidden;
            }

            .related--exhibitions .related-grid--scroll{
                display:flex !important;
                grid-template-columns:none !important;
                gap:18px;
                overflow-x:auto;
                overflow-y:hidden;
                scroll-behavior:smooth;
                scroll-snap-type:x mandatory;
                -webkit-overflow-scrolling:touch;
                padding-bottom:8px;
            }

            .related--exhibitions .related-grid--scroll::-webkit-scrollbar{
                display:none;
            }

            .related--exhibitions .related-card{
                flex:0 0 320px;
                width:320px;
                min-width:320px;
                scroll-snap-align:start;
            }

            .related--exhibitions .related-link{
                display:block;
                height:100%;
            }

            .related--exhibitions .related-image{
                width:100%;
                aspect-ratio:360 / 520;
                overflow:hidden;
                background:#eee7d7;
            }

            .related--exhibitions .related-image img{
                width:100%;
                height:100%;
                display:block;
                object-fit:cover;
                object-position:center;
            }

            .related--exhibitions .related-next{
                position:absolute;
                right:22px;
                top:45%;
                transform:translateY(-50%);
                width:44px;
                height:44px;
                border-radius:50%;
                border:0;
                background:var(--gold, #c88b2a);
                color:#fff;
                font-size:24px;
                line-height:1;
                cursor:pointer;
                z-index:5;
                display:flex;
                align-items:center;
                justify-content:center;
                box-shadow:0 10px 24px rgba(0,0,0,.18);
            }

            .related--exhibitions .related-next:hover{
                opacity:.92;
            }

            @media (max-width:1700px){
                .gallery-hero-title{
                    font-size:82px;
                }
            }

            @media (max-width:1600px){
                .gallery-hero-title{
                    font-size:76px;
                }

                .gallery-hero-featured{
                    width:min(920px, calc(100% - 60px));
                    height:240px;
                }
            }

            @media (max-width:1440px){
                .gallery-hero-title{
                    font-size:68px;
                }

                .related--exhibitions .related-rail{
                    padding-left:36px;
                    padding-right:36px;
                }
            }

            @media (max-width:1366px){
                .gallery-hero-title{
                    font-size:62px;
                }

                .gallery-hero-featured{
                    width:min(860px, calc(100% - 44px));
                    height:220px;
                }
            }

            @media (max-width:1280px){
                .gallery-hero-title{
                    font-size:58px;
                }

                .gallery-hero-subtitle{
                    max-width:680px;
                }

                .related--exhibitions .related-card{
                    flex-basis:290px;
                    width:290px;
                    min-width:290px;
                }
            }

            @media (max-width:1024px){
                .gallery-hero-inner{
                    padding-top:52px;
                }

                .gallery-hero-title{
                    font-size:50px;
                }

                .gallery-hero-featured{
                    width:min(760px, calc(100% - 36px));
                    height:190px;
                    bottom:-92px;
                }

                .artwork{
                    padding-top:210px;
                }

                .exhibition-item__grid{
                    gap:38px;
                }
            }

            @media (max-width:991px){
                .gallery-hero-title{
                    font-size:44px;
                }

                .gallery-hero-subtitle{
                    font-size:12px;
                }

                .gallery-hero-featured{
                    bottom:-110px;
                }

                .artwork{
                    padding-top:210px;
                }

                .exhibition-item__grid{
                    grid-template-columns:1fr;
                    gap:28px;
                }

                .exhibition-collage__thumbs{
                    grid-template-columns:repeat(3, minmax(0, 1fr));
                    gap:14px;
                }

                .related--exhibitions .related-rail{
                    padding-left:18px;
                    padding-right:18px;
                }
            }

            @media (max-width:768px){
                .gallery-hero-inner{
                    padding:44px 16px 24px;
                }

                .gallery-hero-title{
                    font-size:36px;
                    line-height:1.05;
                }

                .gallery-hero-subtitle{
                    max-width:100%;
                    font-size:12px;
                    line-height:1.65;
                }

                .gallery-hero-art{
                    min-height:300px;
                }

                .gallery-hero-featured{
                    width:calc(100% - 24px);
                    height:168px;
                    bottom:-82px;
                }

                .gallery-hero-wave,
                .gallery-hero-stroke{
                    height:92px;
                }

                .artwork{
                    padding-top:170px;
                }

                .exhibition-items{
                    gap:46px;
                }

                .exhibition-collage{
                    gap:12px;
                }

                .exhibition-collage__thumbs{
                    gap:10px;
                }

                .related--exhibitions .related-card{
                    flex-basis:250px;
                    width:250px;
                    min-width:250px;
                }

                .related--exhibitions .related-next{
                    width:40px;
                    height:40px;
                    right:12px;
                }
            }

            @media (max-width:576px){
                .artwork-inner{
                    padding-left:14px;
                    padding-right:14px;
                }

                .gallery-hero-title{
                    font-size:30px;
                }

                .gallery-hero-featured{
                    height:148px;
                    bottom:-72px;
                }

                .artwork{
                    padding-top:150px;
                }

                .exhibition-collage__main{
                    aspect-ratio:4 / 3;
                }

                .exhibition-collage__thumbs{
                    grid-template-columns:repeat(3, minmax(0, 1fr));
                    gap:10px;
                }

                .exhibition-item__title{
                    font-size:28px;
                    line-height:1.05;
                }

                .exhibition-item__desc{
                    font-size:12px;
                    line-height:1.8;
                }

                .related--exhibitions .related-card{
                    flex-basis:220px;
                    width:220px;
                    min-width:220px;
                }
            }

            @media (max-width:430px){
                .artwork-inner{
                    padding-left:12px;
                    padding-right:12px;
                }

                .gallery-hero-title{
                    font-size:27px;
                }

                .gallery-hero-subtitle{
                    font-size:11px;
                }

                .gallery-hero-featured{
                    height:136px;
                }

                .exhibition-collage__thumbs{
                    gap:8px;
                }

                .exhibition-item__title{
                    font-size:25px;
                }

                .related--exhibitions .related-card{
                    flex-basis:205px;
                    width:205px;
                    min-width:205px;
                }
            }

            @media (max-width:390px){
                .gallery-hero-title{
                    font-size:25px;
                }

                .gallery-hero-featured{
                    height:126px;
                }

                .related--exhibitions .related-card{
                    flex-basis:195px;
                    width:195px;
                    min-width:195px;
                }
            }

            @media (max-width:360px){
                .gallery-hero-title{
                    font-size:23px;
                }

                .gallery-hero-featured{
                    height:116px;
                }

                .exhibition-collage__thumbs{
                    grid-template-columns:repeat(2, minmax(0, 1fr));
                }

                .exhibition-item__title{
                    font-size:23px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const rail = document.querySelector('.related--exhibitions .related-grid--scroll');
                const btn = document.querySelector('.related--exhibitions .related-next');

                if (!rail || !btn) return;

                btn.addEventListener('click', function () {
                    const card = rail.querySelector('.related-card');
                    const gap = 18;
                    const step = card ? card.getBoundingClientRect().width + gap : 320;

                    if (rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 5) {
                        rail.scrollTo({ left: 0, behavior: 'smooth' });
                        return;
                    }

                    rail.scrollBy({ left: step, behavior: 'smooth' });
                });
            });
        </script>
    @endonce
@endsection
