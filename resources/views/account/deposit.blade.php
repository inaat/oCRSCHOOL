<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('AccountController@postDeposit'), 'method' => 'post', 'id' => 'deposit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h4 class="modal-title">@lang( 'account.deposit' )</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 ">
                    <strong>@lang('account.selected_account')</strong>:
                    {{$account->name}}
                    {!! Form::hidden('account_id', $account->id) !!}
                </div>
            </div>
            <div class="row">

                <div class="col-md-12 ">
                    {!! Form::label('amount', __( 'account.amount' ) .":*") !!}
                    {!! Form::text('amount', 0, ['class' => 'form-control input_number', 'required','placeholder' => __( 'account.amount' ) ]); !!}
                </div>

                <div class="col-md-12 ">
                    {!! Form::label('from_account', __( 'account.deposit_from' ) .":") !!}
                    {!! Form::select('from_account', $from_accounts, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select') ]); !!}
                </div>

                <div class="col-md-12 ">
                    {!! Form::label('operation_date', __( 'messages.date' ) .":*") !!}
                    <div class="input-group date" id="od_datetimepicker" data-target-input="nearest">
                        {!! Form::text('operation_date', @format_datetime('now') , ['class' => 'form-control datetimepicker-input', 'data-target'=>'#od_datetimepicker','required','placeholder' => __( 'messages.date' ) ]); !!}

                        <div class="input-group-append" data-target="#od_datetimepicker" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fadeIn animated bx bx-calendar-alt"></i></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 ">
                    {!! Form::label('note', __( 'account.note' )) !!}
                    {!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'account.note' ), 'rows' => 4]); !!}
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang( 'messages.submit' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#od_datetimepicker').datetimepicker({
            format: moment_date_format + ' ' + moment_time_format
        });
    });

</script>
