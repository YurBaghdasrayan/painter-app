@extends('layouts.app')

@section('title', $article->localizedTitle() ?? 'Article')

@section('content')
    @php
        $heroTitle = $hero['title'] ?? $article->localizedTitle();
        $heroSubtitle = $hero['subtitle'] ?? '';

        $heroBgImage = $hero['background_image'] ?? null;
        $heroMainImage = $hero['main_image'] ?? null;

        $textBlock1LeftTitle = $textBlock1['left_title'] ?? '';
        $textBlock1LeftText = $textBlock1['left_text'] ?? '';
        $textBlock1RightTitle = $textBlock1['right_title'] ?? '';
        $textBlock1RightText = $textBlock1['right_text'] ?? '';

        $imageBlock1Image = $imageBlock1['image'] ?? null;

        $textBlock2Title = $textBlock2['title'] ?? '';
        $textBlock2LeftText = $textBlock2['left_text'] ?? '';
        $textBlock2RightText = $textBlock2['right_text'] ?? '';

        $imageBlock2Image = $imageBlock2['image'] ?? null;

        $afterImage2LeftText = $afterImage2['left_text'] ?? '';
        $afterImage2RightText = $afterImage2['right_text'] ?? '';

        $bottomBlockTitle = $bottomBlock['title'] ?? '';
        $bottomBlockLeftText = $bottomBlock['left_text'] ?? '';
        $bottomBlockRightText = $bottomBlock['right_text'] ?? '';

        $heroBgImageUrl = $heroBgImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroBgImage) : null;
        $heroMainImageUrl = $heroMainImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMainImage) : null;
        $imageBlock1ImageUrl = $imageBlock1Image ? \Illuminate\Support\Facades\Storage::disk('public')->url($imageBlock1Image) : null;
        $imageBlock2ImageUrl = $imageBlock2Image ? \Illuminate\Support\Facades\Storage::disk('public')->url($imageBlock2Image) : null;
    @endphp

    <section class="article-show-hero" aria-label="Article hero">
        <div class="article-show-hero__top">
            <div class="article-show-hero__inner">
                <h1 class="article-show-hero__title">“{{ $heroTitle }}”</h1>

                @if($heroSubtitle)
                    <p class="article-show-hero__subtitle">{{ $heroSubtitle }}</p>
                @endif
            </div>
        </div>

        <div class="article-show-hero__visual">
            @if($heroBgImageUrl)
                <img src="{{ $heroBgImageUrl }}" alt="{{ $heroTitle }}" class="article-show-hero__bg">
            @endif

            <div class="article-show-hero__shape"></div>

            <svg class="article-show-hero__line" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">
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

            <div class="article-show-hero__inner article-show-hero__image-wrap">
                @if($heroMainImageUrl)
                    <div class="article-show-hero__main-image-box">
                        <img
                            src="{{ $heroMainImageUrl }}"
                            alt="{{ $heroTitle }}"
                            class="article-show-hero__main-image"
                        >
                    </div>
                @endif
            </div>
        </div>
    </section>

    @if($textBlock1LeftTitle || $textBlock1LeftText || $textBlock1RightTitle || $textBlock1RightText)
        <section style="background-color:#FFFCF5 " class="article-show-text-block article-show-text-block--first" aria-label="Article text block 1">
            <div class="article-show-text-block__inner">
                <div class="article-show-text-block__grid article-show-text-block__grid--two">
                    <div class="article-show-text-block__col">
                        @if($textBlock1LeftTitle)
                            <h2 class="article-show-text-block__title">“{{ $textBlock1LeftTitle }}”</h2>
                        @endif

                        @if($textBlock1LeftText)
                            <div class="article-show-text-block__text">{!! $textBlock1LeftText !!}</div>
                        @endif
                    </div>

                    <div class="article-show-text-block__col">
                        @if($textBlock1RightTitle)
                            <h2 class="article-show-text-block__title">“{{ $textBlock1RightTitle }}”</h2>
                        @endif

                        @if($textBlock1RightText)
                            <div class="article-show-text-block__text">{!! $textBlock1RightText !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($imageBlock1ImageUrl)
        <section style="background-color: #FFFCF5" class="article-show-image-block" aria-label="Article image block 1">
            <div class="article-show-image-block__inner">
                <div class="article-show-image-block__image-wrap">
                    <img src="{{ $imageBlock1ImageUrl }}" alt="{{ $heroTitle }}" class="article-show-image-block__image">
                </div>

                <a href="{{ route('articles.index') }}" class="article-show-image-block__arrow" aria-label="Back to articles">
                    <span>→</span>
                </a>
            </div>
        </section>
    @endif

    @if($textBlock2Title || $textBlock2LeftText || $textBlock2RightText)
        <section class="article-show-text-block" aria-label="Article text block 2">
            <div class="article-show-text-block__inner">
                @if($textBlock2Title)
                    <div class="article-show-text-block__heading">
                        <h2 class="article-show-text-block__title article-show-text-block__title--large">{{ $textBlock2Title }}</h2>
                    </div>
                @endif

                <div class="article-show-text-block__content-grid">
                    <div class="article-show-text-block__col">
                        @if($textBlock2LeftText)
                            <div class="article-show-text-block__text">{!! $textBlock2LeftText !!}</div>
                        @endif
                    </div>

                    <div class="article-show-text-block__col">
                        @if($textBlock2RightText)
                            <div class="article-show-text-block__text">{!! $textBlock2RightText !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($imageBlock2ImageUrl)
        <section style="background-color: #FFFCF5" class="article-show-image-block article-show-image-block--second" aria-label="Article image block 2">
            <div class="article-show-image-block__inner">
                <div class="article-show-image-block__image-wrap article-show-image-block__image-wrap--large">
                    <img src="{{ $imageBlock2ImageUrl }}" alt="{{ $heroTitle }}" class="article-show-image-block__image">
                </div>

                <a href="{{ route('articles.index') }}" class="article-show-image-block__arrow" aria-label="Back to articles">
                    <span>→</span>
                </a>
            </div>
        </section>
    @endif

    @if($afterImage2LeftText || $afterImage2RightText)
        <section style="background-color: #FFFCF5" class="article-show-text-block article-show-text-block--after-image" aria-label="Text under second image">
            <div class="article-show-text-block__inner">
                <div class="article-show-text-block__content-grid">
                    <div class="article-show-text-block__col">
                        @if($afterImage2LeftText)
                            <div class="article-show-text-block__text">{!! $afterImage2LeftText !!}</div>
                        @endif
                    </div>

                    <div class="article-show-text-block__col">
                        @if($afterImage2RightText)
                            <div class="article-show-text-block__text">{!! $afterImage2RightText !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($bottomBlockTitle || $bottomBlockLeftText || $bottomBlockRightText)
        <section style="background-color: #FFFCF5" class="article-show-text-block article-show-text-block--last" aria-label="Bottom text block">
            <div class="article-show-text-block__inner">
                @if($bottomBlockTitle)
                    <div class="article-show-text-block__heading article-show-text-block__heading--bottom">
                        <h2 class="article-show-text-block__title article-show-text-block__title--large">{{ $bottomBlockTitle }}</h2>
                    </div>
                @endif

                <div class="article-show-text-block__content-grid">
                    <div class="article-show-text-block__col">
                        @if($bottomBlockLeftText)
                            <div class="article-show-text-block__text">{!! $bottomBlockLeftText !!}</div>
                        @endif
                    </div>

                    <div class="article-show-text-block__col">
                        @if($bottomBlockRightText)
                            <div class="article-show-text-block__text">{!! $bottomBlockRightText !!}</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if($relatedArticles->count())
        @php
            $useRelatedSlider = $relatedArticles->count() > 4;
        @endphp

        <section style="background-color: #FFFCF5" class="article-related-section" aria-label="Related articles">
            <div class="article-related-section__inner">
                @if($useRelatedSlider)
                    <div class="swiper article-related-swiper">
                        <div class="swiper-wrapper">
                            @foreach($relatedArticles as $relatedArticle)
                                @php
                                    $relatedContent = $relatedArticle->localizedContent();
                                    $relatedCard = $relatedContent['card'] ?? [];

                                    $relatedCardImage = $relatedCard['image'] ?? null;
                                    $relatedCardTitle = $relatedCard['title'] ?? $relatedArticle->localizedTitle();
                                    $relatedCardDescription = $relatedCard['description'] ?? $relatedArticle->localizedShortDescription();

                                    $relatedCardImageUrl = $relatedCardImage
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($relatedCardImage)
                                        : null;
                                @endphp

                                <div class="swiper-slide">
                                    <article class="article-related-card">
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="article-related-card__link">
                                            @if($relatedCardImageUrl)
                                                <div class="article-related-card__image-wrap">
                                                    <img
                                                        src="{{ $relatedCardImageUrl }}"
                                                        alt="{{ $relatedCardTitle }}"
                                                        class="article-related-card__image"
                                                    >
                                                </div>
                                            @endif

                                            @if($relatedCardTitle)
                                                <h3 class="article-related-card__title">“{{ $relatedCardTitle }}”</h3>
                                            @endif

                                            @if($relatedCardDescription)
                                                <div class="article-related-card__description">
                                                    {{ $relatedCardDescription }}
                                                </div>
                                            @endif
                                        </a>
                                    </article>
                                </div>
                            @endforeach
                        </div>

                        <div class="article-related-swiper__next">→</div>
                    </div>
                @else
                    <div class="article-related-grid">
                        @foreach($relatedArticles as $relatedArticle)
                            @php
                                $relatedContent = $relatedArticle->localizedContent();
                                $relatedCard = $relatedContent['card'] ?? [];

                                $relatedCardImage = $relatedCard['image'] ?? null;
                                $relatedCardTitle = $relatedCard['title'] ?? $relatedArticle->localizedTitle();
                                $relatedCardDescription = $relatedCard['description'] ?? $relatedArticle->localizedShortDescription();

                                $relatedCardImageUrl = $relatedCardImage
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($relatedCardImage)
                                    : null;
                            @endphp

                            <article class="article-related-card">
                                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="article-related-card__link">
                                    @if($relatedCardImageUrl)
                                        <div class="article-related-card__image-wrap">
                                            <img
                                                src="{{ $relatedCardImageUrl }}"
                                                alt="{{ $relatedCardTitle }}"
                                                class="article-related-card__image"
                                            >
                                        </div>
                                    @endif

                                    @if($relatedCardTitle)
                                        <h3 class="article-related-card__title">“{{ $relatedCardTitle }}”</h3>
                                    @endif

                                    @if($relatedCardDescription)
                                        <div class="article-related-card__description">
                                            {{ $relatedCardDescription }}
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
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const relatedSlider = document.querySelector('.article-related-swiper');

            if (!relatedSlider) return;

            new Swiper(relatedSlider, {
                slidesPerView: 1.2,
                spaceBetween: 20,
                navigation: {
                    nextEl: '.article-related-swiper__next',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 28,
                    }
                }
            });
        });
    </script>
@endpush
