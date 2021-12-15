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
         {!! Form::open(['url' => action('HRM\HrmPayrollController@payrollAssignSearch'), 'method' => 'post', 'id' => 'search_employee_fee', 'files' => true]) !!}

         <div class="card">
             @php
             $group_name = __('hrm.payroll_for_month', ['date' => $month_name . ' ' . $year]);

             @endphp
             <div class="card-body">
                 <h6 class="card-title text-primary">@lang('lang.select_ground')</h6>
                 <hr>
                 <div class="row m-0">
                     <div class="col-md-3 p-2 ">
                         {!! Form::label('campus.employee', __('campus.campuses') . ':*') !!}
                         {!! Form::select('campus_id', $campuses, $campus_id, ['class' => 'form-select select2 global-campuses', 'required', 'id' => 'employees_list_filter_campus_id', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]) !!}
                     </div>
                     <div class="col-md-3 p-2">
                         {!! Form::label('month_year', __('hrm.month_year') . ':*') !!}
                         <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                             {!! Form::text('month_year', $month_year, ['class' => 'form-control', 'placeholder' => __('hrm.month_year'), 'required', 'readonly']) !!}

                         </div>
                     </div>
                     <div class="col-md-3 p-2">
                         {!! Form::label('payroll_group_name', __( 'hrm.payroll_group_name' ) . ':*') !!}
                         {!! Form::text('payroll_group_name', strip_tags($group_name), ['class' => 'form-control', 'placeholder' => __( 'hrm.payroll_group_name' ), 'required']); !!}

                     </div>
                     <div class="col-md-3 p-2">
                         {!! Form::label('status', __( 'hrm.status' ) . ':*') !!}
                         @show_tooltip(__('hrm.group_status_tooltip'))
                         {!! Form::select('status', ['final' => __('hrm.final'), 'pending' => __('hrm.pending')], $status, ['class' => 'form-control select2', 'required', 'style' => 'width: 100%;', 'placeholder' => __( 'messages.please_select' )]); !!}

                     </div>
                 </div>
                 <div class="d-lg-flex align-items-center mt-4 gap-3">
                     <div class="ms-auto"><button class="btn btn-primary radius-30 mt-2 mt-lg-0" type="submit">
                             <i class="fas fa-filter"></i>@lang('lang.filter')</button></div>
                 </div>
             </div>
         </div>


         {{ Form::close() }}
         <div class="row">
             <div class="col-lg-12">
                 <div class="card bg-warning bg-gradient">
                     <div class="card-body">
                         <div class="d-flex align-items-center">
                             <div class="font-35 text-dark"><i class="bx bx-info-circle"></i>
                             </div>
                             <div class="ms-3">
                                 <h6 class="mb-0 text-dark">Warning / Disclaimer</h6>
                                 <div class="text-dark">Basic Salary Amount Already You had Assigned
                                     During The Employee Registertion </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             @if (isset($employees))
             {!! Form::open(['url' => action('HRM\HrmPayrollController@store'), 'method' => 'post', 'class' => '', '' . 'id' => 'store_employee_fee', 'files' => true]) !!}


             <input type="hidden" name="month_year" value="{{ $month_year }}">
             {!! Form::hidden('transaction_date', $transaction_date); !!}
             {!! Form::hidden('status', $status); !!}
             {!! Form::hidden('payroll_group_name', strip_tags($group_name), ['class' => 'form-control', 'placeholder' => __( 'hrm.payroll_group_name' ), 'required']); !!}
            <input type="hidden" id="transaction_final_total" name="" value="0">
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
                                         <th class="text-center hide">@lang('hrm.day_wise')</th>
                                         <th class="text-center ">@lang('hrm.amount')</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @if(!empty($deductions))
                                     @foreach ($deductions as $deduction)
                                     <tr>
                                         <td class="text-center">
                                             <div class="mt-2">{{ $deduction->deduction }}</div>
                                         </td>
                                         <td class="text-center">
                                             {!! Form::checkbox('deductions[' . $loop->iteration . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 deduction-check']) !!} </td>
                                         </td>

                                         <td class="text-center hide ">
                                             <input name="deductions[{{ $loop->iteration }}][divider]" type="hidden" value="0" class="form-control deduction-divider">
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
                 <div class="col-lg-12">

                     <div class="card">
                         <div class="card-body">
                             <div class="table-responsive">
                                 <table class="table mb-0" width="100%" id="employees_table">
                                     <thead class="table-light" width="100%">
                                         <tr>
                                             {{-- <th>#</th> --}}

                                             <th> <input type="checkbox" id="checkAll" class="common-checkbox form-check-input mt-2" name="checkAll">
                                                 <label for="checkAll">@lang('lang.all')</label>
                                             </th>
                                             <th>@lang('hrm.employee_name')</th>
                                             <th>@lang('hrm.father_name')</th>
                                             <th>@lang('lang.status')</th>
                                             <th>@lang('hrm.employeeID')</th>
                                             <th>@lang('hrm.basic_salary')</th>
                                             <th>@lang('hrm.joining_date')</th>
                                             <th>@lang('campus.campus_name')</th>
                                         </tr>
                                     </thead>
                                     <tbody class="">
                                         @foreach ($employees as $employee)
                                         <tr>
                                             <td>
                                                 <input type="checkbox" id="employee.{{ $employee->id }}" class="common-checkbox form-check-input mt-2" name="employee_checked[]" value="{{ $employee->id }}" }}>
                                                 <label for="employee.{{ $employee->id }}"></label>
                                             </td>
                                             <td>{{ ucwords($employee->employee_name) }}
                                                 <input type="hidden" name="id[]" value="{{ $employee->id }}">
                                             </td>
                                             <td>{{ ucwords($employee->father_name) }}</td>
                                             <td>{{ $employee->status }}</td>
                                             <td>{{ $employee->employeeID }}</td>
                                             <td>{{ @num_format($employee->basic_salary)}}</td>
                                             <td>{{ @format_date($employee->joining_date)}}</td>
                                             <td>{{ ucwords($employee->campus_name) }}</td>
                                         </tr>
                                         @endforeach
                                     </tbody>
                                     @if ($employees->count() > 0)
                                     <tr>
                                         <td colspan="7">
                                             <div class="text-center">
                                                 <button type="submit" id="btn-assign-payroll-group" class="btn btn-primary radius-30 mt-2 mt-lg-0 fix-gr-bg mb-0 submit" id="btn-assign-payroll-group" data-loading-text="<i class='fas fa-spinner'></i> Processing Data">
                                                     <span class="ti-save pr"></span>
                                                     @lang('hrm.save') @lang('hrm.payroll')
                                                 </button>
                                             </div>
                                         </td>
                                     </tr>
                                     @endif
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

             {{ Form::close() }}
             @endif
         </div>
     </div>
     @endsection

     @section('javascript')
            <script src="{{ asset('js/hrm.js?v=' . $asset_v) }}"></script>

         <script type="text/javascript">
             $(document).ready(function() {
                 $('#month_year').datepicker({
                     autoclose: true,
                     format: 'mm/yyyy',
                     minViewMode: "months"
                 });

             




                 // payroll Assign
                 $("#checkAll").on("click", function() {
                     $(".common-checkbox").prop("checked", this.checked);
                 });

                 $(".common-checkbox").on("click", function() {
                     if (!$(this).is(":checked")) {
                         $("#checkAll").prop("checked", false);
                     }
                     var numberOfChecked = $(".common-checkbox:checked").length;
                     var totalCheckboxes = $(".common-checkbox").length;
                     var totalCheckboxes = totalCheckboxes - 1;

                     if (numberOfChecked == totalCheckboxes) {
                         $("#checkAll").prop("checked", true);
                     }
                 });


             


                 // payroll group assign

                 $("form#store_employee_fee").submit(function(event) {
                     var url = $("#url").val();
                     var employee_checked = $("input[name='employee_checked[]']:checked")
                         .map(function() {
                             return $(this).val();
                         })
                         .get();
                     if (employee_checked.length < 1) {
                         event.preventDefault();
                         toastr.error("Please select at least one employee");
                         return false;
                     }
                 });

             });
         </script>
     @endsection
