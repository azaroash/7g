<?php $__env->startSection('content'); ?>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10"> <br><br><br>
                <div class="card-group">
                    <div class="card border-secondary mb-3">
                        

                        <div class="card-body text-secondary">
                            <h4 class="card-title"><b>Login as a Member</b></h4>
                            <p class="card-text">
                                Login in as a member if you have already registered as a member and an activated account.
                                If you didn't activate your account please go back to your email and activate your account
                                by clicking the link.
                            </p> <br>
                            <a class="btn btn-outline-secondary btn-lg" href="<?php echo e(route('login')); ?>"role="button">Login</a>
                        </div>

                    </div>
                    <div class="card border-secondary mb-3">
                        

                        <div class="card-body text-secondary">
                            <h4 class="card-title"><b>Login as a Client</b></h4>
                            <p class="card-text">
                                Login in as a client if you have already registered as a client and an activated account.
                                If you didn't activate your account please go back to your email and activate your account
                                by clicking the link.
                            </p> <br>
                            <a class="btn btn-outline-secondary btn-lg" href="<?php echo e(route('client.login')); ?>"role="button">Login</a>
                        </div>
                    </div>
                </div> <br>
                <a class="btn btn-secondary btn-lg" href="<?php echo e(url('/')); ?>">
                    <?php echo e(__('Return')); ?>

                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>