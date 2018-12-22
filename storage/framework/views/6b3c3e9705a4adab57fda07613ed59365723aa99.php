<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
                <?php if(isset($advert)): ?>
                    <?php $__currentLoopData = $advert; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6">
                            <img style="width: 100%" src="storage/logos/<?php echo e($ad->bigImage); ?>">
                        </div>
                        <div class="col-md-6">
                            <p>
                                <?php echo e($ad->description); ?>

                            </p>
                            <a class="btn btn-outline-secondary btn-lg" href="<?php echo e(route('viewAdDone')); ?>"role="button">Done</a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>