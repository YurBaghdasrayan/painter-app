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
        $heroTitle1 = $hero['title_line_1'] ?? ($hero['title'] ?? null);
        $heroTitle2 = $hero['title_line_2'] ?? null;

        if (is_string($heroTitle1) && str_contains($heroTitle1, "\n") && empty($heroTitle2)) {
            $parts = preg_split("/\\R/u", $heroTitle1, 2);
            $heroTitle1 = $parts[0] ?? $heroTitle1;
            $heroTitle2 = $parts[1] ?? null;
        }

        $homeHeroTitle = trim(implode("\n", array_values(array_filter([
            is_string($heroTitle1) ? $heroTitle1 : null,
            is_string($heroTitle2) ? $heroTitle2 : null,
        ]))));

        if ($homeHeroTitle === '') {
            $homeHeroTitle = "Your digital twin\nsolution with AI model";
        }
        $homeHeroSubtitle = $hero['subtitle'] ?? 'Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs';

        // SEO
        $__metaDescription = $homeHeroSubtitle;

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

        $aboutBgIsVideo = false;
        if (is_string($aboutBg) && $aboutBg !== '') {
            $aboutBgIsVideo = (bool) preg_match('/\.(mp4|webm|mov)$/i', $aboutBg);
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

        $gallerySection = $homeContent['gallery_section'] ?? [];
        $galleryTitle = $gallerySection['title'] ?? 'GALLERY';
        $galleryLeftText = $gallerySection['left_text'] ?? '';
        $galleryRightText = $gallerySection['right_text'] ?? '';
        $galleryMoreText = $gallerySection['more_text'] ?? 'more';

        $collectionSection = $homeContent['collection_section'] ?? [];
        $collectionTitle = $collectionSection['title'] ?? '';
        $collectionLeftText = $collectionSection['left_text'] ?? '';
        $collectionRightText = $collectionSection['right_text'] ?? '';
        $collectionMoreText = $collectionSection['more_text'] ?? null;
        $collectionMoreLink = $collectionSection['more_link'] ?? null;

        $exhibitionsSection = $homeContent['exhibitions_section'] ?? [];
        $exhibitionsTitle = $exhibitionsSection['title'] ?? 'EXHIBITIONS';
        $exhibitionsLeftHeading = $exhibitionsSection['left_heading'] ?? '';
        $exhibitionsBullets = collect($exhibitionsSection['bullets'] ?? [])->filter()->values();
        $exhibitionsLeftText = $exhibitionsSection['left_text'] ?? '';
        $exhibitionsRightText = $exhibitionsSection['right_text'] ?? '';
        $exhibitionsButtonText = $exhibitionsSection['button_text'] ?? 'Read more';
        $exhibitionsButtonLink = route('exhibitions.index');
        $exhibitionsBg = $exhibitionsSection['background_image'] ?? null;

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

        $contactPage = \App\Models\StaticPage::query()
            ->where('slug', 'contact')
            ->where('is_active', true)
            ->first();
        $contactContent = $contactPage?->localizedContent() ?? [];
        $contactHeroTitle = $contactContent['contact']['hero_title'] ?? 'CONTACT WE';
        $contactHeroSubtitle = $contactContent['contact']['hero_subtitle'] ?? null;

        $locale = app()->getLocale();
        if ($locale === 'hy') $locale = 'am';
        $i18n = [
            'am' => [
                'first_name' => 'Անուն',
                'last_name' => 'Ազգանուն',
                'email' => 'Էլ․ հասցե',
                'phone' => 'Հեռախոսահամար',
                'message' => 'Հաղորդագրություն',
                'message_placeholder' => 'Գրեք ձեր հաղորդագրությունը',
                'send' => 'Ուղարկել',
            ],
            'ru' => [
                'first_name' => 'Имя',
                'last_name' => 'Фамилия',
                'email' => 'Email',
                'phone' => 'Номер телефона',
                'message' => 'Сообщение',
                'message_placeholder' => 'Напишите ваше сообщение',
                'send' => 'Отправить',
            ],
            'en' => [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'email' => 'Email',
                'phone' => 'Phone Number',
                'message' => 'Message',
                'message_placeholder' => 'Write your message',
                'send' => 'Send Message',
            ],
        ];
        $t = $i18n[$locale] ?? $i18n['en'];
    @endphp

    @section('meta_description', $__metaDescription)

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
        @if($aboutBgIsVideo)
            <video class="about-bg about-bg--video" autoplay muted loop playsinline preload="metadata" aria-hidden="true">
                <source src="{{ $aboutBgUrl }}">
            </video>
        @else
            <img src="{{ $aboutBgUrl }}" alt="About background" class="about-bg" />
        @endif
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

    @if(($galleryItems ?? collect())->count())
        <section id="gallery" class="gallery" aria-label="Gallery">
            <div class="gallery-inner">
                <div class="gallery-head">
                    <h2 class="gallery-title">{{ $galleryTitle }}</h2>

                    @if(trim((string) $galleryLeftText) !== '' || trim((string) $galleryRightText) !== '')
                        <div class="gallery-toptexts">
                            <div class="gallery-toptext gallery-toptext--left">
                                {!! nl2br(e((string) $galleryLeftText)) !!}
                            </div>
                            <div class="gallery-toptext gallery-toptext--right">
                                {!! nl2br(e((string) $galleryRightText)) !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="gallery-section-grid" role="list">
                    @foreach(($galleryItems ?? collect()) as $item)
                        @php
                            $img = !empty($item->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) : null;
                            $title = $item->localized('title') ?? 'Gallery';
                            $desc = trim((string) ($item->localized('full_description') ?? $item->localized('short_description') ?? ''));
                        @endphp

                        @if($img && $item->slug)
                            <article class="gallery-section-card" role="listitem">
                                <a class="gallery-section-card-link" href="{{ route('gallery.show', $item->slug) }}" aria-label="{{ $title }}">
                                    <div class="gallery-section-card-image">
                                        <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" />
                                    </div>
                                    <div class="gallery-section-card-meta">
                                        <div class="gallery-section-card-title">
                                            “{{ strtoupper((string) $title) }}”
                                        </div>
                                        @if($desc !== '')
                                            <div class="gallery-section-card-desc">{{ $desc }}</div>
                                        @endif
                                    </div>
                                </a>
                            </article>
                        @endif
                    @endforeach
                </div>

                <div class="gallery-footer">
                    <div class="gallery-more">
                        <span class="gallery-more-text">{{ $galleryMoreText }}</span>
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

    @if($exhibitionsTitle || (($exhibitions ?? collect())->count()))
        <section id="exhibitions" class="home-exhibitions" aria-label="Exhibitions">
            <div class="home-exhibitions__inner">
                <header class="home-exhibitions__head">
                    <h2 class="home-exhibitions__title">{{ $exhibitionsTitle }}</h2>
                </header>

                @if(($exhibitions ?? collect())->count())
                    <div class="home-exhibitions__cards" role="list">
                        @foreach(($exhibitions ?? collect()) as $ex)
                            @php
                                $img = !empty($ex->image) ? \Illuminate\Support\Facades\Storage::disk('public')->url($ex->image) : null;
                                $title = $ex->localized('title') ?? 'Exhibition';
                                $desc = trim((string) ($ex->localized('description') ?? ''));
                            @endphp

                            <article class="home-exhibitions-card" role="listitem">
                                <a class="home-exhibitions-card__link" href="{{ route('exhibitions.show', $ex) }}" aria-label="{{ $title }}">
                                    <div class="home-exhibitions-card__media">
                                        @if($img)
                                            <img src="{{ $img }}" alt="{{ $title }}" loading="lazy" />
                                        @endif
                                    </div>

                                    <div class="home-exhibitions-card__meta">
                                        <div class="home-exhibitions-card__title">
                                            “{{ strtoupper((string) $title) }}”
                                        </div>
                                        @if($desc !== '')
                                            <div class="home-exhibitions-card__desc">{{ $desc }}</div>
                                        @endif
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif

                <div class="home-exhibitions__footer">
                    <a class="home-exhibitions__btn" href="{{ $exhibitionsButtonLink }}">
                        {{ $exhibitionsButtonText }}
                    </a>
                </div>
            </div>
        </section>
    @endif

{{--    <section class="home-contact" aria-label="Contact form">--}}
{{--        <div class="home-contact__hero-wrap" aria-label="Contact header">--}}
{{--            <div class="home-contact__hero-inner">--}}
{{--                <header class="home-contact__hero">--}}
{{--                    <h2 class="home-contact__title">{{ $contactHeroTitle }}</h2>--}}
{{--                    @if($contactHeroSubtitle)--}}
{{--                        <p class="home-contact__subtitle">{{ $contactHeroSubtitle }}</p>--}}
{{--                    @endif--}}
{{--                </header>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <svg class="home-contact__wave" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">--}}
{{--            <path--}}
{{--                d="M0 104--}}
{{--                   C120 132 210 58 332 86--}}
{{--                   C476 118 620 90 760 110--}}
{{--                   C910 132 1050 92 1188 74--}}
{{--                   C1302 58 1376 76 1440 66--}}
{{--                   L1440 180--}}
{{--                   L0 180--}}
{{--                   Z"--}}
{{--                fill="#e8e6e1"--}}
{{--            />--}}
{{--        </svg>--}}
{{--        <svg class="home-contact__stroke" viewBox="0 0 1440 180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" aria-hidden="true">--}}
{{--            <path--}}
{{--                d="M0 104--}}
{{--                   C120 132 210 58 332 86--}}
{{--                   C476 118 620 90 760 110--}}
{{--                   C910 132 1050 92 1188 74--}}
{{--                   C1302 58 1376 76 1440 66"--}}
{{--                fill="none"--}}
{{--                stroke="#ffffff"--}}
{{--                stroke-width="5"--}}
{{--                stroke-linecap="round"--}}
{{--                stroke-linejoin="round"--}}
{{--            />--}}
{{--        </svg>--}}

{{--        <div class="home-contact__inner">--}}
{{--            <form class="contact-form contact-form--home" method="post" action="#">--}}
{{--                @csrf--}}

{{--                <div class="contact-form__grid">--}}
{{--                    <label class="contact-field">--}}
{{--                        <span class="contact-field__label">{{ $t['first_name'] }}</span>--}}
{{--                        <input class="contact-field__input" type="text" name="first_name" autocomplete="given-name">--}}
{{--                    </label>--}}

{{--                    <label class="contact-field">--}}
{{--                        <span class="contact-field__label">{{ $t['last_name'] }}</span>--}}
{{--                        <input class="contact-field__input" type="text" name="last_name" autocomplete="family-name">--}}
{{--                    </label>--}}

{{--                    <label class="contact-field">--}}
{{--                        <span class="contact-field__label">{{ $t['email'] }}</span>--}}
{{--                        <input class="contact-field__input" type="email" name="email" autocomplete="email">--}}
{{--                    </label>--}}

{{--                    <label class="contact-field">--}}
{{--                        <span class="contact-field__label">{{ $t['phone'] }}</span>--}}
{{--                        <input class="contact-field__input" type="tel" name="phone" autocomplete="tel">--}}
{{--                    </label>--}}

{{--                    <label class="contact-field contact-field--message">--}}
{{--                        <span class="contact-field__label">{{ $t['message'] }}</span>--}}
{{--                        <textarea class="contact-field__textarea" name="message" rows="3" placeholder="{{ $t['message_placeholder'] }}"></textarea>--}}
{{--                    </label>--}}
{{--                </div>--}}

{{--                <div class="contact-form__actions">--}}
{{--                    <button class="contact-form__submit" type="submit">{{ $t['send'] }}</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </section>--}}
@endsection
