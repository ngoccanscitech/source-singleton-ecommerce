<?php
	$seo_image = $seo_image??setting_option('og-image');
	if($seo_image!='')
		$seo_image = asset($seo_image);
?>
<title><?php echo e($seo_title ?? setting_option('seo-title-add')); ?></title>
<link rel="canonical" href="<?php echo e(url('/')); ?>" />
<meta name="robots" content="index, follow">
<meta name="description" content="<?php echo e($seo_description ?? strip_tags(setting_option('seo-description-add'))); ?>">
<meta property="og:title" content="<?php echo e($seo_title ?? setting_option('og-title')); ?>" />
<meta property="og:description" content="<?php echo e($seo_description ?? strip_tags(setting_option('og-description'))); ?>" />
<meta property="og:image" content="<?php echo e($seo_image); ?>" />
<meta property="og:url" content="<?php echo e(url()->current()); ?>" />
<meta property="og:site_name" content="<?php echo e(setting_option('og-site-name')); ?>" /><?php /**PATH C:\wamp64\www\expro\khanhkhoi\resources\views/theme/layouts/seo.blade.php ENDPATH**/ ?>