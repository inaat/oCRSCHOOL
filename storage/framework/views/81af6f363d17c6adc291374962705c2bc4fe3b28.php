 
 <?php $__env->startSection('wrapper'); ?>
     <div class="page-wrapper">
         <div class="page-content">
             <!--breadcrumb-->
             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.all_fee_transaction'); ?></h5>
                     <hr>
                         <table class="table mb-0" width="100%" id="fee_transaction_table">
                             <thead class="table-light" width="100%">
                                 <tr>
                                     <th></th>
                                     <?php $__currentLoopData = __('lang.short_months'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <th><?php echo e($month, false); ?></th>
                                         
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </tr>
                             </thead>
                              <tbody>
                              <tr>
                               <td>B/F</td>
                       
                              <?php $__currentLoopData = $balance['bf']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <td><?php echo e(number_format($b, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tr>
                              <tr>
                              <tr>
                               <td>Current Fee</td>
                              <?php $__currentLoopData = $transaction_formatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <td><?php echo e(number_format($q, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tr>
                              <tr>
                               <td>Total</td>

                              <?php $__currentLoopData = $balance['total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <td><?php echo e(number_format($t, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                              </tr>
                            <td>paid</td>

                              <?php $__currentLoopData = $payment_formatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <td><?php echo e(number_format($p, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tr>
                            <td>Balance</td>

                               <?php $__currentLoopData = $balance['balance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <td><?php echo e(number_format($b, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tr>
                           
                              </tbody>
                         </table>
                 </div>
             </div>
         </div>
     </div>

 <?php $__env->stopSection(); ?>



<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/fee_allocation/print.blade.php ENDPATH**/ ?>