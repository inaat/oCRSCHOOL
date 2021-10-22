<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('AccountController@postFundTransfer'), 'method' => 'post', 'id' => 'fund_transfer_form', 'files' => true ]) !!}

        <div class="modal-header bg-primary">
            <h4 class="modal-title">@lang( 'account.fund_transfer' )</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                <h5>
                    <strong>@lang('account.transfer_from')</strong>:
                   ({{$from_account->name}})<h5>
                    {!! Form::hidden('from_account', $from_account->id) !!}
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    {!! Form::label('to_account', __( 'account.transfer_to' ) .":*") !!}
                    {!! Form::select('to_account', $to_accounts, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'required' ]); !!}

                </div>
                <div class="col-md-12">
                    {!! Form::label('amount', __( 'account.amount' ) .":*") !!}
                    {!! Form::text('amount', 0, ['class' => 'form-control input_number', 'required','placeholder' => __( 'account.amount' ) ]); !!}

                </div>

                <div class="col-md-12">
                    {!! Form::label('operation_date', __( 'messages.date' ) .":*") !!}
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        {!! Form::text('operation_date', @format_datetime('now') , ['class' => 'form-control datetimepicker-input', 'data-target'=>'#datetimepicker1','required','placeholder' => __( 'messages.date' ) ]); !!}

                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fadeIn animated bx bx-calendar-alt"></i></div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-12">
                    {!! Form::label('note', __( 'account.note' )) !!}
                    {!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'account.note' ), 'rows' => 1]); !!}

                </div>
                <div class="col-sm-12">
                    {!! Form::label('document', __('account.attach_document') . ':') !!}
                    {!! Form::file('document', ['class'=>'form-control ','id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
              
                        @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                        @includeIf('components.document_help_text')
                    

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
        $('#datetimepicker1').datetimepicker({});
    });

</script>
