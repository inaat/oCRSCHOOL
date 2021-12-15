<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">


        {!! Form::open(['url' => action('FeeTransactionPaymentController@postAdvanceAmount'), 'method' => 'post', 'id' => 'transaction_payment_add_form', 'files' => true]) !!}
        {!! Form::hidden('student_id', $student->id) !!}
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.add_advance_payment')
                {{-- ({{ ucwords($student->first_name . ' ' . $student->last_name) }}) --}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
           <div class="row ">
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong>@lang('lang.student_name'):
                            </strong>({{ ucwords($student->first_name . ' ' . $student->last_name) }})<br>
                            <strong>@lang('lang.father_name'):
                            </strong>{{ ucwords($student->father_name) }}<br>
                            <strong>@lang('lang.roll_no'): </strong>{{ ucwords($student->roll_no) }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                      <div class="card card-body bg-light">
                       <p>
                            <strong>@lang('lang.advance_amount'):
                            </strong></strong><span class="display_currency"
                                data-currency_symbol="true">{{ @num_format($student->advance_amount) }}</span><br>
                                <input type="hidden" name="advance_amount" value="{{ $student->advance_amount }}">
                        </p>
                    </div>
                </div> 

            <div class="row payment_row">
                <div class="col-md-4 p-1">
                    {!! Form::label('lang.amount', __('lang.amount') . ':*') !!}
                    <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                class="fas fa-money-bill-alt"></i></span>

                        {!! Form::text("amount",null, ['class' => 'form-control amount input_number', 'required', 'placeholder' => 'Amount', 'data-rule-min-value' =>100, 'data-msg-min-value' => __('lang_v1.max_amount_to_be_paid_is', ['amount' =>@num_format(100)])]); !!}

                    </div>
                </div>

                <div class="col-md-4 p-1" id="datetimepicker" data-target-input="nearest"
                    data-target="#datetimepicker" data-toggle="datetimepicker">
                    {!! Form::label('paid_on', __('lang.paid_on') . ':*') !!}
                    <div class="input-group flex-nowrap input-group-append  input-group date"> <span
                            class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>
                        {!! Form::text('paid_on', @format_datetime('now'), ['class' => 'form-control datetimepicker-input', 'data-target' => '#datetimepicker', 'required']) !!}
                    </div>
                </div>
                 <input type="hidden" name="method" value="student_advance_amount">
                <div class="clearfix"></div>

                <div class="row payment_details_div d-none" data-type="card">
                    <div class="col-md-4 p-1">

                        {!! Form::label('card_number', __('lang_v1.card_no')) !!}
                        {!! Form::text('card_number', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_no')]) !!}

                    </div>

                    <div class="col-md-4 p-1">

                        {!! Form::label('card_holder_name', __('lang_v1.card_holder_name')) !!}
                        {!! Form::text('card_holder_name', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_holder_name')]) !!}

                    </div>
                    <div class="col-md-4 p-1">

                        {!! Form::label('card_transaction_number', __('lang_v1.card_transaction_no')) !!}
                        {!! Form::text('card_transaction_number', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_transaction_no')]) !!}

                    </div>
                    <div class="clearfix"></div>
                     <div class="col-md-2 p-1">

                        {!! Form::label('card_type', __('lang_v1.card_type')) !!}
                        {!! Form::select('card_type', ['credit' => 'Credit Card', 'debit' => 'Debit Card', 'visa' => 'Visa', 'master' => 'MasterCard'], null, ['class' => 'form-control select2']) !!}

                    </div>
                    <div class="col-md-2 p-1">

                        {!! Form::label('card_month', __('lang_v1.month')) !!}
                        {!! Form::text('card_month', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.month')]) !!}

                    </div>
                    <div class="col-md-2 p-1">

                        {!! Form::label('card_year', __('lang_v1.year')) !!}
                        {!! Form::text('card_year', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.year')]) !!}

                    </div>
                    <div class="col-md-2 p-1">

                        {!! Form::label('card_security', __('lang_v1.security_code')) !!}
                        {!! Form::text('card_security', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.security_code')]) !!}

                    </div> 
                    <div class="clearfix"></div>
                </div>
                <div class="payment_details_div d-none " data-type="cheque">
                    <div class="col-md-12">
                        {!! Form::label('cheque_number', __('lang_v1.cheque_no')) !!}
                        {!! Form::text('cheque_number', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.cheque_no')]) !!}

                    </div>
                </div>
                <div class="payment_details_div d-none" data-type="bank_transfer">
                    <div class="col-md-12">
                        {!! Form::label('bank_account_number', __('lang_v1.bank_account_number')) !!}
                        {!! Form::text('bank_account_number', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.bank_account_number')]) !!}

                    </div>
                </div>
                <div class="payment_details_div d-none" data-type="advance_pay">
                    <div class="col-md-12">
                        {!! Form::label('transaction_no_1', __('lang_v1.transaction_no')) !!}
                        {!! Form::text('transaction_no_1', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]) !!}

                    </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('note', __('lang_v1.payment_note') . ':') !!}
                        {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'lang.close' )</button>
        </div>
    </div>

    {!! Form::close() !!}

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
