@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @php
        $homePage = \App\Models\StaticPage::query()
            ->where('slug', 'home')
            ->where('is_active', true)
            ->first();

        $homeContent = $homePage?->localizedContent() ?? [];
        $hero = $homeContent['hero'] ?? [];
        $homeHeroTitle = $hero['title'] ?? "Your digital twin\nsolution with AI model";
        $homeHeroSubtitle = $hero['subtitle'] ?? 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs';

        $about = $homeContent['about_section'] ?? [];
        $aboutKicker = $about['kicker'] ?? 'ARTIST';
        $aboutTitle = $about['title'] ?? 'ABOUT ME';
        $aboutLead = $about['lead'] ?? 'Smarttrak is a AI Technology Solutions company focused on';
        $aboutItems = collect($about['items'] ?? [])->filter()->values();
        $aboutLowerText = $about['lower_text'] ?? 'Grow smarter with clear strategy, clean design, and dependable delivery. We craft experiences that feel premium, minimal, and precise—built for modern desktop-first performance.';
        $aboutButtonText = $about['button_text'] ?? 'Read more';
        $aboutButtonLink = $about['button_link'] ?? '/about';
        $aboutBg = $about['background_image'] ?? null;

        if (is_array($aboutBg)) {
            $aboutBg = $aboutBg[0] ?? null;
        }

        $aboutBgUrl = $aboutBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($aboutBg)
            : asset('assets/images/about-bg.png');

        $articlesSection = $homeContent['articles_section'] ?? [];

        $articlesTitle = $articlesSection['title'] ?? '';
        $articlesLeftText = $articlesSection['left_text'] ?? '';
        $articlesRightText = $articlesSection['right_text'] ?? '';
        $articlesMainImage = $articlesSection['main_image'] ?? null;
        $articlesSideImage = $articlesSection['side_image'] ?? null;
        $articlesCardTitle = $articlesSection['card_title'] ?? '';
        $articlesCardText = $articlesSection['card_text'] ?? '';
        $articlesMoreText = $articlesSection['more_text'] ?? 'more';
        $articlesMoreLink = $articlesSection['more_link'] ?? '/articles';

        $collectionSection = $homeContent['collection_section'] ?? [];
        $collectionTitle = $collectionSection['title'] ?? '';
        $collectionLeftText = $collectionSection['left_text'] ?? '';
        $collectionRightText = $collectionSection['right_text'] ?? '';
        $collectionMoreText = $collectionSection['more_text'] ?? null;
        $collectionMoreLink = $collectionSection['more_link'] ?? null;

        $exhibitions = $homeContent['exhibitions_section'] ?? [];
        $exhibitionsTitle = $exhibitions['title'] ?? 'EXHIBITIONS';
        $exhibitionsLeftHeading = $exhibitions['left_heading'] ?? '';
        $exhibitionsBullets = collect($exhibitions['bullets'] ?? [])->filter()->values();
        $exhibitionsLeftText = $exhibitions['left_text'] ?? '';
        $exhibitionsRightText = $exhibitions['right_text'] ?? '';
        $exhibitionsButtonText = $exhibitions['button_text'] ?? 'Read more';
        $exhibitionsButtonLink = $exhibitions['button_link'] ?? '/exhibitions';
        $exhibitionsBg = $exhibitions['background_image'] ?? null;

        if (is_array($exhibitionsBg)) {
            $exhibitionsBg = $exhibitionsBg[0] ?? null;
        }

        $exhibitionsBgUrl = $exhibitionsBg
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($exhibitionsBg)
            : null;

        if (is_array($articlesMainImage)) {
            $articlesMainImage = $articlesMainImage[0] ?? null;
        }

        if (is_array($articlesSideImage)) {
            $articlesSideImage = $articlesSideImage[0] ?? null;
        }
    @endphp

    <section class="hero" aria-label="Hero">
        <div class="hero-inner">
            <h1 class="hero-title">
                {!! nl2br(e((string) $homeHeroTitle)) !!}
            </h1>
            <p class="hero-subtitle">
                {{ $homeHeroSubtitle }}
            </p>
        </div>
    </section>

    <section id="about" class="about" aria-label="About">
        <img src="{{ $aboutBgUrl }}" alt="About background" class="about-bg" />
        <img src="{{ asset('assets/images/line.svg') }}" alt="About background" class="line" />

        <div class="about-content">
            <div class="about-card">
                <div class="about-kicker">{{ $aboutKicker }}</div>
                <div class="about-title">{{ $aboutTitle }}</div>
                <div class="about-lead">{{ $aboutLead }}</div>

                <ul class="about-list">
                    @foreach($aboutItems as $li)
                        <li>{{ $li }}</li>
                    @endforeach
                </ul>

                <p class="about-lower">
                    {{ $aboutLowerText }}
                </p>

                <a class="about-btn" href="{{ $aboutButtonLink }}">{{ $aboutButtonText }}</a>
            </div>
        </div>
    </section>

    @if($gallerySections->count())
        <section id="gallery" class="gallery" aria-label="Gallery">
            <div class="gallery-inner">
                @php
                    $head = $gallerySections->first();
                @endphp

                <div class="gallery-head">
                    <h2 class="gallery-title">{{ $head->localized('title') }}</h2>

                    <div class="gallery-toptexts">
                        <div class="gallery-toptext gallery-toptext--left">
                            {!! nl2br(e($head->localized('left_text') ?? '')) !!}
                        </div>
                        <div class="gallery-toptext gallery-toptext--right">
                            {!! nl2br(e($head->localized('right_text') ?? '')) !!}
                        </div>
                    </div>
                </div>

                <div class="gallery-section-grid" role="list">
                    @foreach($gallerySections as $section)
                        @include('gallery.partials.section-card', ['section' => $section])
                    @endforeach
                </div>

                <div class="gallery-footer">
                    <div class="gallery-more">
                        <span class="gallery-more-text">{{ $gallerySections->first()->localized('more_button_text') }}</span>
                        <a class="gallery-more-btn" href="{{ route('gallery.index') }}" aria-label="More">
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

    @include('partials.articles-section', [
        'sectionId' => 'articles',
        'sectionClass' => 'home-articles',
        'articlesTitle' => $articlesTitle,
        'articlesLeftText' => $articlesLeftText,
        'articlesRightText' => $articlesRightText,
        'articlesSideImage' => $articlesSideImage,
        'articlesMainImage' => $articlesMainImage,
        'articlesCardTitle' => $articlesCardTitle,
        'articlesCardText' => $articlesCardText,
        'articlesMoreText' => $articlesMoreText,
        'articlesMoreLink' => $articlesMoreLink,
    ])

    @if(($collectionSections ?? collect())->count())
        <section id="collection" class="gallery" aria-label="Collection">
            <div class="gallery-inner">
                @php
                    $head = $collectionSections->first();
                    $collectionTitleFinal = $collectionTitle ?: ($head?->localized('title') ?? '');
                    $collectionLeftTextFinal = $collectionLeftText ?: ($head?->localized('description') ?? '');
                    $collectionRightTextFinal = $collectionRightText ?: '';
                    $collectionMoreTextFinal = $collectionMoreText ?: ($head?->localized('more_button_text') ?? 'more');
                    $collectionMoreLinkFinal = $collectionMoreLink ?: (route('collection.index'));
                @endphp

                <div class="gallery-head">
                    <h2 class="gallery-title">{{ $collectionTitleFinal }}</h2>

                    <div class="gallery-toptexts">
                        <div class="gallery-toptext gallery-toptext--left">
                            {!! nl2br(e((string) $collectionLeftTextFinal)) !!}
                        </div>
                        <div class="gallery-toptext gallery-toptext--right">
                            {!! nl2br(e((string) $collectionRightTextFinal)) !!}
                        </div>
                    </div>
                </div>

                <div class="gallery-section-grid" role="list">
                    @foreach($collectionSections as $section)
                        @include('collection.partials.section-card', ['section' => $section])
                    @endforeach
                </div>

                <div class="gallery-footer">
                    <div class="gallery-more">
                        <span class="gallery-more-text">{{ $collectionMoreTextFinal }}</span>
                        <a class="gallery-more-btn" href="{{ $collectionMoreLinkFinal }}" aria-label="More">
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

    @if($exhibitionsTitle || $exhibitionsLeftHeading || $exhibitionsLeftText || $exhibitionsRightText || $exhibitionsBgUrl)
        <section id="exhibitions" class="home-exhibitions" aria-label="Exhibitions">
            @if($exhibitionsBgUrl)
                <img class="home-exhibitions__bg" src="{{ $exhibitionsBgUrl }}" alt="" aria-hidden="true">
            @endif

            <svg class="home-exhibitions__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

            <div class="home-exhibitions__inner">
                <div class="home-exhibitions__grid">
                    <div class="home-exhibitions__left">
                        <h2 class="home-exhibitions__title">{{ $exhibitionsTitle }}</h2>

                        @if($exhibitionsLeftHeading)
                            <div class="home-exhibitions__heading">
                                {!! nl2br(e((string) $exhibitionsLeftHeading)) !!}
                            </div>
                        @endif

                        @if($exhibitionsBullets->count())
                            <ul class="home-exhibitions__bullets">
                                @foreach($exhibitionsBullets->take(4) as $b)
                                    <li>{{ $b }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if($exhibitionsLeftText)
                            <div class="home-exhibitions__copy">
                                {!! nl2br(e((string) $exhibitionsLeftText)) !!}
                            </div>
                        @endif
                    </div>

                    <div class="home-exhibitions__right">
                        @if($exhibitionsRightText)
                            <div class="home-exhibitions__copy home-exhibitions__copy--right">
                                {!! nl2br(e((string) $exhibitionsRightText)) !!}
                            </div>
                        @endif

                        <a class="home-exhibitions__btn" href="{{ $exhibitionsButtonLink }}">
                            {{ $exhibitionsButtonText }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
