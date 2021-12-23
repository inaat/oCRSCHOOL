<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('FeeTransactionPaymentController@postPayStudentDue'), 'method' => 'post',  'id' => 'pay_student_due_form', 'files' => true]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.view_payments'); ?>
                (<?php echo e(ucwords($transaction->voucher_no), false); ?>)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
              <div class="row ">
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong><?php echo app('translator')->get('lang.student_name'); ?>:
                            </strong>(<?php echo e(ucwords($transaction->student->first_name . ' ' . $transaction->student->last_name), false); ?>)<br>
                            <strong><?php echo app('translator')->get('lang.father_name'); ?>:
                            </strong><?php echo e(ucwords($transaction->student->father_name), false); ?><br>
                            <strong><?php echo app('translator')->get('lang.roll_no'); ?>: </strong><?php echo e(ucwords($transaction->student->roll_no), false); ?>

                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                       <p>
                            <strong><?php echo app('translator')->get('lang.challan_no'); ?>:
                            </strong>(<?php echo e(ucwords($transaction->voucher_no), false); ?>)<br>
                            <strong><?php echo app('translator')->get('lang.fee_transaction_date'); ?>:
                            </strong><?php echo e(\Carbon::createFromTimestamp(strtotime($transaction->transaction_date))->format(session('system_details.date_format')), false); ?><br>
                            <strong><?php echo app('translator')->get('lang.payment_status'); ?>: </strong><?php echo e(ucwords($transaction->payment_status), false); ?>

                        </p>
                    </div>
                </div>
                </div>
 <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                        <tr>
                          <th><?php echo app('translator')->get('lang.date'); ?></th>
                          <th><?php echo app('translator')->get('lang.ref_no'); ?></th>
                          <th><?php echo app('translator')->get('lang.amount'); ?></th>
                          <th><?php echo app('translator')->get('lang.payment_method'); ?></th>
                          <th><?php echo app('translator')->get('lang.payment_note'); ?></th>
                          <?php if($accounts_enabled): ?>
                            <th><?php echo app('translator')->get('lang_v1.payment_account'); ?></th>
                          <?php endif; ?>
                          <th class="no-print"><?php echo app('translator')->get('lang.actions'); ?></th>
                        </tr>
                        <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                              <td><?php echo e(\Carbon::createFromTimestamp(strtotime($payment->paid_on))->format(session('system_details.date_format') . ' ' . 'h:i A'), false); ?></td>
                              <td><?php echo e($payment->payment_ref_no, false); ?></td>
                              <td><span class="display_currency" data-currency_symbol="true"><?php echo e($payment->amount, false); ?></span></td>
                              <td><?php echo e($payment_types[$payment->method] ?? '', false); ?></td>
                              <td><?php echo e($payment->note, false); ?></td>
                              <?php if($accounts_enabled): ?>
                                <td><?php echo e($payment->payment_account->name ?? '', false); ?></td>
                              <?php endif; ?>
                              <td class="no-print" style="display: flex;">
                                  <?php if($payment->method != 'advance_pay'): ?>

                                <button type="button" class="btn btn-info btn-xs edit_payment" 
                                data-href="<?php echo e(action('FeeTransactionPaymentController@edit', [$payment->id]), false); ?>"><i class="glyphicon glyphicon-edit"></i></button>
                                &nbsp; 
                                <?php endif; ?>
                                <button type="button" class="btn btn-danger btn-xs delete_payment" 
                                data-href="<?php echo e(action('FeeTransactionPaymentController@destroy', [$payment->id]), false); ?>"
                                ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                &nbsp;
                               
                              <?php if(!empty($payment->document_path)): ?>
                                &nbsp;
                                <a href="<?php echo e($payment->document_path, false); ?>" class="btn btn-success btn-xs" download="<?php echo e($payment->document_name, false); ?>"><i class="fa fa-download" data-toggle="tooltip" title="<?php echo e(__('purchase.download_document'), false); ?>"></i></a>
                                <?php if(isFileImage($payment->document_name)): ?>
                                &nbsp;
                                  <button data-href="<?php echo e($payment->document_path, false); ?>" class="btn btn-info btn-xs view_uploaded_document" data-toggle="tooltip" title="<?php echo e(__('lang_v1.view_document'), false); ?>"><i class="fa fa-picture-o"></i></button>
                                <?php endif; ?>

                              <?php endif; ?>
                              </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                              <td colspan="6"><?php echo app('translator')->get('purchase.no_records_found'); ?></td>
                            </tr>
                        <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div
           
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.save' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
    <?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/fee_transaction_payment/show_payments.blade.php ENDPATH**/ ?>