@extends('layouts.app')

@section('title', $item->localized('title') ?? 'Collection item')

@section('content')
    @php
        $collectionPage = \App\Models\StaticPage::query()
            ->where('slug', 'collection')
            ->where('is_active', true)
            ->first();

        $collectionContent = $collectionPage?->localizedContent() ?? [];
        $sectionHero = $collectionContent['section_hero'] ?? [];

        $sectionHeroTitle = $sectionHero['title'] ?? ($item->localized('title') ?? 'Collection');
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

        $mainImage = !empty($item->image)
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($item->image)
            : null;

        $thumbs = array_values(array_filter([
            $item->secondary_image,
            $item->third_image,
            $item->fourth_image,
        ]));
    @endphp

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

    <section class="artwork" aria-label="Collection item">
        <div class="artwork-inner">
            <header class="artwork-hero">
                <div class="artwork-hero-left">
                    <h2 class="artwork-title">{{ $item->localized('title') }}</h2>

                    @if(!empty($item->localized('short_description')))
                        <div class="artwork-lead">{{ $item->localized('short_description') }}</div>
                    @endif
                </div>

                <div class="artwork-hero-right">
                    @if($mainImage)
                        <div class="artwork-hero-image">
                            <img src="{{ $mainImage }}" alt="{{ $item->localized('title') }}" loading="lazy" />
                        </div>
                    @endif

                    @if($thumbs !== [])
                        <div class="artwork-thumbs" aria-label="Additional images">
                            @foreach($thumbs as $thumb)
                                <div class="artwork-thumb">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($thumb) }}"
                                        alt="{{ $item->localized('title') }}"
                                        loading="lazy"
                                    />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </header>

            @if(!empty($item->localized('full_description')))
                <div class="artwork-body">
                    <div class="artwork-body-text">
                        {!! nl2br(e($item->localized('full_description'))) !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if(($relatedItems ?? collect())->count())
        <section class="related" aria-label="Related collection items">
            <div class="related-inner">
                <div class="related-head">
                    <h3 class="related-title">RELATED</h3>
                </div>

                <div class="related-grid" role="list">
                    @foreach($relatedItems as $rel)
                        @php
                            $relImg = !empty($rel->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($rel->image) : null;
                        @endphp
                        @if($relImg)
                            <article class="related-card" role="listitem">
                                <a class="related-card-link" href="{{ route('collection.show', $rel->slug) }}" aria-label="{{ $rel->localized('title') }}">
                                    <div class="related-image">
                                        <img src="{{ $relImg }}" alt="{{ $rel->localized('title') }}" loading="lazy">
                                    </div>
                                    <div class="related-meta">
                                        <div class="related-name">“{{ strtoupper((string) ($rel->localized('title') ?? '')) }}”</div>
                                    </div>
                                </a>
                            </article>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @once
        <style>
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
        </style>
    @endonce
@endsection

