<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo e(setting_option('company_name')); ?></title>
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset(setting_option('favicon'))); ?>" />

    <!-- SEO meta -->
    <?php echo $__env->yieldContent('seo'); ?>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gideon+Roman&display=swap" rel="stylesheet">
    <link rel='stylesheet' id='fontawesome-css' href='//use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1' type='text/css' media='all' />
    <!-- Plugins CSS -->
    <!-- <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/plugins.css')); ?>"> -->
    <!-- <link rel="stylesheet" href="<?php echo e(asset($templateFile .'/plugins/owl-carousel/assets/owl.carousel.min.css')); ?>"> -->
    <!-- <link rel="stylesheet" href="<?php echo e(asset($templateFile .'/plugins/owl-carousel/assets/owl.theme.default.min.css')); ?>"> -->
    <link rel="stylesheet" href="<?php echo e(asset($templateFile .'/plugins/fancybox/fancybox.css')); ?>">
    <!-- Bootstap CSS -->
    <!-- <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/bootstrap.min.css')); ?>"> -->
    <link rel="stylesheet" href="<?php echo e(asset('css/sweetalert2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($templateFile .'/js/vendor/owl-carousel/assets/owl.carousel.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($templateFile .'/js/vendor/owl-carousel/assets/owl.theme.default.min.css')); ?>">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/simplebar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/tiny-slider.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/drift-basic.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/theme.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/style.css?ver='. time())); ?>">
    <!-- <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/responsive.css')); ?>"> -->
    <link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/customer.css')); ?>">
    
    <?php echo htmlspecialchars_decode(setting_option('header')); ?>

    
    <?php echo $__env->yieldPushContent('head-style'); ?>

    <?php echo $__env->yieldPushContent('head-script'); ?>
</head>

<body>
    <main class="page-wrapper">

    </main>

        <?php $headerMenu = Menu::getByName('Menu-main'); ?>
        
        <?php echo $__env->make($templateFile .'.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        

        <?php echo $__env->yieldContent('content'); ?>

        <?php echo $__env->make($templateFile .'.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Including Jquery -->
        <script src="<?php echo e(asset($templateFile .'/js/jquery.min.js')); ?> "></script>
        <script src="/js/axios.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script src="/js/jquery.validate.min.js"></script>
        <script src="<?php echo e(asset($templateFile .'/js/simplebar.min.js')); ?> "></script>
        <script src="<?php echo e(asset($templateFile .'/js/vendor/owl-carousel/owl.carousel.min.js')); ?>"></script>
        <script src="<?php echo e(asset($templateFile .'/js/bootstrap.bundle.min.js')); ?> "></script>
        <script src="<?php echo e(asset($templateFile .'/js/tiny-slider.js')); ?> "></script>
        <script src="<?php echo e(asset($templateFile .'/js/smooth-scroll.polyfills.min.js')); ?> "></script>
        <script src="<?php echo e(asset($templateFile .'/js/Drift.min.js')); ?> "></script>
        <script src="<?php echo e(asset($templateFile .'/js/theme.min.js')); ?>"></script>

        <script src="<?php echo e(asset($templateFile .'/js/custom.js?ver=1.61')); ?>"></script>

        <?php echo $__env->yieldPushContent('after-footer'); ?>
</body>

</html>
<?php /**PATH /home/admin/domains/exproweb.com/public_html/nhathuockhanhkhoi/resources/views/theme/layouts/index.blade.php ENDPATH**/ ?>