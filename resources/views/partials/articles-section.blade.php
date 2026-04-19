@if($articlesTitle || $articlesMainImage || $articlesSideImage)
    <section id="{{ $sectionId ?? 'articles' }}" class="{{ $sectionClass ?? 'home-articles' }}" aria-label="Articles">
        <div class="home-articles-inner">
            <div class="home-articles-head">
                <h2 class="home-articles-title">{{ $articlesTitle }}</h2>

                <div class="home-articles-toptexts">
                    <div class="home-articles-toptext home-articles-toptext--left">
                        {!! nl2br(e($articlesLeftText ?? '')) !!}
                    </div>

                    <div class="home-articles-toptext home-articles-toptext--right">
                        {!! nl2br(e($articlesRightText ?? '')) !!}
                    </div>
                </div>
            </div>

            <div class="home-articles-stage">
                <div class="home-articles-side-card">
                    @if($articlesSideImage)
                        <div class="home-articles-side-image-wrap">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($articlesSideImage) }}"
                                alt="{{ $articlesCardTitle ?: 'Articles image' }}"
                                class="home-articles-side-image"
                            >
                        </div>
                    @endif

                    <div class="home-articles-side-content">
                        @if($articlesCardTitle)
                            <div class="home-articles-card-title">“{{ $articlesCardTitle }}”</div>
                        @endif

                        @if($articlesCardText)
                            <div class="home-articles-card-text">
                                {{ $articlesCardText }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="home-articles-main-card">
                    @if($articlesMainImage)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($articlesMainImage) }}"
                            alt="{{ $articlesTitle ?: 'Articles main image' }}"
                            class="home-articles-main-image"
                        >
                    @endif
                </div>

                <div class="home-articles-right-card">
                    @if($articlesCardTitle)
                        <div class="home-articles-card-title">“{{ $articlesCardTitle }}”</div>
                    @endif

                    @if($articlesCardText)
                        <div class="home-articles-card-text">
                            {{ $articlesCardText }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="home-articles-footer">
                <div class="home-articles-more">
                    <span class="home-articles-more-text">{{ $articlesMoreText ?? 'more' }}</span>

                    <a class="home-articles-more-btn" href="{{ url($articlesMoreLink ?? '/articles') }}" aria-label="More">
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
