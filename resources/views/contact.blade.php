@extends('layouts.app')
@section('title', ($staticPage?->title ?? 'Contact'))

@php
    /** @var \App\Models\StaticPage|null $staticPage */
    $content = $staticPage?->localizedContent() ?? [];
    $bg = $content['contact']['background_image'] ?? null;
    $bgUrl = $bg ? \Illuminate\Support\Facades\Storage::disk('public')->url($bg) : null;
@endphp

@section('content')
    <section class="contact-page">
        @if($bgUrl)
            <img class="contact-page__bg" src="{{ $bgUrl }}" alt="" aria-hidden="true">
        @endif

        <div class="contact-page__wave-top" aria-hidden="true"></div>
        <div class="contact-page__wave-bottom" aria-hidden="true"></div>
{{--        <div class="contact-page__stroke" aria-hidden="true"></div>--}}

        <div class="contact-page__inner">
            <form class="contact-form" method="post" action="#">
                @csrf

                <div class="contact-form__grid">
                    <label class="contact-field">
                        <span class="contact-field__label">First Name</span>
                        <input class="contact-field__input" type="text" name="first_name" autocomplete="given-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">Last Name</span>
                        <input class="contact-field__input" type="text" name="last_name" autocomplete="family-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">Email</span>
                        <input class="contact-field__input" type="email" name="email" autocomplete="email">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">Phone Number</span>
                        <input class="contact-field__input" type="tel" name="phone" autocomplete="tel">
                    </label>

                    <label class="contact-field contact-field--message">
                        <span class="contact-field__label">Message</span>
                        <textarea class="contact-field__textarea" name="message" rows="3" placeholder="Write your message"></textarea>
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button class="contact-form__submit" type="submit">Send Message</button>
                </div>
            </form>
        </div>
    </section>
@endsection

