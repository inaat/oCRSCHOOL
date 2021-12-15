 @extends("admin_layouts.app")
 @section('wrapper')
 <div class="page-wrapper">
     <div class="page-content">
         <!--breadcrumb-->
         <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
             <div class="breadcrumb-title pe-3">@lang('hrm.payroll_allocation')</div>
             <div class="ps-3">
                 <nav aria-label="breadcrumb">
                     <ol class="breadcrumb mb-0 p-0">
                         <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                         </li>
                         <li class="breadcrumb-item active" aria-current="page">@lang('hrm.payroll_allocation')</li>
                     </ol>
                 </nav>
             </div>
         </div>
         <!--end breadcrumb-->

         <div class="row ">
             <div class="col-md-6">
                 <div class="card card-body bg-light">
                     <p>
                         <strong>@lang('campus.campus_name'):
                         </strong>({{ ucwords($transaction->campus->campus_name) }})<br>
                         <strong>@lang('hrm.employee_name'):
                         </strong>({{ ucwords($transaction->employee->first_name . ' ' . $transaction->employee->last_name) }})<br>
                         <strong>@lang('hrm.father_name'):
                         </strong>{{ ucwords($transaction->employee->father_name) }}<br>
                         <strong>@lang('hrm.employeeID'): </strong>{{ ucwords($transaction->employee->employeeID) }}<br>
                         <strong>@lang('hrm.basic_salary'): </strong>@format_currency($transaction->employee->basic_salary)
                         <input type="hidden" id="transaction_final_total" name="" value="{{$transaction->employee->basic_salary }}">

                     </p>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="card card-body bg-light">
                     <p>
                         <strong>@lang('hrm.ref_no'):
                         </strong>({{ ucwords($transaction->ref_no) }})<br>
                         <strong>@lang('hrm.transaction_date'):
                         </strong>{{ @format_date($transaction->transaction_date) }}<br>
                         <strong>@lang('lang.payment_status'):
                         </strong>{{ ucwords($transaction->payment_status) }}<br>
                         <strong>@lang('lang.total_amount'): </strong><span class="display_currency" data-currency_symbol="true">{{ $transaction->final_total }}</span><br>

                     </p>
                 </div>
             </div>
         </div>
         {!! Form::open(['url' => action('HRM\HrmPayrollController@update', [$transaction->id]), 'method' => 'PUT', 'id' => 'pay_roll_edit_form']) !!}
         <input type="hidden" name="deduction_amount" id="deduction_final_total"  value="0"/>
         <input type="hidden" name="allowance_amount" id="allowance_final_total" value="0"/>


         <div class="row">
             <div class="col-lg-6">
                 <div class="card ">
                     <div class="card-body">
                         <table id="" class="allowance-table table table-condensed table-striped " id="allowance-table">
                             <thead>
                                 <tr>
                                     <th class="text-center">@lang('hrm.allowances')</th>
                                     <th class="text-center">@lang('hrm.enable')</th>
                                     <th class="text-center ">@lang('hrm.amount')</th>
                                 </tr>
                             </thead>
                             <tbody>
                             
                                 @if(!empty($transaction->allowance))
                                 @foreach ($transaction->allowance as $allowance)
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2">{{ $allowance->hrm_allowance->allowance }}</div>
                                     </td> 
                                     <td class="text-center">
                                         {!! Form::checkbox('allowances[' . $loop->iteration . '][is_enabled]', 1,$allowance->is_enabled, ['class' => 'form-check-input mt-2 allowance-check']) !!} </td>
                                     </td>
                                     <td class="text-center ">
                                        {!! Form::text('allowances['.$loop->iteration.'][amount]',@num_format($allowance->amount), ['class' => 'form-control input_number allowance-amount']); !!}

                                         <input type="hidden" name="allowances[{{ $loop->iteration }}][allowance_line_id]" value="{{ $allowance->id }}">

                                     </td>
                                 </tr>
                                 @endforeach
                                 @endif
                                 @if(!empty($allowances))
                                 @foreach ($allowances as $allowance)
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2">{{ $allowance->allowance }}</div>
                                     </td>
                                     <td class="text-center">
                                         {!! Form::checkbox('allowances[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 allowance-check']) !!} </td>
                                     </td>

                                     <td class="text-center ">
                                        {!! Form::text('allowances['.$loop->iteration.'][amount]', 0, ['class' => 'form-control input_number allowance-amount']); !!}

                                         <input type="hidden" name="allowances[{{ $loop->iteration }}][allowance_id]" value="{{ $allowance->id }}">

                                     </td>
                                 </tr>
                                 @endforeach
                                 @endif
                             <tfoot>
                                 <tr>
                                     <th colspan="2" class="text-center">Total</th>
                                     <td><span class="allowance_final_total">0</span></td>
                                 </tr>
                             </tfoot>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="card ">
                     <div class="card-body">
                         <table id="" class="deduction-table table table-condensed table-striped " id="deduction-table">
                             <thead>
                                 <tr>
                                     <th class="text-center">@lang('hrm.deductions')</th>
                                     <th class="text-center">@lang('hrm.enable')</th>
                                     <th class="text-center">@lang('hrm.day_wise')</th>
                                     <th class="text-center ">@lang('hrm.amount')</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @if(!empty($transaction->deduction))

                                 @foreach ($transaction->deduction as $deduction)
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2">{{ $deduction->hrm_deduction->deduction }}</div>
                                     </td>
                                     <td class="text-center">
                                         {!! Form::checkbox('deductions[' . $loop->iteration . '][is_enabled]', 1, $deduction->is_enabled, ['class' => 'form-check-input mt-2 deduction-check']) !!} </td>
                                     </td>

                                     <td class="text-center ">
                                         <input name="deductions[{{ $loop->iteration }}][divider]" type="number" value="{{ $deduction->divider }}" class="form-control deduction-divider">
                                     <td class="text-center ">
                                         <input type="hidden" name="deductions[{{ $loop->iteration }}][deduction_line_id]" value="{{ $deduction->id }}">
                                    {!! Form::text('deductions['.$loop->iteration.'][amount]', @num_format($deduction->amount), ['class' => 'form-control input_number deduction-amount']); !!}

                                     </td>
                                 </tr>
                                 @endforeach
                                 @endif
                                 @if(!empty($deductions))
                                 @foreach ($deductions as $deduction)
                                 <tr>
                                     <td class="text-center">
                                         <div class="mt-2">{{ $deduction->deduction }}</div>
                                     </td>
                                     <td class="text-center">
                                         {!! Form::checkbox('deductions[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 deduction-check']) !!} </td>
                                     </td>

                                     <td class="text-center ">
                                         <input name="deductions[{{ $loop->iteration }}][divider]" type="number" value="0" class="form-control deduction-divider">
                                     <td class="text-center ">
                                         <input type="hidden" name="deductions[{{ $loop->iteration }}][deduction_id]" value="{{ $deduction->id }}">
                                    {!! Form::text('deductions['.$loop->iteration.'][amount]', 0, ['class' => 'form-control input_number deduction-amount']); !!}

                                     </td>
                                 </tr>
                                 @endforeach
                                 @endif
                             <tfoot>
                                 <tr>
                                     <th colspan="2" class="text-center">Total</th>
                                     <td><span class="deduction_final_total">0</span></td>
                                 </tr>
                             </tfoot>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="card ">
                 <div class="card-body">

                     <h5 class="card-title text-primary text-center">Gross Amount :
                         <span class="gross_final_total">@format_currency($transaction->final_total)</span></h5>
                     <input type="hidden" name="gross_final_total" id="gross_final_total" value="{{ $transaction->final_total }}">


                     <div class="d-lg-flex align-items-center mb-4 gap-3">
                         <div class="ms-auto">
                             <button class="btn- btn btn-primary radius-30 mt-2 mt-lg-0">@lang('messages.update')</button>
                         </div>

                     </div>
                 </div>
             </div>
         </div>


         {!! Form::close() !!}
     </div>
     @endsection

     @section('javascript')
            <script src="{{ asset('js/hrm.js?v=' . $asset_v) }}"></script>

    
     @endsection
