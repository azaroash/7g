<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-secondary mb-3">
                <div class="card-header"><h4><strong><?php echo e(__('Register As Member')); ?></strong></h4></div>
                
                <div class="card-body text-secondary">
                    
                    <form method="POST" action="<?php echo e(route('register')); ?>" aria-label="<?php echo e(__('Register')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right"><?php echo e(__('First Name')); ?></label>

                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control<?php echo e($errors->has('firstName') ? ' is-invalid' : ''); ?>" name="firstName" value="<?php echo e(old('firstName')); ?>" required autofocus>

                                <?php if($errors->has('firstName')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('firstName')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastName" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Last Name')); ?></label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control<?php echo e($errors->has('lastName') ? ' is-invalid' : ''); ?>" name="lastName" value="<?php echo e(old('lastName')); ?>" required autofocus>

                                <?php if($errors->has('lastName')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('lastName')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Phone Number')); ?></label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone')); ?>" required>

                                <?php if($errors->has('phone')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><?php echo e(__('E-Mail Address')); ?></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Password')); ?></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-outline-secondary btn-lg">
                                    <?php echo e(__('Register')); ?>

                                </button>
                                <a class="btn btn-outline-secondary btn-lg" href="<?php echo e(route('SelectRegistration')); ?>">
                                    <?php echo e(__('Return')); ?>

                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    export default {
        data() {
            return {
                firstName: "",
                email: ""
            }
        },
        created() {
            this.listenEvent();
        },
        methods: {
            listenEvent() {
                Echo.channel('users')
                    .listen('UserCreated', user => {
                        if (! ('Notification' in window)) {
                            alert('Web Notification is not supported');
                            return;
                        }

                        Notification.requestPermission( permission => {
                            let notification = new Notification('New user alert!', {
                                body: user.firstName
                            });

                            notification.onclick = () => {
                                window.open(window.location.href);
                            };
                        });
                    });
            }
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>