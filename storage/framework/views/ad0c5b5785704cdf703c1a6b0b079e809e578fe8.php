 
 <?php $__env->startSection('wrapper'); ?>
     <div class="page-wrapper">
         <div class="page-content">
             <!--breadcrumb-->
             <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                 <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('lang.fee_card_printing'); ?></div>
                 <div class="ps-3">
                     <nav aria-label="breadcrumb">
                         <ol class="breadcrumb mb-0 p-0">
                             <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                             </li>
                             <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('lang.fee_card_printing'); ?></li>
                         </ol>
                     </nav>
                 </div>
             </div>
             <!--end breadcrumb-->
            
            <?php echo Form::open(['url' => action('SchoolPrinting\FeeCardPrintController@classWisePrintPost'), 'method' => 'post', 'class'=>'needs-validation was-validated','novalidate'.'id' =>'search_student_fee' ,'files' => true]); ?>


             <div class="card">

                 <div class="card-body">
                     <h6 class="card-title text-primary"><?php echo app('translator')->get('lang.select_ground'); ?></h6>
                       <hr>
                     <div class="row m-0">
                         <div class="col-md-3 p-2 ">
                             <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                             <?php echo Form::select('campus_id', $campuses, null, ['class' => 'form-select select2 global-campuses', 'required', 'id' => 'students_list_filter_campus_id', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]); ?>

                         </div>
                         <div class="col-md-3 p-2">
                             <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                             <?php echo Form::select('class_id', [], null, ['class' => 'form-select select2 global-classes', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all'), 'id' => 'students_list_filter_class_id']); ?>

                         </div>
                         <div class="col-md-3 p-2">
                             <?php echo Form::label('class_section.sections', __('class_section.sections') . ':*'); ?>

                             <?php echo Form::select('class_section_id', [], null, ['class' => 'form-select select2 global-class_sections', 'id' => 'students_list_filter_class_section_id', 'style' => 'width:100%', 'placeholder' => __('messages.all')]); ?>

                         </div>
                         <div class="col-md-3 p-2">
                             <?php echo Form::label('lang.fee_month', __('lang.fee_month') . ':*'); ?>

                             <?php echo Form::select('month_id',__('lang.months'),$now_month, ['class' => 'form-select select2', 'required', 'style' => 'width:100%']); ?>

                         </div>
                     </div>
                      <div class="d-lg-flex align-items-center mt-4 gap-3">
                         <div class="ms-auto"><button class="btn btn-primary radius-30 mt-2 mt-lg-0"
                                 type="submit">
                                 <i class="fas fa-filter"></i><?php echo app('translator')->get('lang.filter'); ?></button></div>
                     </div>
                 </div>
             </div>


            <?php echo e(Form::close(), false); ?>




         </div>
     </div>
   
 <?php $__env->stopSection(); ?>

 <?php $__env->startSection('javascript'); ?>

     <script type="text/javascript">
         $(document).ready(function() {



         });
     </script>
 <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/school-printing/feecard/create.blade.php ENDPATH**/ ?>