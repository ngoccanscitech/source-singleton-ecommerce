
<?php $__env->startSection('seo'); ?>
<title><?php echo e(Helpers::get_option_minhnn('seo-title-add')); ?></title>
<link rel="canonical" href="<?php echo e(url('/')); ?>" />
<meta name="robots" content="index, follow">
<meta name="description" content="<?php echo e(Helpers::get_option_minhnn('seo-description-add')); ?>">
<meta property="og:title" content="<?php echo e(Helpers::get_option_minhnn('og-title')); ?>" />
<meta property="og:description" content="<?php echo e(Helpers::get_option_minhnn('og-description')); ?>" />
<meta property="og:image" content="<?php echo e(Helpers::get_option_minhnn('og-image') ? url(Helpers::get_option_minhnn('og-image')) : ''); ?>" />

<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta property="og:site_name" content="<?php echo e(Helpers::get_option_minhnn('og-site-name')); ?>" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!--=================================
error -->
<section class="space-ptb bg-holder my-5">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6">
        <div class="error-404 text-center">
          <h1>404</h1>
          <strong>Trang bạn tìm kiếm không tồn tại</strong>
          <span>Quay về <a href="<?php echo e(url('/')); ?>"> Trang chủ </a></span>
        </div>
      </div>
    </div>
  </div>
</section>
<!--=================================
error -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/errors/404.blade.php ENDPATH**/ ?>