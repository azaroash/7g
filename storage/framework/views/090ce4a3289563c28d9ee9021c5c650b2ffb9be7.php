<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row ">
        <div class="col-md-4">
            <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4>Welcome, <?php echo e($name); ?> </h4>
                    </div>
                    <a id="navbarDropdown" class="nav-bar" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="far fa-bell fa-2x"></i><span class="badge badge-light"><h5><?php echo e(auth()->user()->unreadNotifications->count()); ?></h5></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <div class="card">
                            <div class="card-header card-title">
                                <h5><a style="color: #1b1e21" href="<?php echo e(route('userAllMark')); ?>">Mark all as Read</a> </h5>
                            </div>
                            <div class="card-body">
                                <?php $__currentLoopData = auth()->user()->unreadNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a style="background-color: #ced4da" class="dropdown-item" href="<?php echo e(url('notifications/'.$notification->id)); ?>">
                                        <?php echo e($notification->data['data']); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = auth()->user()->readNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item" href="#">
                                        <?php echo e($notification->data['data']); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
        <div class="col-md-8">
            <?php if(isset($message)): ?>
                <h5 class="alert-success"><?php echo e($message); ?></h5>
                
                <a class="btn btn-outline-dark" href="<?php echo e(route('rate')); ?>" id="RateClient">Rate Client</a>
            <?php endif; ?>
        </div>
    </div> <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4>Dashboard</h4></div>
                <div class="card-body">
                    <h5>Your point:</h5>
                    <div class="progress" style="height: 40px;">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: <?php echo e($userPoint/10); ?>%" aria-valuenow="<?php echo e($userPoint); ?>" aria-valuemin="0" aria-valuemax="1000"><h6><?php echo e($userPoint); ?>/1000</h6></div>
                    </div>
                    <ul class="list-group">
                        
                        <li class="list-group-item">Purchase from a nearby stores that are members of 7G
                            to get extra points and more advertisement releases to get another more points.</li>
                        <li class="list-group-item">By viewing more advertisements, you will get more points</li>
                        
                    </ul> <br>
                    <h5>Advertisements:</h5>
                    <div class="row">
                        <?php if(isset($beforePreviousAd)): ?>
                            <div class="col-md-4">
                                
                                <?php $__currentLoopData = $beforePreviousAd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(url('ViewAd/'.$advert->id)); ?>">
                                        <img style="width: 100%" src="storage/logos/<?php echo e($advert->introImage); ?>">
                                        <?php echo e($advert->companyName); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </div>
                        <?php endif; ?>
                        <?php if(isset($previousAd)): ?>
                            <div class="col-md-4">
                                
                                    <?php $__currentLoopData = $previousAd; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(url('ViewAd/'.$advert->id)); ?>">
                                            <img style="width: 100%" src="storage/logos/<?php echo e($advert->introImage); ?>">
                                            <?php echo e($advert->companyName); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </div>
                        <?php endif; ?>
                        <div class="col-md-4">
                            <?php if(isset($advertOne)): ?>
                                <?php $__currentLoopData = $advertOne; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(url('ViewAd/'.$advert->id)); ?>">
                                        <img style="width: 100%" src="storage/logos/<?php echo e($advert->introImage); ?>">
                                        <?php echo e($advert->companyName); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-4">
            <div class="card justify-content-center">
                <div class="card-header"><h4>Purchase History</h4></div>
                <div class="card-body">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th><h5>Date</h5></th>
                                <th><h5>From</h5></th>
                                <th><h5>Amount</h5></th>
                            </tr>
                        </thead>
                        <?php $__currentLoopData = $purchaseHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($history->purchase_date); ?></td>
                                <td><?php echo e($history->companyName); ?></td>
                                <td><?php echo e($history->amount); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table> <br>
                    <?php $__currentLoopData = LaraFlash::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-<?php echo e($notification->type); ?>" role="alert">
                            <h6><?php echo e($notification->title); ?></h6>
                            <p><?php echo e($notification->content); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4>7G member stores</h4></div>
            </div> <br>
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     <strong>Boutiques</strong>
                  </div>
                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div> 
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <strong>Small Shops</strong>
                  </div>
                  <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div>
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                    <strong>Mobile Stores</strong>
                  </div>
                  <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div> 
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                    <strong>Cafes & Restaurants</strong>
                  </div>
                  <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="list-group list-group-flush" id="list-tab" role="tablist">
                            <?php $__currentLoopData = $cafe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cafes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="list-group-item list-group-item-action"><?php echo e($cafes->companyName); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                  </div>
                </div>
            </div> 
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseOne">
                    <strong>Hotels</strong>
                  </div>
                  <div id="collapseFive" class="collapse show" aria-labelledby="headingFive" data-parent="#accordion">
                    <div class="card-body">
                    </div>
                  </div>
                </div>
            </div>                 
        </div>
    </div> <br>
    <div class="row">
        <div class="col-md-4">
            <h5>Sharing 7G to your friends will increase advertisement relases to view:</h5>
        </div>
        <?php echo $__env->make('components.share', ['url' => 'http://praise.com.et/'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>