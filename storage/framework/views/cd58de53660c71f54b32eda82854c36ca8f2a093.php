<!DOCTYPE html>
<html>
<head>
    <title><?php echo e(config('app.name', 'Leb Statistics')); ?></title>
</head>

    <body style="font-family: arial; background-color: #F7F7F7; margin: 0px; padding: 0px;">


        <div style="width: 600px; margin:auto; background-color: #F7F7F7; padding-bottom: 30px; border-top-left-radius: 10px; border-top-right-radius: 10px; box-shadow: 0px 0px 10px 1px #00000021; margin-bottom: 30px;">

            <div style="width: 100%;padding: 20px 0px;text-align: center;background: #73879C;border-top-left-radius: 0;border-top-right-radius: 0;">
                <div style="font-size: 25px;color:#fff;line-height: 100%;margin-bottom: 0px;text-transform: uppercase;letter-spacing: 4px;">
                   <?php echo e(config('app.name', 'Leb Statistics')); ?>

                </div>


            </div>

            <?php echo $__env->yieldContent('content'); ?>

        </div>

        <div style="text-align: center; font-size: 12px; color: #707070; line-height: 145%; margin-bottom: 30px;">

            Email sent by <a href="<?php echo e(url("/")); ?>" target="_blank" style="text-decoration: none;"><span style="color: #73879C"><?php echo e(config('app.name', 'Leb Statistics')); ?></span></a>

            <br>

            Copyright &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Leb Statistics')); ?> - All Rights Reserved.

        </div>

    </div>



</body>

</html><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/emails/common.blade.php ENDPATH**/ ?>