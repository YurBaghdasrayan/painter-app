@extends('layouts.app')

@section('title', $section->localized('title') ?? 'Collection')

@section('content')
    @php
        $homePage = \App\Models\StaticPage::query()
            ->where('slug', 'home')
            ->where('is_active', true)
            ->first();

        $homeContent = $homePage?->localizedContent() ?? [];
        $homeCollection = $homeContent['collection_section'] ?? [];
        $homeCollectionTitle = $homeCollection['title'] ?? null;
        $homeCollectionLeftText = $homeCollection['left_text'] ?? null;
        $homeCollectionRightText = $homeCollection['right_text'] ?? null;
        $homeCollectionMoreText = $homeCollection['more_text'] ?? null;
        $homeCollectionMoreLink = $homeCollection['more_link'] ?? null;

        $collectionPage = \App\Models\StaticPage::query()
            ->where('slug', 'collection')
            ->where('is_active', true)
            ->first();

        $collectionContent = $collectionPage?->localizedContent() ?? [];
        $sectionHero = $collectionContent['section_hero'] ?? [];

        $sectionHeroTitle = $sectionHero['title'] ?? 'Collection';
        $sectionHeroSubtitle = $sectionHero['subtitle'] ?? '';
        $sectionHeroCardTitle = $sectionHero['card_title'] ?? null;
        $sectionHeroCardText = $sectionHero['card_text'] ?? null;

        $sectionHeroBg = $sectionHero['background_image'] ?? null;
        $sectionHeroMain = $sectionHero['main_image'] ?? null;

        if (is_array($sectionHeroBg)) {
            $sectionHeroBg = $sectionHeroBg[0] ?? null;
        }

        if (is_array($sectionHeroMain)) {
            $sectionHeroMain = $sectionHeroMain[0] ?? null;
        }

        $sectionHeroBgUrl = $sectionHeroBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($sectionHeroBg)
            : null;

        $sectionHeroMainUrl = $sectionHeroMain
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($sectionHeroMain)
            : null;

        $items = collect($section->items ?? []);
        $cardItems = $items
            ->filter(fn ($it) => !empty($it->image))
            ->values()
            ->values();
    @endphp

    <section class="collection-section-page-fixed">

        {{-- HERO (same as /collection index + show) --}}
        <section class="collection-hero-fixed" aria-label="Collection hero">
            <div class="collection-hero-fixed__inner">
                <h1 class="collection-hero-fixed__title">
                    {{ $sectionHeroTitle }}
                </h1>

                @if(!empty($sectionHeroSubtitle))
                    <p class="collection-hero-fixed__subtitle">
                        {{ $sectionHeroSubtitle }}
                    </p>
                @endif
            </div>

            <div class="collection-hero-fixed__art">
                <div class="collection-hero-fixed__bg">
                    @if($sectionHeroBgUrl)
                        <img src="{{ $sectionHeroBgUrl }}" alt="{{ $sectionHeroTitle }}">
                    @endif
                </div>

                <svg class="collection-hero-fixed__wave-top" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
                    <path
                        d="M0 68
                           C110 120 220 20 360 48
                           C520 80 640 20 790 54
                           C965 92 1090 72 1225 36
                           C1320 12 1385 22 1440 8
                           L1440 0
                           L0 0
                           Z"
                        fill="#f7f5ef"
                    />
                </svg>

                <svg class="collection-hero-fixed__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
                    <path
                        d="M0 104
                           C120 138 240 54 366 84
                           C520 120 660 88 798 106
                           C960 126 1084 92 1216 70
                           C1312 54 1382 72 1440 62"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>

                @if($sectionHeroMainUrl)
                    <div class="collection-hero-fixed__content-wrap">
                        <article class="collection-hero-fixed__featured">
                            <div class="collection-hero-fixed__image">
                                <img src="{{ $sectionHeroMainUrl }}" alt="{{ $sectionHeroTitle }}">
                            </div>
                        </article>

                        @if($sectionHeroCardTitle || $sectionHeroCardText)
                            <div class="collection-hero-fixed__text">
                                @if($sectionHeroCardTitle)
                                    <h2 class="collection-hero-fixed__card-title">
                                        “{{ strtoupper((string) $sectionHeroCardTitle) }}”
                                    </h2>
                                @endif

                                @if($sectionHeroCardText)
                                    <div class="collection-hero-fixed__card-copy">
                                        {!! $sectionHeroCardText !!}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        {{-- COLLECTION INTRO --}}
        <section class="collection-section-intro-fixed" aria-label="Collection intro">
            <div class="collection-section-intro-fixed__inner">
                <h2 class="collection-section-intro-fixed__title">
                    {{ $homeCollectionTitle ?: ($section->localized('title') ?? '') }}
                </h2>

                <div class="collection-section-intro-fixed__texts">
                    <div class="collection-section-intro-fixed__text collection-section-intro-fixed__text--left">
                        {!! nl2br(e((string) ($homeCollectionLeftText ?: ($section->localized('description') ?? '')))) !!}
                    </div>

                    <div class="collection-section-intro-fixed__text collection-section-intro-fixed__text--right">
                        {!! nl2br(e((string) ($homeCollectionRightText ?: ''))) !!}
                    </div>
                </div>
            </div>
        </section>

        {{-- CARDS --}}
        @if($cardItems->count())
            <section class="collection-section-cards-fixed" aria-label="Collection cards">
                <div class="collection-section-cards-fixed__inner">
                    <div class="gallery-section-grid" role="list">
                        @foreach($cardItems as $item)
                            <article class="gallery-section-card" role="listitem">
                                <a
                                    class="gallery-section-card-link"
                                    href="{{ route('collection.show', $item->slug) }}"
                                    aria-label="{{ $item->localized('title') }}"
                                >
                                    <div class="gallery-section-card-image">
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}"
                                            alt="{{ $item->localized('title') }}"
                                            loading="lazy"
                                        />
                                    </div>

                                    <div class="gallery-section-card-meta">
                                        <div class="gallery-section-card-title">
                                            “{{ strtoupper((string) ($item->localized('title') ?? '')) }}”
                                        </div>

                                        @php
                                            $desc = trim((string) ($item->localized('short_description') ?? ''));
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

                    <div class="gallery-footer">
                        <div class="gallery-more">
                            <span class="gallery-more-text">{{ $homeCollectionMoreText ?: 'more' }}</span>
                            <a class="gallery-more-btn" href="{{ $homeCollectionMoreLink ?: route('collection.index') }}" aria-label="More">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M5 12H18" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M13 7L18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </section>

    <style>
        .collection-section-page-fixed {
            background: #f7f5ef;
        }

        /* HERO (same styles as /collection index + show) */
        .collection-hero-fixed {
            background: #f7f5ef;
            position: relative;
            overflow: hidden;
            padding-top: 28px;
        }

        .collection-hero-fixed__inner {
            max-width: 980px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 3;
            padding: 0 20px;
        }

        .collection-hero-fixed__title {
            margin: 0;
            font-family: var(--serif, "Cormorant Garamond", "Times New Roman", serif);
            font-size: clamp(56px, 8vw, 110px);
            line-height: .92;
            font-weight: 500;
            color: #bf8730;
            letter-spacing: -.02em;
        }

        .collection-hero-fixed__subtitle {
            margin: 20px auto 0;
            max-width: 560px;
            font-size: 15px;
            line-height: 1.7;
            color: #5c5c5c;
            font-weight: 400;
        }

        .collection-hero-fixed__art {
            position: relative;
            margin-top: 34px;
            min-height: 760px;
        }

        .collection-hero-fixed__bg {
            position: relative;
            width: 100%;
            height: 310px;
            overflow: hidden;
            z-index: 1;
            opacity: .58;
        }

        .collection-hero-fixed__bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .collection-hero-fixed__wave-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 180px;
            z-index: 2;
            pointer-events: none;
        }

        .collection-hero-fixed__stroke {
            position: absolute;
            top: 92px;
            left: 0;
            width: 100%;
            height: 170px;
            z-index: 2;
            pointer-events: none;
        }

        .collection-hero-fixed__content-wrap {
            position: relative;
            z-index: 4;
            max-width: 1240px;
            margin: -68px auto 0;
            padding: 0 35px 70px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 58px;
            align-items: start;
        }

        .collection-hero-fixed__image {
            width: 100%;
            aspect-ratio: 560 / 235;
            overflow: hidden;
            background: #2b1b14;
        }

        .collection-hero-fixed__image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .collection-hero-fixed__text {
            padding-top: 86px;
            max-width: 520px;
        }

        .collection-hero-fixed__card-title {
            margin: 0 0 20px;
            font-family: var(--serif, "Cormorant Garamond", "Times New Roman", serif);
            font-size: clamp(34px, 4vw, 58px);
            line-height: .95;
            font-weight: 500;
            color: #bf8730;
            letter-spacing: .03em;
            text-transform: uppercase;
        }

        .collection-hero-fixed__card-copy {
            font-size: 14px;
            line-height: 1.9;
            color: #2f2f2f;
            font-weight: 400;
        }

        .collection-hero-fixed__card-copy p { margin: 0 0 14px; }
        .collection-hero-fixed__card-copy p:last-child { margin-bottom: 0; }

        @media (max-width: 991px) {
            .collection-hero-fixed { padding-top: 20px; }
            .collection-hero-fixed__art { min-height: auto; }
            .collection-hero-fixed__bg { height: 240px; }
            .collection-hero-fixed__stroke { top: 78px; height: 145px; }
            .collection-hero-fixed__content-wrap {
                margin-top: -42px;
                grid-template-columns: 1fr;
                gap: 28px;
                padding: 0 20px 50px;
            }
            .collection-hero-fixed__text { padding-top: 0; max-width: 100%; }
            .collection-hero-fixed__card-title { margin-bottom: 16px; }
        }

        @media (max-width: 640px) {
            .collection-hero-fixed__title { font-size: 54px; }
            .collection-hero-fixed__subtitle { font-size: 13px; line-height: 1.6; }
            .collection-hero-fixed__bg { height: 180px; }
            .collection-hero-fixed__wave-top { height: 130px; }
            .collection-hero-fixed__stroke { top: 52px; height: 120px; }
            .collection-hero-fixed__content-wrap { margin-top: -24px; padding: 0 16px 36px; }
            .collection-hero-fixed__image { aspect-ratio: 16 / 9; }
            .collection-hero-fixed__card-title { font-size: 34px; }
            .collection-hero-fixed__card-copy { font-size: 13px; line-height: 1.75; }
        }

        .collection-section-hero-fixed {
            position: relative;
            background: #f7f5ef;
            overflow: hidden;
            padding-top: 24px;
        }

        .collection-section-hero-fixed__top {
            position: relative;
            z-index: 3;
            padding: 0 20px;
        }

        .collection-section-hero-fixed__inner {
            max-width: 1240px;
            margin: 0 auto;
            text-align: center;
        }

        .collection-section-hero-fixed__title {
            margin: 0;
            color: #c89234;
            font-family: "Zen Old Mincho", serif;
            font-size: clamp(48px, 7vw, 88px);
            font-weight: 400;
            line-height: 1;
            letter-spacing: 0.01em;
        }

        .collection-section-hero-fixed__subtitle {
            margin: 18px auto 0;
            max-width: 620px;
            color: #48433d;
            font-size: 14px;
            line-height: 1.7;
            text-align: center;
        }

        .collection-section-hero-fixed__visual {
            position: relative;
            margin-top: 26px;
            min-height: 620px;
        }

        .collection-section-hero-fixed__bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 445px;
            display: block;
            object-fit: cover;
            object-position: center;
            opacity: .48;
            z-index: 1;
        }

        .collection-section-hero-fixed__shape {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px;
            z-index: 2;
            pointer-events: none;
        }

        .collection-section-hero-fixed__line {
            position: absolute;
            top: 78px;
            left: 0;
            width: 100%;
            height: 145px;
            z-index: 3;
            pointer-events: none;
        }

        .collection-section-hero-fixed__content-wrap {
            position: relative;
            z-index: 4;
            max-width: 1240px;
            margin: 88px auto 0;
            padding: 0 20px;
            display: flex;
            justify-content: flex-start;
        }

        .collection-section-hero-fixed__floating-card {
            width: min(680px, 100%);
            background: #f7f5ef;
            border: 1px solid rgba(20, 20, 20, 0.06);
        }

        .collection-section-hero-fixed__floating-image-box {
            width: 100%;
            aspect-ratio: 680 / 295;
            overflow: hidden;
            background: #ece5d8;
        }

        .collection-section-hero-fixed__floating-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            object-position: center;
        }

        .collection-section-hero-fixed__floating-meta {
            padding: 18px 18px 22px;
        }

        .collection-section-hero-fixed__floating-title {
            margin: 0;
            color: #c89234;
            font-family: "Zen Old Mincho", serif;
            font-size: 20px;
            line-height: 1.1;
            font-weight: 400;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .collection-section-hero-fixed__floating-text {
            margin-top: 12px;
            color: #3e3a35;
            font-size: 12px;
            line-height: 1.9;
            font-weight: 300;
        }

        .collection-section-intro-fixed {
            background: #f7f5ef;
            padding: 28px 20px 0;
        }

        .collection-section-intro-fixed__inner {
            max-width: 1240px;
            margin: 0 auto;
        }

        .collection-section-intro-fixed__title {
            margin: 0;
            color: #c89234;
            font-family: "Zen Old Mincho", serif;
            font-size: clamp(44px, 6vw, 74px);
            line-height: 1;
            font-weight: 400;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .collection-section-intro-fixed__texts {
            margin-top: 28px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 120px;
            align-items: start;
        }

        .collection-section-intro-fixed__text {
            color: #48433d;
            font-size: 15px;
            line-height: 1.8;
            max-width: 100%;
        }

        .collection-section-cards-fixed {
            background: #f7f5ef;
            padding: 48px 20px 72px;
        }

        .collection-section-cards-fixed__inner {
            max-width: 1240px;
            margin: 0 auto;
        }

        .collection-section-cards-fixed .gallery-section-grid {
            display: grid;
            grid-template-columns: 1.35fr .65fr;
            gap: 32px;
            align-items: start;
        }

        .collection-section-cards-fixed .gallery-section-card {
            background: transparent;
        }

        /* Big-left / small-right repeating pattern */
        .collection-section-cards-fixed .gallery-section-card:nth-child(odd){
            grid-column: 1;
        }
        .collection-section-cards-fixed .gallery-section-card:nth-child(even){
            grid-column: 2;
        }

        .collection-section-cards-fixed .gallery-section-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        .collection-section-cards-fixed .gallery-section-card-image {
            width: 100%;
            aspect-ratio: 1026 / 746;
            overflow: hidden;
            background: #ece5d8;
        }

        .collection-section-cards-fixed .gallery-section-card:nth-child(even) .gallery-section-card-image{
            aspect-ratio: 723 / 604;
        }

        .collection-section-cards-fixed .gallery-section-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .collection-section-cards-fixed .gallery-section-card-meta {
            padding-top: 18px;
        }

        .collection-section-cards-fixed .gallery-section-card-title {
            color: #c89234;
            font-family: "Zen Old Mincho", serif;
            font-size: 24px;
            line-height: 1.1;
            font-weight: 400;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .collection-section-cards-fixed .gallery-section-card-desc {
            margin-top: 12px;
            color: #48433d;
            font-size: 14px;
            line-height: 1.8;
        }

        .collection-section-cards-fixed .gallery-footer {
            margin-top: 34px;
        }

        @media (max-width: 1200px) {
            .collection-section-intro-fixed__texts {
                gap: 60px;
            }
        }

        @media (max-width: 991px) {
            .collection-section-hero-fixed__visual {
                min-height: 500px;
            }

            .collection-section-hero-fixed__bg {
                height: 360px;
            }

            .collection-section-hero-fixed__content-wrap {
                margin-top: 70px;
            }

            .collection-section-intro-fixed {
                padding-top: 18px;
            }

            .collection-section-intro-fixed__texts {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .collection-section-cards-fixed .gallery-section-grid {
                grid-template-columns: 1fr;
            }

            .collection-section-cards-fixed .gallery-section-card:nth-child(odd),
            .collection-section-cards-fixed .gallery-section-card:nth-child(even){
                grid-column: auto;
            }
        }

        @media (max-width: 640px) {
            .collection-section-hero-fixed {
                padding-top: 16px;
            }

            .collection-section-hero-fixed__title {
                font-size: 46px;
            }

            .collection-section-hero-fixed__subtitle {
                font-size: 13px;
                line-height: 1.6;
                margin-top: 14px;
            }

            .collection-section-hero-fixed__visual {
                min-height: 420px;
                margin-top: 20px;
            }

            .collection-section-hero-fixed__bg {
                height: 280px;
            }

            .collection-section-hero-fixed__shape {
                height: 82px;
            }

            .collection-section-hero-fixed__line {
                top: 44px;
                height: 95px;
            }

            .collection-section-hero-fixed__content-wrap {
                margin-top: 52px;
                padding: 0 14px;
            }

            .collection-section-hero-fixed__floating-meta {
                padding: 14px 14px 18px;
            }

            .collection-section-hero-fixed__floating-title {
                font-size: 16px;
            }

            .collection-section-hero-fixed__floating-text {
                font-size: 11px;
                line-height: 1.75;
            }

            .collection-section-intro-fixed {
                padding: 18px 14px 0;
            }

            .collection-section-intro-fixed__title {
                font-size: 42px;
            }

            .collection-section-intro-fixed__texts {
                margin-top: 20px;
            }

            .collection-section-intro-fixed__text {
                font-size: 14px;
                line-height: 1.7;
            }

            .collection-section-cards-fixed {
                padding: 34px 14px 44px;
            }

            .collection-section-cards-fixed .gallery-section-card-title {
                font-size: 20px;
            }

            .collection-section-cards-fixed .gallery-section-card-desc {
                font-size: 13px;
                line-height: 1.7;
            }
        }
    </style>

    @if(($sectionsForCards ?? collect())->count())
        <section class="gallery-index-slider" aria-label="All collection sections">
            <div class="gallery-index-slider-inner">
                <div class="gallery-index-slider-track" role="list">
                    @foreach($sectionsForCards as $s)
                        @php $coverItem = ($s->items ?? collect())->first(); @endphp
                        @if($coverItem && !empty($coverItem->image))
                            <article class="gallery-index-slider-card" role="listitem">
                                <a class="gallery-index-slider-card-link" href="{{ route('collection.section', $s) }}">
                                    <div class="gallery-index-slider-image">
                                        <img
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image) }}"
                                            alt="{{ $s->localized('title') }}"
                                            loading="lazy"
                                        >
                                    </div>
                                    <div class="gallery-index-slider-meta">
                                        <div class="gallery-index-slider-section-title">
                                            “{{ strtoupper((string) ($s->localized('title') ?? 'Collection')) }}”
                                        </div>
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
