@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    @php
        $articlesContent = $articlesPage?->localizedContent() ?? [];

        $hero = $articlesContent['hero'] ?? [];
        $intro = $articlesContent['intro_section'] ?? [];

        $heroTitle = $hero['title'] ?? 'Articles';
        $heroSubtitle = $hero['subtitle'] ?? 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs';
        $heroBgImage = $hero['background_image'] ?? null;
        $heroMainImage = $hero['main_image'] ?? null;

        $introColumns = collect($intro['columns'] ?? [])->filter()->values();

        if (is_array($heroBgImage)) {
            $heroBgImage = $heroBgImage[0] ?? null;
        }

        if (is_array($heroMainImage)) {
            $heroMainImage = $heroMainImage[0] ?? null;
        }

        $heroBgImageUrl = $heroBgImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBgImage) : null;
        $heroMainImageUrl = $heroMainImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMainImage) : null;

        $articlesForCards = $articles ?? collect();
        $useSlider = $articlesForCards->count() > 3;
    @endphp

    @section('meta_description', strip_tags((string) $heroSubtitle))

    <section class="articles-hero-page" aria-label="Articles hero">
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
            @if($heroBgImageUrl)
                <img
                    src="{{ $heroBgImageUrl }}"
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
                @if($heroMainImageUrl)
                    <div class="articles-hero-page__main-image-box">
                        <img
                            src="{{ $heroMainImageUrl }}"
                            alt="{{ $heroTitle }}"
                            class="articles-hero-page__main-image"
                        >
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if($introColumns->count())
        <section class="articles-intro-section" aria-label="Articles intro">
            <div class="articles-intro-section__inner">
                <div class="articles-intro-section__grid">
                    @foreach($introColumns as $column)
                        <div class="articles-intro-section__col">
                            <div class="articles-intro-section__text">
                                {!! $column !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($articlesForCards->count())
        <section class="articles-card-section" aria-label="Articles cards">
            <div class="articles-card-section__inner">
                @if($useSlider)
                    <div class="swiper articles-card-swiper">
                        <div class="swiper-wrapper">
                            @foreach($articlesForCards as $article)
                                @php
                                    $locale = app()->getLocale() === 'hy' ? 'am' : app()->getLocale();
                                    $contentField = 'content_' . $locale;
                                    $fallbackField = 'content_en';

                                    $content = $article->{$contentField} ?: $article->{$fallbackField} ?: [];
                                    $card = $content['card'] ?? [];

                                    $cardImage = $card['image'] ?? null;
                                    $cardTitle = $card['title'] ?? $article->localized('title');
                                    $cardDescription = $card['description'] ?? $article->localized('short_description');

                                    $cardImageUrl = $cardImage
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($cardImage)
                                        : null;
                                @endphp

                                <div class="swiper-slide">
                                    <article class="articles-card">
                                        <a href="{{ route('articles.show', $article->slug) }}" class="articles-card__link">
                                            @if($cardImageUrl)
                                                <div class="articles-card__image-wrap">
                                                    <img src="{{ $cardImageUrl }}" alt="{{ $cardTitle }}" class="articles-card__image">
                                                </div>
                                            @endif

                                            @if($cardTitle)
                                                <h3 class="articles-card__title">“{{ $cardTitle }}”</h3>
                                            @endif

                                            @if($cardDescription)
                                                <div class="articles-card__description">
                                                    {{ $cardDescription }}
                                                </div>
                                            @endif
                                        </a>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        <div class="articles-card-swiper__nav">
                            <div class="articles-card-swiper__prev">←</div>
                            <div class="articles-card-swiper__next">→</div>
                        </div>
                    </div>
                @else
                    <div class="articles-card-grid">
                        @foreach($articlesForCards as $article)
                            @php
                                $locale = app()->getLocale() === 'hy' ? 'am' : app()->getLocale();
                                $contentField = 'content_' . $locale;
                                $fallbackField = 'content_en';

                                $content = $article->{$contentField} ?: $article->{$fallbackField} ?: [];
                                $card = $content['card'] ?? [];

                                $cardImage = $card['image'] ?? null;
                                $cardTitle = $card['title'] ?? $article->localized('title');
                                $cardDescription = $card['description'] ?? $article->localized('short_description');

                                $cardImageUrl = $cardImage
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($cardImage)
                                    : null;
                            @endphp

                            <article class="articles-card">
                                <a href="{{ route('articles.show', $article->slug) }}" class="articles-card__link">
                                    @if($cardImageUrl)
                                        <div class="articles-card__image-wrap">
                                            <img src="{{ $cardImageUrl }}" alt="{{ $cardTitle }}" class="articles-card__image">
                                        </div>
                                    @endif

                                    @if($cardTitle)
                                        <h3 class="articles-card__title">“{{ $cardTitle }}”</h3>
                                    @endif

                                    @if($cardDescription)
                                        <div class="articles-card__description">
                                            {{ $cardDescription }}
                                        </div>
                                    @endif
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @endif
    @php
        $homePage = \App\Models\StaticPage::query()
            ->where('slug', 'home')
            ->where('is_active', true)
            ->first();

        $homeContent = $homePage?->localizedContent() ?? [];
        $homeArticlesSection = $homeContent['articles_section'] ?? [];

        $homeArticlesTitle = $homeArticlesSection['title'] ?? '';
        $homeArticlesLeftText = $homeArticlesSection['left_text'] ?? '';
        $homeArticlesRightText = $homeArticlesSection['right_text'] ?? '';
        $homeArticlesMainImage = $homeArticlesSection['main_image'] ?? null;
        $homeArticlesSideImage = $homeArticlesSection['side_image'] ?? null;
        $homeArticlesCardTitle = $homeArticlesSection['card_title'] ?? '';
        $homeArticlesCardText = $homeArticlesSection['card_text'] ?? '';
        $homeArticlesMoreText = $homeArticlesSection['more_text'] ?? 'more';
        $homeArticlesMoreLink = $homeArticlesSection['more_link'] ?? '/articles';

        if (is_array($homeArticlesMainImage)) {
            $homeArticlesMainImage = $homeArticlesMainImage[0] ?? null;
        }

        if (is_array($homeArticlesSideImage)) {
            $homeArticlesSideImage = $homeArticlesSideImage[0] ?? null;
        }

    @endphp
    @include('partials.articles-section', [
    'sectionId' => 'articles',
    'sectionClass' => 'home-articles',
    'articlesTitle' => $homeArticlesTitle,
    'articlesLeftText' => $homeArticlesLeftText,
    'articlesRightText' => $homeArticlesRightText,
    'articlesSideImage' => $homeArticlesSideImage,
    'articlesMainImage' => $homeArticlesMainImage,
    'articlesCardTitle' => $homeArticlesCardTitle,
    'articlesCardText' => $homeArticlesCardText,
    'articlesMoreText' => $homeArticlesMoreText,
    'articlesMoreLink' => $homeArticlesMoreLink,
])
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.articles-card-swiper');

            if (!slider) return;

            new Swiper(slider, {
                slidesPerView: 1.15,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.articles-card-swiper__next',
                    prevEl: '.articles-card-swiper__prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 28,
                    },
                }
            });
        });
    </script>
@endpush
