@extends('layouts.app')

@section('title', $item->localized('title') ?? 'Artwork')

@section('content')
    <section class="artwork" aria-label="Artwork">
        <div class="artwork-inner">
            <header class="artwork-hero">
                <div class="artwork-hero-left">
                    <h1 class="artwork-title">{{ $item->localized('title') }}</h1>

                    @if(!empty($item->localized('short_description')))
                        <div class="artwork-lead">{{ $item->localized('short_description') }}</div>
                    @endif
                </div>

                <div class="artwork-hero-right">
                    <div class="artwork-hero-image">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}" alt="{{ $item->localized('title') }}" />
                    </div>
                </div>
            </header>

            @php
                $thumbs = array_values(array_filter([
                    $item->secondary_image,
                    $item->third_image,
                    $item->fourth_image,
                ]));
            @endphp

            @if($thumbs !== [])
                <div class="artwork-thumbs" aria-label="Additional images">
                    @foreach($thumbs as $thumb)
                        <div class="artwork-thumb">
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($thumb) }}" alt="{{ $item->localized('title') }}" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            @endif

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

