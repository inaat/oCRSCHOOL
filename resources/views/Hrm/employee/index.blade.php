 @extends("admin_layouts.app")
 @section('wrapper')
     <div class="page-wrapper">
         <div class="page-content">
             <!--breadcrumb-->
             <div class="card">
                 <div class="card-body">
                     <div class="accordion" id="employee-fillter">
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="employee-fillter">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                     data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                     <h5 class="card-title">@lang('hrm.employees_flitters')</h5>
                                 </button>
                             </h2>
                             <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="employee-fillter"
                                 data-bs-parent="#employee-fillter" style="">
                                 <div class="accordion-body">
                                     <div class="row">
                                         <div class="col-md-3 p-1">
                                             {!! Form::label('campus_id', __('campus.campuses') . ':*') !!}
                                             {!! Form::select('campus_id', $campuses, null, ['class' => 'form-select select2 global-campuses', 'required', 'id' => 'employees_list_filter_campus_id', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]) !!}
                                         </div>
                                         <div class="col-md-3 p-1">
                                             {!! Form::label('employeeID', __('hrm.employeeID')) !!}
                                             {!! Form::text('employeeID', null, ['class' => 'form-control', 'placeholder' => __('hrm.employeeID'), 'id' => 'employees_list_filter_employeeID']) !!}
                                         </div>
                                         <div class="col-md-3 p-1">
                                             {!! Form::label('status', __('hrm.employee_status') . ':*') !!}
                                             {!! Form::select('employees_list_filter', __('hrm.emp_status'), null, ['class' => 'form-select', 'id' => 'employees_list_filter', 'placeholder' => __('messages.all'), 'required']) !!}
                                         </div>
                                         <div class="col-md-3 p-1">
                                             {!! Form::label('hrm.joining_date', __('hrm.joining_date') . ':*') !!}
                                             <div class="input-group flex-nowrap"> <span class="input-group-text"
                                                     id="addon-wrapping"><i class="fa fa-calendar"></i></span>
                                                 {!! Form::text('employees_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'id' => 'employees_list_filter_date_range', 'class' => 'form-control', 'readonly']) !!}

                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>





             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title text-primary">@lang('hrm.employee_list')</h5>

                     <div class="d-lg-flex align-items-center mb-4 gap-3">
                         <div class="ms-auto"><a class="btn btn-primary radius-30 mt-2 mt-lg-0"
                                 href="{{ action('HRM\HrmEmployeeController@create') }}">
                                 <i class="bx bxs-plus-square"></i>@lang('hrm.add_new_employee')</a></div>
                     </div>


                     <hr>

                     <div class="table-responsive">
                         <table class="table mb-0" width="100%" id="employees_table">
                             <thead class="table-light" width="100%">
                                 <tr>
                                     {{-- <th>#</th> --}}
                                     <th>@lang('lang.action')</th>
                                     <th>@lang('hrm.employee_name')</th>
                                     <th>@lang('hrm.father_name')</th>
                                     <th>@lang('lang.status')</th>
                                     <th>@lang('hrm.employeeID')</th>
                                     <th>@lang('hrm.joining_date')</th>
                                     <th>@lang('campus.campus_name')</th>

                                 </tr>
                             </thead>

                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
    
     <div class="modal fade pay_payroll_due_modal contains_select2" tabindex="-1" role="dialog"
         aria-labelledby="gridSystemModalLabel">
     </div>
     @include('Hrm/employee.partials.update_employee_status_modal')
     @include('Hrm/employee.partials.employee_resign_modal')

 @endsection

 @section('javascript')

     <script type="text/javascript">
         $(document).ready(function() {


             $(document).on('click', '.update_status', function(e) {
                 e.preventDefault();
                 $('#update_employee_status_form').find('#status').val($(this).data('status'));
                 $('#update_employee_status_form').find('#employee_id').val($(this).data('employee_id'));
                 $('#update_employee_status_modal').modal('show');
             });
             $(document).on('submit', '#update_employee_status_form', function(e) {
                 e.preventDefault();
                 var form = $(this);

                 var data = form.serialize();

                 $.ajax({
                     method: 'POST',
                     url: $(this).attr('action'),
                     dataType: 'json',
                     data: data,
                     beforeSend: function(xhr) {
                         __disable_submit_button(form.find('button[type="submit"]'));
                     },
                     success: function(result) {
                         if (result.success == true) {
                             $('#update_employee_status_modal').modal('hide');
                             toastr.success(result.msg);
                             employees_table.ajax.reload();
                             $('#update_employee_status_form')
                                 .find('button[type="submit"]')
                                 .attr('disabled', false);
                         } else {
                             toastr.error(result.msg);
                         }
                     },
                 });
             });
             $(document).on('click', '.employee_resign', function(e) {
                 e.preventDefault();
                 $('#employee_resign_form').find('#employee_name').text($(this).data('employee-name'));
                 $('#employee_resign_form').find('#employee_id').val($(this).data('employee_id'));
                 $('#employee_resign_modal').modal('show');
             });


             $(document).on('submit', '#employee_resign_form', function(e) {
                 e.preventDefault();
                 var form = $(this);
                 $.ajax({
                     method: 'POST',
                     url: $(this).attr('action'),
                     data: new FormData(this),
                     dataType: 'json',
                     contentType: false,
                     cache: false,
                     processData: false,

                     beforeSend: function(xhr) {
                         __disable_submit_button(form.find('button[type="submit"]'));
                     },
                     success: function(result) {
                         if (result.success == true) {
                             $('#employee_resign_modal').modal('hide');
                             toastr.success(result.msg);
                             employees_table.ajax.reload();
                             $('#employee_resign_form')
                                 .find('button[type="submit"]')
                                 .attr('disabled', false);
                         } else {
                             toastr.error(result.msg);
                         }
                     },
                 });
             });


             //Date range as a button
             $('#employees_list_filter_date_range').daterangepicker(
                 dateRangeSettingsForAdmissionDate,
                 function(start, end) {
                     $('#employees_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end
                         .format(moment_date_format));
                     employees_table.ajax.reload();
                 }
             );
             $('#employees_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                 $('#employees_list_filter_date_range').val('');
                 employees_table.ajax.reload();
             });
             $(document).on('change',
                 '#employees_list_filter_campus_id,#employees_list_filter',
                 function() {
                     employees_table.ajax.reload();
                 });
             $(document).on('keyup', '#employees_list_filter_admission_no,#employees_list_filter_employeeID',
                 function() {
                     employees_table.ajax.reload();
                 });

             //employees_table
             var employees_table = $("#employees_table").DataTable({
                 processing: true,
                 serverSide: true,
                 "ajax": {
                     "url": "/hrm-employee",
                     "data": function(d) {
                         if ($('#employees_list_filter_date_range').val()) {
                             var start = $('#employees_list_filter_date_range').data('daterangepicker')
                                 .startDate.format('YYYY-MM-DD');
                             var end = $('#employees_list_filter_date_range').data('daterangepicker')
                                 .endDate.format('YYYY-MM-DD');
                             d.start_date = start;
                             d.end_date = end;
                         }

                         if ($('#employees_list_filter_campus_id').length) {
                             d.campus_id = $('#employees_list_filter_campus_id').val();
                         }
                         if ($('#employees_list_filter').length) {
                             d.status = $('#employees_list_filter').val();
                         }
                         if ($('#employees_list_filter_employeeID').length) {
                             d.employeeID = $('#employees_list_filter_employeeID').val();
                         }
                         d = __datatable_ajax_callback(d);
                     }
                 }

                 ,
                 columns: [{
                         data: "action",
                         name: "action",
                         orderable: false,
                         "searchable": false
                     }

                     , {
                         data: "employee_name",
                         name: "employee_name"
                     }, {
                         data: "father_name",
                         name: "father_name"
                     }, {
                         data: "status",
                         name: "status",
                         orderable: false,
                         "searchable": false
                     }, {
                         data: "employeeID",
                         name: "employeeID"
                     }, {
                         data: "joining_date",
                         name: "joining_date"
                     }, {
                         data: "campus_name",
                         name: "campus_name",
                         orderable: false,
                         "searchable": false
                     }

                     ,
                 ],
             });




         });
     </script>
 @endsection
