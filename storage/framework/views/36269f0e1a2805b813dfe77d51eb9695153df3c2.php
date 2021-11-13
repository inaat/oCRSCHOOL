<a href="<?php echo e(action('FeeTransactionPaymentController@show', [$id]), false); ?>" class="view_payment_modal payment-status-label" data-orig-value="<?php echo e($payment_status, false); ?>" data-status-name="<?php echo e(__('lang_v1.' . $payment_status), false); ?>"><span class="badge text-white text-uppercase  <?php if($payment_status == 'partial'){
                echo 'bg-info ';
            }elseif($payment_status == 'due'){
                echo ' bg-warning ';
            }elseif ($payment_status == 'paid') {
                echo 'bg-success';
            }elseif ($payment_status == 'overdue') {
                echo 'bg-danger';
            }elseif ($payment_status == 'partial-overdue') {
                echo 'bg-danger';
            }?>"><?php echo e(__('lang_v1.' . $payment_status), false); ?>

                        </span></a><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/fee_allocation/partials/payment_status.blade.php ENDPATH**/ ?>