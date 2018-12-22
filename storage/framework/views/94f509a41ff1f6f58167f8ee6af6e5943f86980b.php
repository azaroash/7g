<script>
    function showUser(str) {
        if (str==''){
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function () {
            if (this.readyState==4 && this.status==200) {
                document.getElementById("txtHint").innerHTML=this.responseText;
            }
        }
        xmlhttp.open("GET", "RegisterPurchaseController.php?$id="+str, true);
        xmlhttp.send();
    }
</script>

<form method="POST" action="<?php echo e(route('registerPurhcase')); ?>" aria-label="<?php echo e(__('Register Purchase')); ?>">
    <?php echo csrf_field(); ?>

    <div class="form-group row">
        <label for="id" class="col-md-4 col-form-label text-md-right"><?php echo e(__('User ID')); ?></label>

        <div class="col-md-6">
            <input id="userId" type="text" class="form-control<?php echo e($errors->has('userId') ? ' is-invalid' : ''); ?>" name="userId" value="<?php echo e(old('userId')); ?>" required autofocus>

            <?php if($errors->has('userId')): ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($errors->first('userId')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group row">
        <label for="amount" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Amount')); ?></label>

        <div class="col-md-6">
            <input id="amount" type="text" class="form-control<?php echo e($errors->has('amount') ? ' is-invalid' : ''); ?>" name="amount" value="<?php echo e(old('amount')); ?>" required autofocus>

            <?php if($errors->has('amount')): ?>
                <span class="invalid-feedback" role="alert">
                    <strong><?php echo e($errors->first('amount')); ?></strong>
                </span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Register')); ?>

            </button>
        </div>
    </div>
</form>
