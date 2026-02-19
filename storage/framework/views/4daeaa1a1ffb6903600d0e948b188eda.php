<!doctype html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!-- title -->
    <title>Register - ReturnPal</title>
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('assets/img/logo/favicon.png')); ?>" />
    <!-- css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/all-fontawesome.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/animate.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" />
</head>

<body>
    <!-- preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- preloader end -->

    <main class="main">
        <!-- login area -->
        <div class="auth-area">
            <div class="container">
                <div class="col-md-5 mx-auto">
                    <div class="auth-form">
                        <div class="auth-header">
                            <img src="<?php echo e(asset('assets/img/logo/logo.png')); ?>" alt="" />
                            <p>Create your ReturnPal account</p>
                        </div>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('register.post')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-user"></i>
                                    <input name="name" type="text" class="form-control" placeholder="Username" value="<?php echo e(old('name')); ?>" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-envelope"></i>
                                    <input name="email" type="email" class="form-control" placeholder="Your Email" value="<?php echo e(old('email')); ?>" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-key"></i>
                                    <input name="password" type="password" id="password" class="form-control show-pass" placeholder="Your Password" required />
                                    <span class="password-view"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-icon">
                                    <i class="far fa-key"></i>
                                    <input name="password_confirmation" type="password" id="confirm-password" class="form-control show-pass" placeholder="Confirm Password" required />
                                    <span class="password-view"><i class="far fa-eye-slash"></i></span>
                                </div>
                            </div>
                            <div class="auth-btn">
                                <button type="submit" class="theme-btn"><span class="far fa-sign-in"></span> Register</button>
                            </div>
                        </form>
                        <div class="auth-bottom">
                            <p class="auth-bottom-text">Already have an account? <a href="<?php echo e(route('login')); ?>">Login.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login area end -->
    </main>

    <!-- js -->
    <script src="<?php echo e(asset('assets/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\returnpals\resources\views/register.blade.php ENDPATH**/ ?>