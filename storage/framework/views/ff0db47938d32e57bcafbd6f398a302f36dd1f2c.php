 
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
             <?php echo Form::open(['url' => action('SchoolPrinting\FeeCardPrintController@classWisePrintPost'), 'method' => 'post', 'class' => '', 'novalidate' . 'id' => 'search_student_fee', 'files' => true]); ?>


             <div class="card">

                 <div class="card-body">
                     <h6 class="card-title text-primary"><?php echo app('translator')->get('lang.select_ground'); ?></h6>
                     <hr>
                     <div class="row m-0">
                         <div class="col-md-3 p-2 ">
                             <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                             <?php echo Form::select('campus_id', $campuses, $campus_id, ['class' => 'form-select select2 global-campuses', 'required', 'id' => 'students_list_filter_campus_id', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]); ?>

                         </div>
                         <div class="col-md-3 p-2">
                             <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                             <?php echo Form::select('class_id', $classes, $class_id, ['class' => 'form-select select2 global-classes', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all'), 'id' => 'students_list_filter_class_id']); ?>

                         </div>
                         <div class="col-md-3 p-2">
                             <?php echo Form::label('class_section.sections', __('class_section.sections') . ':*'); ?>

                             <?php echo Form::select('class_section_id', $sections, $class_section_id, ['class' => 'form-select select2 global-class_sections', 'id' => 'students_list_filter_class_section_id', 'style' => 'width:100%', 'placeholder' => __('messages.all')]); ?>

                         </div>
                           <div class="col-md-3 p-2">
                             <?php echo Form::label('lang.fee_month', __('lang.fee_month') . ':*'); ?>

                             <?php echo Form::select('month_id',__('lang.months'),$month_id, ['class' => 'form-select select2', 'required', 'style' => 'width:100%']); ?>

                         </div>
                     </div>
                     <div class="d-lg-flex align-items-center mt-4 gap-3">
                         <div class="ms-auto"><button class="btn btn-primary radius-30 mt-2 mt-lg-0" type="submit">
                                 <i class="fas fa-filter"></i><?php echo app('translator')->get('lang.filter'); ?></button></div>
                     </div>
                 </div>
             </div>


             <?php echo e(Form::close(), false); ?>

             <div class="row">
                 <div class="col-lg-12">
                     <div class="card bg-warning bg-gradient">
                         <div class="card-body">
                             <div class="d-flex align-items-center">
                                 <div class="font-35 text-dark"><i class="bx bx-info-circle"></i>
                                 </div>
                                 <div class="ms-3">
                                     <h6 class="mb-0 text-dark">Warning / Disclaimer</h6>
                                     <div class="text-dark">If Someone have No Fee On Your Selected Inofrmation The Students Will Be Automaticly Discarded</div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <?php if(isset($students)): ?>
                     <?php echo Form::open(['url' => action('SchoolPrinting\FeeCardPrintController@classWisePrint'), 'method' => 'post', 'class' => '', '' . 'id' => 'store_student_fee', 'files' => true]); ?>

                    <input type="hidden" name="month_id" value="<?php echo e($month_id, false); ?>">
                     <div class="row">
                         <div class="col-lg-4">
                             <div class="card ">
                                 <div class="card-body">
                                     <table id="table_id_table" class="table table-condensed table-striped "
                                         id="admisssion-table">
                                         <thead>
                                             <tr>
                                                 <th class="text-center"><?php echo app('translator')->get('lang.fee_heads'); ?></th>
                                                 <th class="text-center"><?php echo app('translator')->get('lang.enable'); ?></th>
                                                 <th class="text-center "><?php echo app('translator')->get('lang.amount'); ?></th>
                                             </tr>
                                         </thead>
                                         <tbody>

                                             <?php $__currentLoopData = $fee_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <tr>
                                                     <td class="text-center">
                                                         <div class="mt-2"><?php echo e($fee_head->description, false); ?></div>
                                                     </td>
                                                     <td class="text-center">

                                                         <?php echo Form::checkbox('fee_heads[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 fee-head-check']); ?> </td>


                                                     </td>

                                                     <td class="text-center ">
                                                         <input name="fee_heads[<?php echo e($loop->iteration, false); ?>][amount]"
                                                             type="number" value=<?php echo e(number_format($fee_head->amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?>

                                                             class="form-control amount" value="0">
                                                         <input type="hidden"
                                                             name="fee_heads[<?php echo e($loop->iteration, false); ?>][fee_head_id]"
                                                             value="<?php echo e($fee_head->id, false); ?>">

                                                     </td>
                                                 </tr>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         <tfoot>
                                             <tr>
                                                 <th colspan="2" class="text-center">Total</th>
                                                 <td><span class="final_total">0</span></td>
                                                 <input type="hidden" name="final_total" id="final_total" value="0">
                                             </tr>
                                         </tfoot>
                                         </tbody>
                                     </table>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-8">

                             <div class="card">
                                 <div class="card-body">
                                     <div class="table-responsive">
                                         <table class="table mb-0" width="100%" id="students_table">
                                             <thead class="table-light" width="100%">
                                                 <tr>
                                                     

                                                     <th> <input type="checkbox" id="checkAll"
                                                             class="common-checkbox form-check-input mt-2" name="checkAll">
                                                         <label for="checkAll"><?php echo app('translator')->get('lang.all'); ?></label>
                                                     </th>
                                                     <th><?php echo app('translator')->get('lang.student_name'); ?></th>
                                                     <th><?php echo app('translator')->get('lang.father_name'); ?></th>
                                                     <th><?php echo app('translator')->get('lang.roll_no'); ?></th>
                                                     <th><?php echo app('translator')->get('lang.current_class'); ?></th>
                                                     <th><?php echo app('translator')->get('lang.gender'); ?></th>
                                                 </tr>
                                             </thead>
                                             <tbody class="">
                                                 <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <tr>
                                                         <td>
                                                             <input type="checkbox" id="student.<?php echo e($student->id, false); ?>"
                                                                 class="common-checkbox form-check-input mt-2"
                                                                 name="student_checked[]" value="<?php echo e($student->id, false); ?>" }}>
                                                             <label for="student.<?php echo e($student->id, false); ?>"></label>
                                                         </td>
                                                         <td><?php echo e(ucwords($student->student_name), false); ?>

                                                             <input type="hidden" name="id[]" value="<?php echo e($student->id, false); ?>">
                                                         </td>
                                                         <td><?php echo e(ucwords($student->father_name), false); ?></td>
                                                         <td><?php echo e($student->roll_no, false); ?></td>
                                                         <td><?php echo e($student->current_class, false); ?></td>
                                                         <td><?php echo e(ucwords($student->gender), false); ?></td>
                                                     </tr>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </tbody>
                                             <?php if($students->count() > 0): ?>
                                                 <tr>
                                                     <td colspan="7">
                                                         <div class="text-center">
                                                             <button type="submit" id="btn-assign-fees-group"
                                                                 class="btn btn-primary radius-30 mt-2 mt-lg-0 fix-gr-bg mb-0 submit"
                                                                 id="btn-assign-fees-group"
                                                                 data-loading-text="<i class='fas fa-spinner'></i> Processing Data">
                                                                 <span class="ti-save pr"></span>
                                                                 <?php echo app('translator')->get('lang.save'); ?> <?php echo app('translator')->get('lang.fees'); ?>
                                                             </button>
                                                         </div>
                                                     </td>
                                                 </tr>
                                             <?php endif; ?>
                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <?php echo e(Form::close(), false); ?>

                 <?php endif; ?>
             </div>
         </div>
     <?php $__env->stopSection(); ?>

     <?php $__env->startSection('javascript'); ?>

         <script type="text/javascript">
             $(document).ready(function() {


                 if ($("#table_id_table").length) {
                     $("#table_id_table").DataTable({
                         dom: 'T<"clear"><"button">lfrtip',
                         bFilter: false,
                         bLengthChange: false,
                     });
                 }




                 // Fees Assign
                 $("#checkAll").on("click", function() {
                     $(".common-checkbox").prop("checked", this.checked);
                 });

                 $(".common-checkbox").on("click", function() {
                     if (!$(this).is(":checked")) {
                         $("#checkAll").prop("checked", false);
                     }
                     var numberOfChecked = $(".common-checkbox:checked").length;
                     var totalCheckboxes = $(".common-checkbox").length;
                     var totalCheckboxes = totalCheckboxes - 1;

                     if (numberOfChecked == totalCheckboxes) {
                         $("#checkAll").prop("checked", true);
                     }
                 });


                 $(document).on('change', 'input.amount,input.fee-head-check', function() {
                     var total = 0;
                     var table = $(this).closest('table');
                     table.find('tbody tr').each(function() {
                         if ($(this).find('input.fee-head-check').is(':checked')) {
                             var denomination = $(this).find('input.amount').val() ? parseInt($(this)
                                 .find('input.amount').val()) : 0;
                             var subtotal = denomination;
                             total = total + subtotal;
                         }
                     });
                     table.find('span.final_total').text(__currency_trans_from_en(total, true));
                     $('input#final_total').val(total);

                 });


                 // fees group assign

                 $("form#store_student_fee").submit(function(event) {
                     var url = $("#url").val();
                     var student_checked = $("input[name='student_checked[]']:checked")
                         .map(function() {
                             return $(this).val();
                         })
                         .get();
                     if (student_checked.length < 1) {
                         event.preventDefault();
                         toastr.error("Please select at least one student");
                         return false;
                     }
                 });

             });
         </script>
     <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/school-printing/feecard/class-fee-post.blade.php ENDPATH**/ ?>