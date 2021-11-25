<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('FeeTransactionPaymentController@postPayStudentDue'), 'method' => 'post',  'id' => 'pay_student_due_form', 'files' => true]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.view_payments')
                ({{ ucwords($transaction->voucher_no) }})</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
              <div class="row ">
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                        <p>
                            <strong>@lang('lang.student_name'):
                            </strong>({{ ucwords($transaction->student->first_name . ' ' . $transaction->student->last_name) }})<br>
                            <strong>@lang('lang.father_name'):
                            </strong>{{ ucwords($transaction->student->father_name) }}<br>
                            <strong>@lang('lang.roll_no'): </strong>{{ ucwords($transaction->student->roll_no) }}
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-body bg-light">
                       <p>
                            <strong>@lang('lang.challan_no'):
                            </strong>({{ ucwords($transaction->voucher_no) }})<br>
                            <strong>@lang('lang.fee_transaction_date'):
                            </strong>{{ @format_date($transaction->transaction_date) }}<br>
                            <strong>@lang('lang.payment_status'): </strong>{{ ucwords($transaction->payment_status) }}
                        </p>
                    </div>
                </div>
                </div>
 <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                        <tr>
                          <th>@lang('lang.date')</th>
                          <th>@lang('lang.ref_no')</th>
                          <th>@lang('lang.amount')</th>
                          <th>@lang('lang.payment_method')</th>
                          <th>@lang('lang.payment_note')</th>
                          @if($accounts_enabled)
                            <th>@lang('lang_v1.payment_account')</th>
                          @endif
                          <th class="no-print">@lang('lang.actions')</th>
                        </tr>
                        @forelse ($payments as $payment)
                            <tr>
                              <td>{{ @format_datetime($payment->paid_on) }}</td>
                              <td>{{ $payment->payment_ref_no }}</td>
                              <td><span class="display_currency" data-currency_symbol="true">{{ $payment->amount }}</span></td>
                              <td>{{ $payment_types[$payment->method] ?? '' }}</td>
                              <td>{{ $payment->note }}</td>
                              @if($accounts_enabled)
                                <td>{{$payment->payment_account->name ?? ''}}</td>
                              @endif
                              <td class="no-print" style="display: flex;">
                                  @if($payment->method != 'advance_pay')

                                <button type="button" class="btn btn-info btn-xs edit_payment" 
                                data-href="{{action('FeeTransactionPaymentController@edit', [$payment->id]) }}"><i class="glyphicon glyphicon-edit"></i></button>
                                &nbsp; 
                                @endif
                                <button type="button" class="btn btn-danger btn-xs delete_payment" 
                                data-href="{{ action('FeeTransactionPaymentController@destroy', [$payment->id]) }}"
                                ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                &nbsp;
                               {{-- <button type="button" class="btn btn-primary btn-xs view_payment" data-href="{{ action('TransactionPaymentController@viewPayment', [$payment->id]) }}">
                                  <i class="fa fa-eye" aria-hidden="true"></i>
                                </button> --}}
                              @if(!empty($payment->document_path))
                                &nbsp;
                                <a href="{{$payment->document_path}}" class="btn btn-success btn-xs" download="{{$payment->document_name}}"><i class="fa fa-download" data-toggle="tooltip" title="{{__('purchase.download_document')}}"></i></a>
                                @if(isFileImage($payment->document_name))
                                &nbsp;
                                  <button data-href="{{$payment->document_path}}" class="btn btn-info btn-xs view_uploaded_document" data-toggle="tooltip" title="{{__('lang_v1.view_document')}}"><i class="fa fa-picture-o"></i></button>
                                @endif

                              @endif
                              </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                              <td colspan="6">@lang('purchase.no_records_found')</td>
                            </tr>
                        @endforelse
                        </table>
                    </div>
                </div>
            </div
           
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">@lang( 'global_lang.save' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
        </div>
    </div>

    {!! Form::close() !!}

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
    