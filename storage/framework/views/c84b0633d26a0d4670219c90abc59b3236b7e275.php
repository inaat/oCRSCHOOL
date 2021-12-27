 
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

         <div class="row ">
             <div class="col-md-6">
                 <div class="card card-body bg-light">
                     <p>
                         <strong><?php echo app('translator')->get('campus.campus_name'); ?>:
                         </strong>(<?php echo e(ucwords($transaction->campus->campus_name), false); ?>)<br>
                         <strong><?php echo app('translator')->get('hrm.employee_name'); ?>:
                         </strong>(<?php echo e(ucwords($transaction->employee->first_name . ' ' . $transaction->employee->last_name), false); ?>)<br>
                         <strong><?php echo app('translator')->get('hrm.father_name'); ?>:
                         </strong><?php echo e(ucwords($transaction->employee->father_name), false); ?><br>
                         <strong><?php echo app('translator')->get('hrm.employeeID'); ?>: </strong><?php echo e(ucwords($transaction->employee->employeeID), false); ?><br>
                         <strong><?php echo app('translator')->get('hrm.basic_salary'); ?>: </strong><?php 
            $formated_number = "";
            if (session("system_details.currency_symbol_placement") == "before") {
                $formated_number .= session("currency")["symbol"] . " ";
            } 
            $formated_number .= number_format((float) $transaction->employee->basic_salary, config("constants.currency_precision", 2) , session("currency")["decimal_separator"], session("currency")["thousand_separator"]);

            if (session("system_details.currency_symbol_placement") == "after") {
                $formated_number .= " " . session("currency")["symbol"];
            }
            echo $formated_number; ?>
                         <input type="hidden" id="transaction_final_total" name="" value="<?php echo e($transaction->employee->basic_salary, false); ?>">

                     </p>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="card card-body bg-light">
                     <p>
                         <strong><?php echo app('translator')->get('hrm.ref_no'); ?>:
                         </strong>(<?php echo e(ucwords($transaction->ref_no), false); ?>)<br>
                         <strong><?php echo app('translator')->get('hrm.transaction_date'); ?>:
                         </strong><?php echo e(\Carbon::createFromTimestamp(strtotime($transaction->transaction_date))->format(session('system_details.date_format')), false); ?><br>
                         <strong><?php echo app('translator')->get('lang.payment_status'); ?>:
                         </strong><?php echo e(ucwords($transaction->payment_status), false); ?><br>
                         <strong><?php echo app('translator')->get('lang.total_amount'); ?>: </strong><span class="display_currency" data-currency_symbol="true"><?php echo e($transaction->final_total, false); ?></span><br>

                     </p>
                 </div>
             </div>
         </div>
         <?php echo Form::open(['url' => action('HRM\HrmPayrollController@update', [$transaction->id]), 'method' => 'PUT', 'id' => 'pay_roll_edit_form']); ?>

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
                             
                                 <?php if(!empty($transaction->allowance)): ?>
                                 <?php $__currentLoopData = $transaction->allowance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2"><?php echo e($allowance->hrm_allowance->allowance, false); ?></div>
                                     </td> 
                                     <td class="text-center">
                                         <?php echo Form::checkbox('allowances[' . $loop->iteration . '][is_enabled]', 1,$allowance->is_enabled, ['class' => 'form-check-input mt-2 allowance-check']); ?> </td>
                                     </td>
                                     <td class="text-center ">
                                        <?php echo Form::text('allowances['.$loop->iteration.'][amount]',number_format($allowance->amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number allowance-amount']); ?>


                                         <input type="hidden" name="allowances[<?php echo e($loop->iteration, false); ?>][allowance_line_id]" value="<?php echo e($allowance->id, false); ?>">

                                     </td>
                                 </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
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
                                     <th class="text-center"><?php echo app('translator')->get('hrm.day_wise'); ?></th>
                                     <th class="text-center "><?php echo app('translator')->get('hrm.amount'); ?></th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php if(!empty($transaction->deduction)): ?>

                                 <?php $__currentLoopData = $transaction->deduction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2"><?php echo e($deduction->hrm_deduction->deduction, false); ?></div>
                                     </td>
                                     <td class="text-center">
                                         <?php echo Form::checkbox('deductions[' . $loop->iteration . '][is_enabled]', 1, $deduction->is_enabled, ['class' => 'form-check-input mt-2 deduction-check']); ?> </td>
                                     </td>

                                     <td class="text-center ">
                                         <input name="deductions[<?php echo e($loop->iteration, false); ?>][divider]" type="number" value="<?php echo e($deduction->divider, false); ?>" class="form-control deduction-divider">
                                     <td class="text-center ">
                                         <input type="hidden" name="deductions[<?php echo e($loop->iteration, false); ?>][deduction_line_id]" value="<?php echo e($deduction->id, false); ?>">
                                    <?php echo Form::text('deductions['.$loop->iteration.'][amount]', number_format($deduction->amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number deduction-amount']); ?>


                                     </td>
                                 </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                 <?php if(!empty($deductions)): ?>
                                 <?php $__currentLoopData = $deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2"><?php echo e($deduction->deduction, false); ?></div>
                                     </td>
                                     <td class="text-center">
                                         <?php echo Form::checkbox('deductions[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 deduction-check']); ?> </td>
                                     </td>

                                     <td class="text-center ">
                                         <input name="deductions[<?php echo e($loop->iteration, false); ?>][divider]" type="number" value="0" class="form-control deduction-divider">
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
             <div class="card ">
                 <div class="card-body">

                     <h5 class="card-title text-primary text-center">Gross Amount :
                         <span class="gross_final_total"><?php 
            $formated_number = "";
            if (session("system_details.currency_symbol_placement") == "before") {
                $formated_number .= session("currency")["symbol"] . " ";
            } 
            $formated_number .= number_format((float) $transaction->final_total, config("constants.currency_precision", 2) , session("currency")["decimal_separator"], session("currency")["thousand_separator"]);

            if (session("system_details.currency_symbol_placement") == "after") {
                $formated_number .= " " . session("currency")["symbol"];
            }
            echo $formated_number; ?></span></h5>
                     <input type="hidden" name="gross_final_total" id="gross_final_total" value="<?php echo e($transaction->final_total, false); ?>">


                     <div class="d-lg-flex align-items-center mb-4 gap-3">
                         <div class="ms-auto">
                             <button class="btn- btn btn-primary radius-30 mt-2 mt-lg-0"><?php echo app('translator')->get('messages.update'); ?></button>
                         </div>

                     </div>
                 </div>
             </div>
         </div>


         <?php echo Form::close(); ?>

     </div>
     <?php $__env->stopSection(); ?>

     <?php $__env->startSection('javascript'); ?>
            <script src="<?php echo e(asset('js/hrm.js?v=' . $asset_v), false); ?>"></script>

    
     <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\payroll/edit.blade.php ENDPATH**/ ?>