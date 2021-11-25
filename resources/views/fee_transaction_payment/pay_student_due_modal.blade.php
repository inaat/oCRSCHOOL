<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('FeeTransactionPaymentController@postPayStudentDue'), 'method' => 'post',  'id' => 'pay_student_due_form', 'files' => true]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.add_payment')
                {{-- ({{ ucwords($student->first_name . ' ' . $student->last_name) }}) --}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::hidden('student_id', $student_details->student_id) !!}

        <div class="modal-body">
            <div class="row ">
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong>@lang('lang.student_name'):
                            </strong>{{ ucwords($student_details->student_name) }}<br>
                            <strong>@lang('lang.father_name'):
                            </strong>{{ ucwords($student_details->father_name) }}<br>
                            <strong>@lang('lang.roll_no'): </strong>{{ ucwords($student_details->roll_no) }}<br>
                            <strong>@lang('lang.current_class'):
                            </strong>{{ ucwords($student_details->current_class) }}
                            <br>
                            <strong>@lang('lang.advance_amount'):
                            </strong></strong><span class="display_currency"
                                data-currency_symbol="true">{{ @num_format($student_details->advance_amount) }}</span><br>
                                <input type="hidden" name="advance_amount" value="{{ $student_details->advance_amount }}">
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong>@lang('lang.total_fee_amount'): </strong><span class="display_currency"
                                data-currency_symbol="true">{{ $student_details->total_fee + $student_details->total_admission_fee }}</span><br>
                            <strong>@lang('lang.total_paid_amount'): </strong><span class="display_currency"
                                data-currency_symbol="true">{{ $student_details->total_fee_paid + $student_details->total_admission_fee_paid }}</span><br>
                            <strong>@lang('lang.total_fee_due_amount'): </strong><span class="display_currency"
                                data-currency_symbol="true">{{ $student_details->total_fee - $student_details->total_fee_paid +($student_details->total_admission_fee- $student_details->total_admission_fee_paid) }}</span><br>
                            @if (!empty($student_details->opening_balance) || $student_details->opening_balance != '0.00')
                                <strong>@lang('lang.opening_balance'): </strong>
                                <span class="display_currency" data-currency_symbol="true">
                                    {{ $student_details->opening_balance }}</span><br>
                                <strong>@lang('lang.opening_balance_due'): </strong>
                                <span class="display_currency" data-currency_symbol="true">
                                    {{ $ob_due }}</span><br>
                            @endif
                            <strong>@lang('lang.total_paid_amount'): </strong><span class="display_currency"
                                data-currency_symbol="true">{{ $student_details->total_paid }}</span></strong><br>
                            <strong>@lang('lang.total_due_amount'): </strong><span class="display_currency"
                                data-currency_symbol="true">{{ $student_details->total_due }}</span></strong><br>
                        </p>
                    </div>
                </div>
       
            <div class="row payment_row">
                <div class="col-md-4 p-1">
                    {!! Form::label('lang.amount', __('lang.amount') . ':*') !!}
                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>
                        {!! Form::text("amount", @num_format($payment_line->amount), ['class' => 'form-control input_number amount', 'required', 'placeholder' => 'Amount', 'data-rule-max-value' =>$payment_line->amount, 'data-msg-max-value' => __('lang_v1.max_amount_to_be_paid_is', ['amount' =>@num_format($payment_line->amount)])]); !!}

                    </div>
                </div>
                 <div class="col-md-4 p-1">
                    {!! Form::label('lang.amount',  __('lang.discount').' '. __('lang.amount') ) !!}
                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>
                        {!! Form::text("discount_amount",0, ['class' => 'form-control input_number', 'required', 'placeholder' => 'Amount', 'id'=>'discount_amount']); !!}
                    </div>
                </div>
                <div class="col-md-4 p-1" id="datetimepicker"
                        data-target-input="nearest" data-target="#datetimepicker" data-toggle="datetimepicker">
                    {!! Form::label('paid_on', __('lang.paid_on') . ':*') !!}
                    <div class="input-group flex-nowrap input-group-append  input-group date"> <span
                            class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>
                        {!! Form::text('paid_on', @format_datetime($payment_line->paid_on), ['class' => 'form-control datetimepicker-input', 'data-target' => '#datetimepicker', 'required']) !!}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4 p-1">
                    {!! Form::label('method', __('lang.payment_method') . ':*') !!}
                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>
                        {!! Form::select('method', $payment_types, $payment_line->method, ['class' => 'form-select select2 payment_types_dropdown', 'required', 'style' => 'width:100%;']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6 p-1">
                    {!! Form::label('document', __('lang.attach_document') . ':') !!}
                    {!! Form::file('document', ['class' => 'form-control ', 'id' => 'upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]) !!}

                    @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                    @includeIf('components.document_help_text')

                </div>
                @if (!empty($accounts))
                    <div class="col-md-6 p-1">
                        {!! Form::label('account_id', __('lang.payment_account') . ':') !!}
                        <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                    class="fas fa-money-bill-alt"></i></span>
                            {!! Form::select('account_id', $accounts, !empty($payment_line->account_id) ? $payment_line->account_id : '', ['class' => 'form-select select2 ', 'id' => 'account_id', 'required', 'style' => 'width:100%;']) !!}
                        
                        </div>
                    </div>
                @endif
                <div class="clearfix"></div>

                @include('fee_transaction_payment.payment_type_details')
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('note', __('lang_v1.payment_note') . ':') !!}
                        {!! Form::textarea('note', $payment_line->note, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">@lang( 'global_lang.save' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
        </div>
    </div>

    {!! Form::close() !!}

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
