@extends('layouts.app')

@section('title', $item->localized('title') ?? 'Artwork')

@section('content')
    @php
        $galleryContent = $staticPage?->localizedContent() ?? [];
        $showHero = $galleryContent['show_hero'] ?? [];
        $showHeroTitle = $showHero['title'] ?? ($item->localized('title') ?? 'Artwork');
        $showHeroSubtitle = $showHero['subtitle'] ?? ($item->localized('short_description') ?? '');

        $showHeroBg = $showHero['background_image'] ?? null;
        $showHeroBgUrl = $showHeroBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($showHeroBg)
            : null;
    @endphp

    @if($showHeroBgUrl || $showHeroTitle || $showHeroSubtitle)
        <section class="artwork-show-hero" aria-label="Artwork hero">
            <div class="artwork-show-hero__top">
                <div class="artwork-show-hero__inner">
                    @if($showHeroTitle)
                        <h1 class="artwork-show-hero__title">{{ $showHeroTitle }}</h1>
                    @endif

                    @if($showHeroSubtitle)
                        <div class="artwork-show-hero__subtitle">{{ $showHeroSubtitle }}</div>
                    @endif
                </div>
            </div>

            <div class="artwork-show-hero__visual" aria-hidden="true">
                @if($showHeroBgUrl)
                    <img class="artwork-show-hero__bg" src="{{ $showHeroBgUrl }}" alt="">
                @endif

                <svg class="artwork-show-hero__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path
                        d="M0 60
                           C120 105 220 15 360 42
                           C520 74 620 18 760 52
                           C930 92 1050 62 1180 34
                           C1280 12 1360 30 1440 10
                           L1440 0
                           L0 0
                           Z"
                        fill="var(--gallery-bg)"
                    />
                </svg>

                <svg class="artwork-show-hero__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
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
    @endif

    <section class="artwork" aria-label="Artwork">
        <div class="artwork-inner">
            <header class="artwork-hero">
                <div class="artwork-hero-left">
                    <h2 class="artwork-title">{{ $item->localized('title') }}</h2>

                    @if(!empty($item->localized('short_description')))
                        <div class="artwork-lead">{{ $item->localized('short_description') }}</div>
                    @endif
                </div>

                <div class="artwork-hero-right">
                    @php
                        $thumbs = array_values(array_filter([
                            $item->secondary_image,
                            $item->third_image,
                            $item->fourth_image,
                        ]));
                    @endphp

                    <div class="artwork-hero-image">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}" alt="{{ $item->localized('title') }}" />
                    </div>

                    @if($thumbs !== [])
                        <div class="artwork-thumbs" aria-label="Additional images">
                            @foreach($thumbs as $thumb)
                                <div class="artwork-thumb">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($thumb) }}" alt="{{ $item->localized('title') }}" loading="lazy" />
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

            <section class="related" aria-label="Related artworks">
                <div class="related-head">
                    <h2 class="related-title">
                        {{ $item->localized('same_line_title') ?: 'FROM THE SAME LINE' }}
                    </h2>
                </div>

                <div class="related-grid" role="list">
                    @foreach($relatedItems as $related)
                        <article class="related-card" role="listitem">
                            <a class="related-link" href="{{ route('gallery.show', $related->slug) }}" aria-label="{{ $related->localized('title') }}">
                                <div class="related-image">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($related->image) }}" alt="{{ $related->localized('title') }}" loading="lazy" />
                                </div>
                                <div class="related-meta">
                                    <div class="related-item-title">{{ $related->localized('title') }}</div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection

