<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/login/images/icons/favicon.ico')); ?>"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/vendor/bootstrap/css/bootstrap.min.css')); ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')); ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')); ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/vendor/animate/animate.css')); ?>">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/vendor/css-hamburgers/hamburgers.min.css')); ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/vendor/animsition/css/animsition.min.css')); ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/vendor/select2/select2.min.css')); ?>">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/vendor/daterangepicker/daterangepicker.css')); ?>">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/css/util.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/login/css/main.css')); ?>">
<!--===============================================================================================-->
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100" style="background-image: url('<?php echo e(asset('assets/login/images/bg-01.jpg')); ?>');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41">
                    Admin Login
                </span>
                <form action="<?php echo e(route('admin.login')); ?>" method="POST" class="login100-form validate-form p-b-33 p-t-5">
                    <?php echo csrf_field(); ?>
                    <div class="wrap-input100 validate-input" data-validate = "Enter username">
                        <input class="input100 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="email" id="email" placeholder="Username or Email" required autofocus>
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    

    <div id="dropDownSelect1"></div>
    
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/vendor/jquery/jquery-3.2.1.min.js')); ?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/vendor/animsition/js/animsition.min.js')); ?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/vendor/bootstrap/js/popper.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/login/vendor/bootstrap/js/bootstrap.min.js')); ?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/vendor/select2/select2.min.js')); ?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/vendor/daterangepicker/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/login/vendor/daterangepicker/daterangepicker.js')); ?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/vendor/countdowntime/countdowntime.js')); ?>"></script>
<!--===============================================================================================-->
    <script src="<?php echo e(asset('assets/login/js/main.js')); ?>"></script>

</body>
</html><?php /**PATH /home/admin/domains/exproweb.com/public_html/nhathuockhanhkhoi/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>