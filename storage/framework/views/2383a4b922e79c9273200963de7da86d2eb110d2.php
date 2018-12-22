<?php $__env->startSection('content'); ?>

<script>
//    function showUser(str) {
//        if (str==''){
//            document.getElementById("txtHint").innerHTML="";
//            return;
//        }
//        if (window.XMLHttpRequest) {
//            xmlhttp = new XMLHttpRequest();
//        }
//        else {
//            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//        }
//        xmlhttp.onreadystatechange=function () {
//            if (this.readyState==4 && this.status==200) {
//                document.getElementById("txtHint").innerHTML=this.responseText;
//            }
//        }
//        xmlhttp.open("GET", "RegisterPurchaseController.php?$id="+str, true);
//        xmlhttp.send();
//    }
//
//    $(function () {
//        $('[data-toggle="popover"]').popover()
//    })
//
//    jQuery(document).ready(function() {
//        jQuery('.hover').popover({
//            title: popoverContent,
//            html: true,
//            placement: 'right',
//            trigger: 'hover'
//        });
//    });
//
//    function popoverContent() {
//        var content = '';
//        var element = $(this);
//        var id = element.attr("id");
//        $.ajax({
//            url: "ClientController.php",
//            method: "POST",
//            async: false,
//            data:{
//                id : id
//            },
//            dataType: "JSON",
//            success:function(data){
//                content = $("#popover_html").html();
//                content = content.replace(/p_fname/g, data.firstName);
//                content = content.replace(/p_lname/g, data.lastName);
//                content = content.replace(/p_phone/g, data.phone);
//            }
//        });
//        return content;
//    }
    
       
          
          
              
                 
                 
                 
                 
                 
                     
                 
              
          
          
              
          
       
    

</script>

<div class="container">
    <div class="well">
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <img style="width: 100%" src="storage/logos/<?php echo e($logo); ?>">
                
            </div>
            <div class="col-md-4 col-sm-4">
                <h1><?php echo e($name); ?></h1>
                <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="<?php echo e($averageRating); ?>" data-size="xs" disabled="">
                <a id="navbarDropdown" class="nav-bar" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="far fa-bell fa-2x"></i><span class="badge badge-light"><h5><?php echo e(auth()->user()->notifications->count()); ?></h5></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <?php $__currentLoopData = auth()->guard('client')->user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item" href="#">
                            <?php echo e($notification->data['data']); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div> <br>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h5>Register Purchase</h5></div>
                    <?php if($message = Session::get('success')): ?>
                        <div class="alert alert-success">
                            <p><?php echo e($message); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($message = Session::get('warning')): ?>
                        <div class="alert alert-warning">
                            <p><?php echo e($message); ?></p>
                        </div>
                    <?php endif; ?>
                <div class="card-body">
                    
                        <?php echo Form::open(['action' => 'ClientController@store', 'method'=>'POST']); ?>


                        <div class="form-group row col-md-8">
                            
                            <?php echo e(Form::text ('userId', '', ['id' => 'search', 'class'=>'form-control', 'placeholder'=>'Enter Member ID'])); ?>

                            

                        </div>

                        <div id="result">
                                
                                <div class="table-responsive">
                                    
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Phone number</th>
                                                <th>Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                        </div> <br>
                        <div class="form-group row col-md-8">
                            
                            <?php echo e(Form::text ('amount', '', ['class'=>'form-control', 'placeholder'=>'Enter the amount'])); ?>

                        </div>
    
                        <div class="form-group row col-md-8">
                            <?php echo e(Form::submit ('Register', ['class'=>'btn btn-dark', 'name'=>'RegisterIt'])); ?>

                        </div>
    
                        <?php echo Form::close(); ?>

                    
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h5>Sales History</h5></div>
                <div class="card-body">

                    
                        
                            
                                
                                
                                
                            
                        
                        

                            
                                
                                
                                
                                
                            

                        
                    
                    <div class="rTable table-striped table-sm">
                        <div class="rTableRow">
                            <div class="rTableHead"><strong>Date</strong></div>
                            <div class="rTableHead"><strong>Amount</strong></div>
                            <div class="rTableHead"><strong>Commission</strong></div>
                        </div>
                        <?php $__currentLoopData = $purchaseHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="rTableRow">
                                <div class="rTableCell"><?php echo e($history->purchase_date); ?></div>
                                <div class="rTableCell"><?php echo e($history->amount); ?></div>
                                <div class="rTableCell"><?php echo e($history->commission); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h5>Generate Sales Report</h5></div>
                <div class="card-body">
                    <?php echo Form::open(['action' => 'ClientController@viewPDF', 'method'=>'GET']); ?>

                        <div class="form-group row col-md-10">
                            <?php echo e(Form::label('month', 'Select Month')); ?> <br>
                            <?php echo e(Form::selectMonth ('month','', ['class' => 'form-control'] )); ?>

                        </div>

                        <div class="form-group row col-md-10">
                            <?php echo e(Form::submit ('Generate', ['class'=>'btn btn-dark', 'name'=>'generate'])); ?>

                        </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div> <br>
    <div class="row">
        <p>Share 7G to your friends:</p>
        <?php echo $__env->make('components.share', ['url' => 'https://www.bbc.com/sport/football'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>
<script>
    $(document).ready(function(){

        fetch_customer_data();

        function fetch_customer_data(query = '')
        {
            $.ajax({
                url:"<?php echo e(route('getUserData')); ?>",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('tbody').html(data.table_data);
                    //$('#total_records').text(data.total_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_customer_data(query);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>