@php
    /** @var \App\Models\CollectionSection $section */
    $items = $section->items ?? collect();
    $coverItem = $items->first();
@endphp

@if($coverItem && !empty($coverItem->image))
    <article class="gallery-section-card" role="listitem">
        <a class="gallery-section-card-link" href="{{ route('collection.section', $section) }}" aria-label="{{ $section->localized('title') }}">
            <div class="gallery-section-card-image">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverItem->image) }}"
                    alt="{{ $section->localized('title') }}"
                    loading="lazy"
                />
            </div>

            <div class="gallery-section-card-meta">
                <div class="gallery-section-card-title">
                    “{{ strtoupper((string) ($section->localized('title') ?? 'Collection')) }}”
                </div>

                @php
                    $desc = trim((string) ($section->localized('description') ?? ''));
                @endphp

                @if($desc !== '')
                    <div class="gallery-section-card-desc">
                        {{ $desc }}
                    </div>
                @endif
            </div>
        </a>
    </article>
@endif

