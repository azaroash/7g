<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10"> <br><br><br>
                <div class="card-group">
                    <div class="card border-secondary mb-3">
                        

                            <div class="card-body text-secondary">
                                <h4 class="card-title"><b>Register as a Member</b></h4>
                                <p class="card-text">
                                    By registering as a member you can get the money you spent to buy goods from a 7G member
                                    retail shops and services. Members are generally consumers of goods and services.
                                </p> <br>
                                <a class="btn btn-outline-secondary btn-lg" href="<?php echo e(route('register')); ?>" role="button">Register Now!</a>
                            </div>

                    </div>
                    <div class="card border-secondary mb-3">
                        

                        <div class="card-body text-secondary">
                            <h4 class="card-title"><b>Register as a Client</b></h4>
                            <p class="card-text">
                                You register as a client if you have a retail store or a service that you give
                                for customers. By registering as a client, members of 7G will be able to shop from
                                your store more often. And you will get more customers each and every day.
                             </p> <br>
                            <a class="btn btn-outline-secondary btn-lg" href="<?php echo e(route('client.register')); ?>"role="button">Register Now!</a>
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