<?php $__env->startSection('content'); ?>
    <script type="text/javascript">

        $("#input-id").rating();

    </script>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2>Rating</h2></div>
                    <div class="card-body">
                        <?php echo Form::open(['action' => 'HomeController@rateClient', 'method'=>'POST']); ?>

                        <div class="container">

                            <div class="row">

                                <?php $__currentLoopData = $client_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="col-md-2">
                                        <img style="width: 100%" src="storage/logos/<?php echo e($info->logo); ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <h4>Name: <?php echo e($info->companyName); ?> </h4>
                                        <h4>Category: <?php echo e($info->categories); ?> </h4>
                                        <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="<?php echo e($averageRating); ?>" data-size="xs" disabled="">
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div><br>
                            <div class="rating">
                                <p style="font-size: medium;">Use these stars below and rate the service you get:</p>
                                <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="<?php echo e($averageRating); ?>" data-size="xs">
                                <input type="hidden" name="id" required="" value="<?php echo e($client_id); ?>">
                                
                                <br/>
                                <button class="btn btn-lg btn-success">Submit</button>

                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>