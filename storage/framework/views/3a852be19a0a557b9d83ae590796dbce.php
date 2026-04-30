<?php $__env->startSection('title', ($staticPage?->title ?? 'Contact')); ?>
<?php $__env->startSection('meta_description', $heroSubtitle ?? ''); ?>

<?php
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
?>

<?php $__env->startSection('content'); ?>
    <section class="contact-page">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bgUrl): ?>
            <img class="contact-page__bg" src="<?php echo e($bgUrl); ?>" alt="" aria-hidden="true">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="contact-page__wave-top" aria-hidden="true"></div>
        <div class="contact-page__wave-bottom" aria-hidden="true"></div>


        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroTitle || $heroSubtitle): ?>
            <header class="contact-hero">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroTitle): ?>
                    <h1 class="contact-hero__title"><?php echo e($heroTitle); ?></h1>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($heroSubtitle): ?>
                    <p class="contact-hero__subtitle"><?php echo e($heroSubtitle); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </header>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="contact-page__inner">
            <form class="contact-form" method="post" action="#">
                <?php echo csrf_field(); ?>

                <div class="contact-form__grid">
                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['first_name']); ?></span>
                        <input class="contact-field__input" type="text" name="first_name" autocomplete="given-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['last_name']); ?></span>
                        <input class="contact-field__input" type="text" name="last_name" autocomplete="family-name">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['email']); ?></span>
                        <input class="contact-field__input" type="email" name="email" autocomplete="email">
                    </label>

                    <label class="contact-field">
                        <span class="contact-field__label"><?php echo e($t['phone']); ?></span>
                        <input class="contact-field__input" type="tel" name="phone" autocomplete="tel">
                    </label>

                    <label class="contact-field contact-field--message">
                        <span class="contact-field__label"><?php echo e($t['message']); ?></span>
                        <textarea class="contact-field__textarea" name="message" rows="3" placeholder="<?php echo e($t['message_placeholder']); ?>"></textarea>
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button class="contact-form__submit" type="submit"><?php echo e($t['send']); ?></button>
                </div>
            </form>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/balasona/public_html/resources/views/contact.blade.php ENDPATH**/ ?>