@extends('layouts.app')
@section('title', ($staticPage?->title ?? 'Contact'))
@section('meta_description', $heroSubtitle ?? '')

@php
    /** @var \App\Models\StaticPage|null $staticPage */
    $content = $staticPage?->localizedContent() ?? [];
    $heroTitle = $content['contact']['hero_title'] ?? null;
    $heroSubtitle = $content['contact']['hero_subtitle'] ?? null;
    $bg = $content['contact']['background_image'] ?? null;
    $bgUrl = $bg ? \Illuminate\Support\Facades\Storage::disk('public')->url($bg) : null;

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
            'sending' => 'Ուղարկվում է…',
        ],
        'ru' => [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'message' => 'Сообщение',
            'message_placeholder' => 'Напишите ваше сообщение',
            'send' => 'Отправить',
            'sending' => 'Отправка…',
        ],
        'en' => [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'message' => 'Message',
            'message_placeholder' => 'Write your message',
            'send' => 'Send Message',
            'sending' => 'Sending…',
        ],
    ];
    $t = $i18n[$locale] ?? $i18n['en'];
@endphp

@section('content')
    <section class="contact-page">
        <style>
            .contact-page .contact-field__label{
                color: rgba(10,10,10,.92) !important;
                font-weight: 700 !important;
                font-size: 16px !important;
            }

            .contact-page .contact-field__input,
            .contact-page .contact-field__textarea{
                color: rgba(5,5,5,.95) !important;
                font-weight: 700 !important;
                font-size: 16px !important;
                background: transparent !important;
            }

            .contact-page .contact-field__input::placeholder,
            .contact-page .contact-field__textarea::placeholder{
                color: rgba(20,20,20,.65) !important;
                font-weight: 600 !important;
            }
        </style>
        @if($bgUrl)
            <img class="contact-page__bg" src="{{ $bgUrl }}" alt="" aria-hidden="true">
        @endif

        <img
            class="contact-page__line"
            src="{{ asset('assets/images/white_line.png') }}"
            alt=""
            loading="lazy"
            decoding="async"
            aria-hidden="true"
        >

        <div class="contact-page__wave-top" aria-hidden="true"></div>
        <div class="contact-page__wave-bottom" aria-hidden="true"></div>
{{--        <div class="contact-page__stroke" aria-hidden="true"></div>--}}

        @if($heroTitle || $heroSubtitle)
            <header class="contact-hero">
                @if($heroTitle)
                    <h1 class="contact-hero__title">{{ $heroTitle }}</h1>
                @endif
                @if($heroSubtitle)
                    <p class="contact-hero__subtitle">{{ $heroSubtitle }}</p>
                @endif
            </header>
        @endif

        <div class="contact-page__inner">
            <form class="contact-form" method="post" action="{{ route('contact.store') }}">
                @csrf

                @if(session('contact_success'))
                    <p class="contact-form__notice contact-form__notice--success" role="status">
                        {{ __('contact.send_success') }}
                    </p>
                @endif

                @if($errors->has('form'))
                    <p class="contact-form__notice contact-form__notice--error" role="alert">
                        {{ $errors->first('form') }}
                    </p>
                @endif

                @if($errors->any() && ! $errors->has('form'))
                    <ul class="contact-form__notice contact-form__notice--error" role="alert">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <div class="contact-form__grid">
                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['first_name'] }}</span>
                        <input class="contact-field__input" type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required>
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['last_name'] }}</span>
                        <input class="contact-field__input" type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required>
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['email'] }}</span>
                        <input class="contact-field__input" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['phone'] }}</span>
                        <input class="contact-field__input" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" maxlength="25" pattern="^[\+]?[0-9\s\-\(\)\.]{7,25}$" title="{{ __('contact.phone_invalid') }}" required>
                    </label>

                    <label class="contact-field contact-field--message">
                        <span class="contact-field__label">{{ $t['message'] }}</span>
                        <textarea class="contact-field__textarea" name="message" rows="3" placeholder="{{ $t['message_placeholder'] }}" required>{{ old('message') }}</textarea>
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button
                        class="contact-form__submit"
                        type="submit"
                        data-label="{{ $t['send'] }}"
                        data-sending="{{ $t['sending'] }}"
                    >{{ $t['send'] }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.querySelector('.contact-page .contact-form');
    if (!form) return;

    const btn = form.querySelector('.contact-form__submit');
    if (!btn) return;

    form.addEventListener('submit', function () {
        if (!form.reportValidity()) return;
        if (btn.disabled) return;

        btn.disabled = true;
        btn.setAttribute('aria-busy', 'true');
        btn.textContent = btn.dataset.sending || btn.textContent;
    });

    window.addEventListener('pageshow', function (event) {
        if (!event.persisted) return;
        btn.disabled = false;
        btn.removeAttribute('aria-busy');
        btn.textContent = btn.dataset.label || btn.textContent;
    });
})();
</script>
@endpush
