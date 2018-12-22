<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-secondary mb-3">
                <div class="card-header"><h4><strong><?php echo e(__('Register As Client')); ?></strong></h4></div>
                
                <div class="card-body">
                    
                    <form method="POST" action="<?php echo e(route('client.register.submit')); ?>" aria-label="<?php echo e(__('Register')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="form-group row">
                            <label for="companyName" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Company Name')); ?></label>

                            <div class="col-md-6">
                                <input id="companyName" type="text" class="form-control<?php echo e($errors->has('companyName') ? ' is-invalid' : ''); ?>" name="companyName" value="<?php echo e(old('companyName')); ?>" required autofocus>

                                <?php if($errors->has('companyName')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('companyName')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tradeName" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Trade Name')); ?></label>

                            <div class="col-md-6">
                                <input id="tradeName" type="text" class="form-control<?php echo e($errors->has('tradeName') ? ' is-invalid' : ''); ?>" name="tradeName" value="<?php echo e(old('tradeName')); ?>" autofocus>

                                <?php if($errors->has('tradeName')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('tradeName')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Phone Number')); ?></label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone')); ?>" required autofocus>

                                <?php if($errors->has('phone')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Location')); ?></label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control<?php echo e($errors->has('location') ? ' is-invalid' : ''); ?>" name="location" value="<?php echo e(old('location')); ?>" required autofocus>

                                <?php if($errors->has('location')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('location')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Category')); ?></label>

                            <div class="col-md-6">
                                <select name="categories" class="form-control"required autofocus>
                                    <option value="boutique">Boutique</option>
                                    <option value="cafeRestaurant">Cafe & Restaurant</option>
                                    <option value="hotel">Hotel</option>
                                    <option value="mobile">Mobile Store</option>
                                    <option value="shop">Mini shops</option>
                                </select> 
                            </div>
                        </div>
                        
                         <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Logo')); ?></label>

                            <div class="col-md-6">
                                <input type="file" class="form-control-file" id="logo" name="logo">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>