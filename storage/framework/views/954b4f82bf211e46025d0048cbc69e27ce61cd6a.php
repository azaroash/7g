<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="col-md-10">
        <a class="btn btn-dark" href="<?php echo e(route('downloadPDF',['download'=>'pdf'])); ?>">Download PDF</a>
        <br><br>
        <table class="table table-striped table-sm" cellspacing="0" width="50%">
            <thead>
            <tr>
                <th>Company Name</th>
                <th>Purchase Amount</th>
                <th>Commission For 7G</th>
                <th>Purchase Date</th>
            </tr>
            </thead>
            <?php $__currentLoopData = $date; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($purchase->companyName); ?></td>
                    <td><?php echo e($purchase->amount); ?></td>
                    <td><?php echo e($purchase->commission); ?></td>
                    <td><?php echo e($purchase->purchase_date); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            
            
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>