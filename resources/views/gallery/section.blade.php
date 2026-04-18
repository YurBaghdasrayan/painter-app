@extends('layouts.app')

@section('title', $section->localized('title') ?? 'Gallery')

@section('content')
    <section class="gallery-page" aria-label="Gallery section">
        <div class="gallery-page-inner">
            <header class="gallery-page-head">
                <h1 class="gallery-page-section-title">
                    {{ $section->localized('title') ?? 'Gallery' }}
                </h1>

                <div class="gallery-page-toptexts">
                    <div class="gallery-page-toptext">
                        {!! nl2br(e($section->localized('left_text') ?? '')) !!}
                    </div>
                    <div class="gallery-page-toptext">
                        {!! nl2br(e($section->localized('right_text') ?? '')) !!}
                    </div>
                </div>
            </header>

            @php
                $items = $section->items ?? collect();
            @endphp

            @if($items->count())
                <div class="gallery-page-grid" role="list">
                    @foreach($items as $item)
                        <article class="gallery-page-card" role="listitem">
                            <a class="gallery-page-card-link" href="{{ route('gallery.show', $item->slug) }}">
                                <div class="gallery-page-image">
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}"
                                        alt="{{ $item->localized('title') }}"
                                        loading="lazy"
                                    >
                                </div>

                                <div class="gallery-page-meta">
                                    <div class="gallery-page-item-title">{{ $item->localized('title') }}</div>

                                    @if(!empty($item->localized('short_description')))
                                        <div class="gallery-page-item-desc">
                                            {{ $item->localized('short_description') }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
