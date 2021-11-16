 
<?php $__env->startSection('wrapper'); ?>
<div class="page-wrapper">
    <div class="page-content">
<div style="text-align:center">
<h4>Pdf viewer testing</h4>
   <h1>PDF Example with iframe</h1>
    <iframe src="<?php echo e(url('uploads/pdf/'.$pdf_name), false); ?>" frameborder="0" scrolling="no"width="100%" height="500px">
    </iframe>
  </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<script type="text/javascript">


</script>
<?php $__env->stopSection(); ?> 



<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/students/pdfindex.blade.php ENDPATH**/ ?>