@extends('layouts.app')
@section('title', ($staticPage?->title ?? 'Contact'))

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

@section('content')
    <section class="contact-page">
        @if($bgUrl)
            <img class="contact-page__bg" src="{{ $bgUrl }}" alt="" aria-hidden="true">
        @endif

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
            <form class="contact-form" method="post" action="#">
                @csrf

                <div class="contact-form__grid">
                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['first_name'] }}</span>
                        <input class="contact-field__input" type="text" name="first_name" autocomplete="given-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['last_name'] }}</span>
                        <input class="contact-field__input" type="text" name="last_name" autocomplete="family-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['email'] }}</span>
                        <input class="contact-field__input" type="email" name="email" autocomplete="email">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label">{{ $t['phone'] }}</span>
                        <input class="contact-field__input" type="tel" name="phone" autocomplete="tel">
                    </label>

                    <label class="contact-field contact-field--message">
                        <span class="contact-field__label">{{ $t['message'] }}</span>
                        <textarea class="contact-field__textarea" name="message" rows="3" placeholder="{{ $t['message_placeholder'] }}"></textarea>
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button class="contact-form__submit" type="submit">{{ $t['send'] }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection

