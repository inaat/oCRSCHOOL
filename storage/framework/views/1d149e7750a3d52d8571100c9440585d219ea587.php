<div class="modal-dialog" role="document">
  <div class="modal-content">

    <?php echo Form::open(['url' => action('AccountController@postDebit'), 'method' => 'post', 'id' => 'deposit_form' ]); ?>


     <div class="modal-header bg-primary">
            <h4 class="modal-title"><?php echo app('translator')->get( 'account.debit' ); ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
            <div class="form-group">
                <strong><?php echo app('translator')->get('account.selected_account'); ?></strong>: 
                <?php echo e($account->name, false); ?>

                <?php echo Form::hidden('account_id', $account->id); ?>

            </div>

            <div class="form-group">
                <?php echo Form::label('amount', __( 'sale.amount' ) .":*"); ?>

                <?php echo Form::text('amount', 0, ['class' => 'form-control input_number', 'required','placeholder' => __( 'sale.amount' ) ]); ?>

            </div>

            <div class="form-group d-none">
                <?php echo Form::label('from_account', __( 'account.deposit_from' ) .":"); ?>

                <?php echo Form::select('from_account', $from_accounts, null, ['class' => 'form-control', 'placeholder' => __('messages.please_select') ]); ?>

            </div>

            <div class="form-group">
                   <?php echo Form::label('operation_date', __( 'messages.date' ) .":*"); ?>

                    <div class="input-group date" id="od_datetimepicker" data-target-input="nearest">
                        <?php echo Form::text('operation_date', \Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format') . ' ' . 'h:i A') , ['class' => 'form-control datetimepicker-input', 'data-target'=>'#od_datetimepicker','required','placeholder' => __( 'messages.date' ) ]); ?>


                        <div class="input-group-append" data-target="#od_datetimepicker" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fadeIn animated bx bx-calendar-alt"></i></div>
                        </div>
                    </div>
            </div>

            <div class="form-group">
                <?php echo Form::label('note', __( 'account.note' )); ?>

                <?php echo Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'account.note' ), 'rows' => 4]); ?>

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
  $(document).ready( function(){
    $('#od_datetimepicker').datetimepicker({
      format: moment_date_format + ' ' + moment_time_format
    });
  });
</script><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/account/debit.blade.php ENDPATH**/ ?>