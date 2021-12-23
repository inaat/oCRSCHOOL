 
 <?php $__env->startSection('wrapper'); ?>
 <div class="page-wrapper">
     <div class="page-content">
         <!--breadcrumb-->
         <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
             <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('hrm.payroll_allocation'); ?></div>
             <div class="ps-3">
                 <nav aria-label="breadcrumb">
                     <ol class="breadcrumb mb-0 p-0">
                         <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                         </li>
                         <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('hrm.payroll_allocation'); ?></li>
                     </ol>
                 </nav>
             </div>
         </div>
         <!--end breadcrumb-->
         <?php echo Form::open(['url' => action('HRM\HrmPayrollController@payrollAssignSearch'), 'method' => 'post', 'id' => 'search_employee_fee', 'files' => true]); ?>


         <div class="card">
             <?php
             $group_name = __('hrm.payroll_for_month', ['date' => $month_name . ' ' . $year]);

             ?>
             <div class="card-body">
                 <h6 class="card-title text-primary"><?php echo app('translator')->get('lang.select_ground'); ?></h6>
                 <hr>
                 <div class="row m-0">
                     <div class="col-md-3 p-2 ">
                         <?php echo Form::label('campus.employee', __('campus.campuses') . ':*'); ?>

                         <?php echo Form::select('campus_id', $campuses, $campus_id, ['class' => 'form-select select2 global-campuses', 'required', 'id' => 'employees_list_filter_campus_id', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]); ?>

                     </div>
                     <div class="col-md-3 p-2">
                         <?php echo Form::label('month_year', __('hrm.month_year') . ':*'); ?>

                         <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                             <?php echo Form::text('month_year', $month_year, ['class' => 'form-control', 'placeholder' => __('hrm.month_year'), 'required', 'readonly']); ?>


                         </div>
                     </div>
                     <div class="col-md-3 p-2">
                         <?php echo Form::label('payroll_group_name', __( 'hrm.payroll_group_name' ) . ':*'); ?>

                         <?php echo Form::text('payroll_group_name', strip_tags($group_name), ['class' => 'form-control', 'placeholder' => __( 'hrm.payroll_group_name' ), 'required']); ?>


                     </div>
                     <div class="col-md-3 p-2">
                         <?php echo Form::label('status', __( 'hrm.status' ) . ':*'); ?>

                         <?php
                if(session('system_details.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('hrm.group_status_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
                         <?php echo Form::select('status', ['final' => __('hrm.final'), 'pending' => __('hrm.pending')], $status, ['class' => 'form-control select2', 'required', 'style' => 'width: 100%;', 'placeholder' => __( 'messages.please_select' )]); ?>


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
                                 <div class="text-dark">Basic Salary Amount Already You had Assigned
                                     During The Employee Registertion </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <?php if(isset($employees)): ?>
             <?php echo Form::open(['url' => action('HRM\HrmPayrollController@store'), 'method' => 'post', 'class' => '', '' . 'id' => 'store_employee_fee', 'files' => true]); ?>



             <input type="hidden" name="month_year" value="<?php echo e($month_year, false); ?>">
             <?php echo Form::hidden('transaction_date', $transaction_date); ?>

             <?php echo Form::hidden('status', $status); ?>

             <?php echo Form::hidden('payroll_group_name', strip_tags($group_name), ['class' => 'form-control', 'placeholder' => __( 'hrm.payroll_group_name' ), 'required']); ?>

            <input type="hidden" id="transaction_final_total" name="" value="0">
             <input type="hidden" name="deduction_amount" id="deduction_final_total"  value="0"/>
            <input type="hidden" name="allowance_amount" id="allowance_final_total" value="0"/>

            
             <div class="row">
                
                   <div class="col-lg-6">
                 <div class="card ">
                     <div class="card-body">
                         <table id="" class="allowance-table table table-condensed table-striped " id="allowance-table">
                             <thead>
                                 <tr>
                                     <th class="text-center"><?php echo app('translator')->get('hrm.allowances'); ?></th>
                                     <th class="text-center"><?php echo app('translator')->get('hrm.enable'); ?></th>
                                     <th class="text-center "><?php echo app('translator')->get('hrm.amount'); ?></th>
                                 </tr>
                             </thead>
                             <tbody>
                             
                                 <?php if(!empty($allowances)): ?>
                                 <?php $__currentLoopData = $allowances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2"><?php echo e($allowance->allowance, false); ?></div>
                                     </td>
                                     <td class="text-center">
                                         <?php echo Form::checkbox('allowances[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 allowance-check']); ?> </td>
                                     </td>

                                     <td class="text-center ">
                                        <?php echo Form::text('allowances['.$loop->iteration.'][amount]', 0, ['class' => 'form-control input_number allowance-amount']); ?>


                                         <input type="hidden" name="allowances[<?php echo e($loop->iteration, false); ?>][allowance_id]" value="<?php echo e($allowance->id, false); ?>">

                                     </td>
                                 </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                             <tfoot>
                                 <tr>
                                     <th colspan="2" class="text-center">Total</th>
                                     <td><span class="allowance_final_total">0</span></td>
                                 </tr>
                             </tfoot>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
              <div class="col-lg-6">
                     <div class="card ">
                         <div class="card-body">
                             <table id="" class="deduction-table table table-condensed table-striped " id="deduction-table">
                                 <thead>
                                     <tr>
                                         <th class="text-center"><?php echo app('translator')->get('hrm.deductions'); ?></th>
                                         <th class="text-center"><?php echo app('translator')->get('hrm.enable'); ?></th>
                                         <th class="text-center hide"><?php echo app('translator')->get('hrm.day_wise'); ?></th>
                                         <th class="text-center "><?php echo app('translator')->get('hrm.amount'); ?></th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php if(!empty($deductions)): ?>
                                     <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr>
                                         <td class="text-center">
                                             <div class="mt-2"><?php echo e($deduction->deduction, false); ?></div>
                                         </td>
                                         <td class="text-center">
                                             <?php echo Form::checkbox('deductions[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 deduction-check']); ?> </td>
                                         </td>

                                         <td class="text-center hide ">
                                             <input name="deductions[<?php echo e($loop->iteration, false); ?>][divider]" type="hidden" value="0" class="form-control deduction-divider">
                                         <td class="text-center ">
                                             <input type="hidden" name="deductions[<?php echo e($loop->iteration, false); ?>][deduction_id]" value="<?php echo e($deduction->id, false); ?>">
                                             <?php echo Form::text('deductions['.$loop->iteration.'][amount]', 0, ['class' => 'form-control input_number deduction-amount']); ?>


                                         </td>
                                     </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     <?php endif; ?>
                                 <tfoot>
                                     <tr>
                                         <th colspan="2" class="text-center">Total</th>
                                         <td><span class="deduction_final_total">0</span></td>
                                     </tr>
                                 </tfoot>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="row">
                 <div class="col-lg-12">

                     <div class="card">
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table mb-0" width="100%" id="employees_table">
                                     <thead class="table-light" width="100%">
                                         <tr>
                                             

                                             <th> <input type="checkbox" id="checkAll" class="common-checkbox form-check-input mt-2" name="checkAll">
                                                 <label for="checkAll"><?php echo app('translator')->get('lang.all'); ?></label>
                                             </th>
                                             <th><?php echo app('translator')->get('hrm.employee_name'); ?></th>
                                             <th><?php echo app('translator')->get('hrm.father_name'); ?></th>
                                             <th><?php echo app('translator')->get('lang.status'); ?></th>
                                             <th><?php echo app('translator')->get('hrm.employeeID'); ?></th>
                                             <th><?php echo app('translator')->get('hrm.basic_salary'); ?></th>
                                             <th><?php echo app('translator')->get('hrm.joining_date'); ?></th>
                                             <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                                         </tr>
                                     </thead>
                                     <tbody class="">
                                         <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                             <td>
                                                 <input type="checkbox" id="employee.<?php echo e($employee->id, false); ?>" class="common-checkbox form-check-input mt-2" name="employee_checked[]" value="<?php echo e($employee->id, false); ?>" }}>
                                                 <label for="employee.<?php echo e($employee->id, false); ?>"></label>
                                             </td>
                                             <td><?php echo e(ucwords($employee->employee_name), false); ?>

                                                 <input type="hidden" name="id[]" value="<?php echo e($employee->id, false); ?>">
                                             </td>
                                             <td><?php echo e(ucwords($employee->father_name), false); ?></td>
                                             <td><?php echo e($employee->status, false); ?></td>
                                             <td><?php echo e($employee->employeeID, false); ?></td>
                                             <td><?php echo e(number_format($employee->basic_salary, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                                             <td><?php echo e(\Carbon::createFromTimestamp(strtotime($employee->joining_date))->format(session('system_details.date_format')), false); ?></td>
                                             <td><?php echo e(ucwords($employee->campus_name), false); ?></td>
                                         </tr>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     </tbody>
                                     <?php if($employees->count() > 0): ?>
                                     <tr>
                                         <td colspan="7">
                                             <div class="text-center">
                                                 <button type="submit" id="btn-assign-payroll-group" class="btn btn-primary radius-30 mt-2 mt-lg-0 fix-gr-bg mb-0 submit" id="btn-assign-payroll-group" data-loading-text="<i class='fas fa-spinner'></i> Processing Data">
                                                     <span class="ti-save pr"></span>
                                                     <?php echo app('translator')->get('hrm.save'); ?> <?php echo app('translator')->get('hrm.payroll'); ?>
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
            <script src="<?php echo e(asset('js/hrm.js?v=' . $asset_v), false); ?>"></script>

         <script type="text/javascript">
             $(document).ready(function() {
                 $('#month_year').datepicker({
                     autoclose: true,
                     format: 'mm/yyyy',
                     minViewMode: "months"
                 });

             




                 // payroll Assign
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


             


                 // payroll group assign

                 $("form#store_employee_fee").submit(function(event) {
                     var url = $("#url").val();
                     var employee_checked = $("input[name='employee_checked[]']:checked")
                         .map(function() {
                             return $(this).val();
                         })
                         .get();
                     if (employee_checked.length < 1) {
                         event.preventDefault();
                         toastr.error("Please select at least one employee");
                         return false;
                     }
                 });

             });
         </script>
     <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\payroll/payroll_assign.blade.php ENDPATH**/ ?>