<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php
        $seoTitle = trim((string) view()->yieldContent('title', config('app.name', 'Painter App')));
        $seoDescription = trim((string) view()->yieldContent('meta_description', ''));
        if ($seoDescription === '') {
            $seoDescription = trim((string) view()->yieldContent('description', ''));
        }

        $seoCanonical = trim((string) view()->yieldContent('canonical', url()->current()));
        $seoRobots = trim((string) view()->yieldContent('robots', 'index,follow'));
        $seoOgImage = trim((string) view()->yieldContent('og_image', ''));

        if (mb_strlen($seoDescription) > 180) {
            $seoDescription = mb_substr($seoDescription, 0, 177) . '...';
        }
    ?>

    <title><?php echo e($seoTitle); ?></title>
    <meta name="description" content="<?php echo e($seoDescription); ?>">
    <meta name="robots" content="<?php echo e($seoRobots); ?>">
    <link rel="canonical" href="<?php echo e($seoCanonical); ?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($seoTitle); ?>">
    <meta property="og:description" content="<?php echo e($seoDescription); ?>">
    <meta property="og:url" content="<?php echo e($seoCanonical); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($seoOgImage !== ''): ?>
        <meta property="og:image" content="<?php echo e($seoOgImage); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($seoTitle); ?>">
    <meta name="twitter:description" content="<?php echo e($seoDescription); ?>">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($seoOgImage !== ''): ?>
        <meta name="twitter:image" content="<?php echo e($seoOgImage); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,400,500,600|inter:200,300,400,500" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/home.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/gallery.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/articles.css')); ?>" />
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('includes.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo $__env->make('includes.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH /home/balasona/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>