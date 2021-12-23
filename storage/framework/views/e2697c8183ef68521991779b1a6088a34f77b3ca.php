<div class="modal-dialog" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('AccountController@postFundTransfer'), 'method' => 'post', 'id' => 'fund_transfer_form', 'files' => true ]); ?>


        <div class="modal-header bg-primary">
            <h4 class="modal-title"><?php echo app('translator')->get( 'account.fund_transfer' ); ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <h5>
                    <strong><?php echo app('translator')->get('account.transfer_from'); ?></strong>:
                   (<?php echo e($from_account->name, false); ?>)<h5>
                    <?php echo Form::hidden('from_account', $from_account->id); ?>

                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <?php echo Form::label('to_account', __( 'account.transfer_to' ) .":*"); ?>

                    <?php echo Form::select('to_account', $to_accounts, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'required' ]); ?>


                </div>
                <div class="col-md-12">
                    <?php echo Form::label('amount', __( 'account.amount' ) .":*"); ?>

                    <?php echo Form::text('amount', 0, ['class' => 'form-control input_number', 'required','placeholder' => __( 'account.amount' ) ]); ?>


                </div>

                <div class="col-md-12">
                    <?php echo Form::label('operation_date', __( 'messages.date' ) .":*"); ?>

                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <?php echo Form::text('operation_date', \Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format') . ' ' . 'h:i A') , ['class' => 'form-control datetimepicker-input', 'data-target'=>'#datetimepicker1','required','placeholder' => __( 'messages.date' ) ]); ?>


                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fadeIn animated bx bx-calendar-alt"></i></div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12">
                    <?php echo Form::label('note', __( 'account.note' )); ?>

                    <?php echo Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'account.note' ), 'rows' => 1]); ?>


                </div>
                <div class="col-sm-12">
                    <?php echo Form::label('document', __('account.attach_document') . ':'); ?>

                    <?php echo Form::file('document', ['class'=>'form-control ','id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); ?>

              
                        <?php echo app('translator')->get('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]); ?>
                        <?php if ($__env->exists('components.document_help_text')) echo $__env->make('components.document_help_text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    

                </div>

            </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'messages.submit' ); ?></button>
        <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#od_datetimepicker').datetimepicker({
            format: moment_date_format + ' ' + moment_time_format
        });
        $('#datetimepicker1').datetimepicker({});
    });

</script>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/account/transfer.blade.php ENDPATH**/ ?>