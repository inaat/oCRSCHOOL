<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('FeeTransactionPaymentController@postPayStudentDue'), 'method' => 'post',  'id' => 'pay_student_due_form', 'files' => true]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.add_payment'); ?>
                </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php echo Form::hidden('student_id', $student_details->student_id); ?>


        <div class="modal-body">
            <div class="row ">
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong><?php echo app('translator')->get('lang.student_name'); ?>:
                            </strong><?php echo e(ucwords($student_details->student_name), false); ?><br>
                            <strong><?php echo app('translator')->get('lang.father_name'); ?>:
                            </strong><?php echo e(ucwords($student_details->father_name), false); ?><br>
                            <strong><?php echo app('translator')->get('lang.roll_no'); ?>: </strong><?php echo e(ucwords($student_details->roll_no), false); ?><br>
                            <strong><?php echo app('translator')->get('lang.current_class'); ?>:
                            </strong><?php echo e(ucwords($student_details->current_class), false); ?>

                            <br>
                            <strong><?php echo app('translator')->get('lang.advance_amount'); ?>:
                            </strong></strong><span class="display_currency"
                                data-currency_symbol="true"><?php echo e(number_format($student_details->advance_amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></span><br>
                                <input type="hidden" name="advance_amount" value="<?php echo e($student_details->advance_amount, false); ?>">
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong><?php echo app('translator')->get('lang.total_fee_amount'); ?>: </strong><span class="display_currency"
                                data-currency_symbol="true"><?php echo e($student_details->total_fee + $student_details->total_admission_fee, false); ?></span><br>
                            <strong><?php echo app('translator')->get('lang.total_paid_amount'); ?>: </strong><span class="display_currency"
                                data-currency_symbol="true"><?php echo e($student_details->total_fee_paid + $student_details->total_admission_fee_paid, false); ?></span><br>
                            <strong><?php echo app('translator')->get('lang.total_fee_due_amount'); ?>: </strong><span class="display_currency"
                                data-currency_symbol="true"><?php echo e($student_details->total_fee - $student_details->total_fee_paid +($student_details->total_admission_fee- $student_details->total_admission_fee_paid), false); ?></span><br>
                            <?php if(!empty($student_details->opening_balance) || $student_details->opening_balance != '0.00'): ?>
                                <strong><?php echo app('translator')->get('lang.opening_balance'); ?>: </strong>
                                <span class="display_currency" data-currency_symbol="true">
                                    <?php echo e($student_details->opening_balance, false); ?></span><br>
                                <strong><?php echo app('translator')->get('lang.opening_balance_due'); ?>: </strong>
                                <span class="display_currency" data-currency_symbol="true">
                                    <?php echo e($ob_due, false); ?></span><br>
                            <?php endif; ?>
                            <strong><?php echo app('translator')->get('lang.total_paid_amount'); ?>: </strong><span class="display_currency"
                                data-currency_symbol="true"><?php echo e($student_details->total_paid, false); ?></span></strong><br>
                            <strong><?php echo app('translator')->get('lang.total_due_amount'); ?>: </strong><span class="display_currency"
                                data-currency_symbol="true"><?php echo e($student_details->total_due, false); ?></span></strong><br>
                        </p>
                    </div>
                </div>
       
            <div class="row payment_row">
                <div class="col-md-4 p-1">
                    <?php echo Form::label('lang.amount', __('lang.amount') . ':*'); ?>

                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>
                        <?php echo Form::text("amount", number_format($payment_line->amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number amount', 'required', 'placeholder' => 'Amount', 'data-rule-max-value' =>$payment_line->amount, 'data-msg-max-value' => __('lang_v1.max_amount_to_be_paid_is', ['amount' =>number_format($payment_line->amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator'])])]); ?>


                    </div>
                </div>
                 <div class="col-md-4 p-1">
                    <?php echo Form::label('lang.amount',  __('lang.discount').' '. __('lang.amount') ); ?>

                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>
                        <?php echo Form::text("discount_amount",0, ['class' => 'form-control input_number', 'required', 'placeholder' => 'Amount', 'id'=>'discount_amount']); ?>

                    </div>
                </div>
                <div class="col-md-4 p-1" id="datetimepicker"
                        data-target-input="nearest" data-target="#datetimepicker" data-toggle="datetimepicker">
                    <?php echo Form::label('paid_on', __('lang.paid_on') . ':*'); ?>

                    <div class="input-group flex-nowrap input-group-append  input-group date"> <span
                            class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>
                        <?php echo Form::text('paid_on', \Carbon::createFromTimestamp(strtotime($payment_line->paid_on))->format(session('system_details.date_format') . ' ' . 'h:i A'), ['class' => 'form-control datetimepicker-input', 'data-target' => '#datetimepicker', 'required']); ?>

                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4 p-1">
                    <?php echo Form::label('method', __('lang.payment_method') . ':*'); ?>

                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>
                        <?php echo Form::select('method', $payment_types, $payment_line->method, ['class' => 'form-select select2 payment_types_dropdown', 'required', 'style' => 'width:100%;']); ?>

                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6 p-1">
                    <?php echo Form::label('document', __('lang.attach_document') . ':'); ?>

                    <?php echo Form::file('document', ['class' => 'form-control ', 'id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); ?>


                    <?php echo app('translator')->get('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]); ?>
                    <?php if ($__env->exists('components.document_help_text')) echo $__env->make('components.document_help_text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                </div>
                <?php if(!empty($accounts)): ?>
                    <div class="col-md-6 p-1">
                        <?php echo Form::label('account_id', __('lang.payment_account') . ':'); ?>

                        <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                    class="fas fa-money-bill-alt"></i></span>
                            <?php echo Form::select('account_id', $accounts, !empty($payment_line->account_id) ? $payment_line->account_id : '', ['class' => 'form-select select2 ', 'id' => 'account_id', 'required', 'style' => 'width:100%;']); ?>

                        
                        </div>
                    </div>
                <?php endif; ?>
                <div class="clearfix"></div>

                <?php echo $__env->make('fee_transaction_payment.payment_type_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo Form::label('note', __('lang_v1.payment_note') . ':'); ?>

                        <?php echo Form::textarea('note', $payment_line->note, ['class' => 'form-control', 'rows' => 3]); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.save' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/fee_transaction_payment/pay_student_due_modal.blade.php ENDPATH**/ ?>