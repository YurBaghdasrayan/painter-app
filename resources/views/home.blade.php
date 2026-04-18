@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero" aria-label="Hero">
        <div class="hero-inner">
            <h1 class="hero-title">
                Your digital twin<br />
                solution with AI model
            </h1>
            <p class="hero-subtitle">
                Grow smarter, grow faster as we need Solutions at the right place and at Smarttrak we are empowering all your digital twin needs
            </p>
        </div>

{{--        <div class="wave-wrap" aria-hidden="true">--}}
{{--            <svg class="wave" viewBox="0 0 1920 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">--}}
{{--                <path--}}
{{--                    d="M0,78--}}
{{--                       C180,112 360,22 540,66--}}
{{--                       C720,110 880,124 1040,86--}}
{{--                       C1200,48 1350,58 1500,80--}}
{{--                       C1650,102 1760,64 1860,22--}}
{{--                       C1898,6 1912,4 1920,4"--}}
{{--                    fill="none"--}}
{{--                    stroke="#c88b2a"--}}
{{--                    stroke-width="2"--}}
{{--                    stroke-linecap="round"--}}
{{--                    stroke-linejoin="round"--}}
{{--                />--}}
{{--            </svg>--}}
{{--        </div>--}}
    </section>

    <section id="about" class="about" aria-label="About">
        <img src="{{ asset('assets/images/about-bg.png') }}" alt="About background" class="about-bg" />
        <img src="{{ asset('assets/images/line.svg') }}" alt="About background" class="line" />

{{--        <div class="about-overlay"></div>--}}
        <div class="about-content">
            <div class="about-card">
                <div class="about-kicker">ARTIST</div>
                <div class="about-title">ABOUT ME</div>
                <div class="about-lead">Smarttrak is a AI Technology Solutions company focused on</div>

                <ul class="about-list">
                    <li>Premium digital twin solutions</li>
                    <li>AI-driven product intelligence</li>
                    <li>Luxury-grade execution and detail</li>
                </ul>

                <p class="about-lower">
                    Grow smarter with clear strategy, clean design, and dependable delivery. We craft experiences that feel premium, minimal, and precise—built for modern desktop-first performance.
                </p>

                <a class="about-btn" href="#read-more">Read more</a>
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
@endsection

@push('scripts')
    <script>
        (function () {
            const toggle = document.querySelector('.nav-toggle');
            const nav = document.getElementById('primaryNav');
            if (!toggle || !nav) return;

            function setOpen(isOpen) {
                toggle.setAttribute('aria-expanded', String(isOpen));
                document.documentElement.classList.toggle('nav-open', isOpen);
            }

            toggle.addEventListener('click', function () {
                const isOpen = toggle.getAttribute('aria-expanded') === 'true';
                setOpen(!isOpen);
            });

            nav.addEventListener('click', function (e) {
                const target = e.target;
                if (!(target instanceof Element)) return;
                if (target.closest('a')) setOpen(false);
            });

            window.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });
        })();
    </script>
@endpush

