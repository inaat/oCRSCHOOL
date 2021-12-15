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
             {!! Form::open(['url' => action('HRM\HrmPayrollController@payrollAssignSearch'), 'method' => 'post', 'class' => 'needs-validation was-validated', 'novalidate' . 'id' => 'search_student_fee', 'files' => true]) !!}

             <div class="card">

                 <div class="card-body">
                     <h6 class="card-title text-primary">@lang('lang.select_ground')</h6>
                     <hr>
                     <div class="row m-0">
                         <div class="col-md-3 p-2 ">
                             {!! Form::label('campus_id', __('campus.campuses') . ':*') !!}
                             {!! Form::select('campus_id', $campuses, null, ['class' => 'form-select select2', 'required', 'id' => 'students_list_filter_campus_id', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]) !!}
                         </div>
                         <div class="col-md-3 p-2">
                             {!! Form::label('month_year', __('hrm.month_year') . ':*') !!}
                             <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                         class="fa fa-calendar"></i></span>

                                 {!! Form::text('month_year', null, ['class' => 'form-control', 'placeholder' => __('hrm.month_year'), 'required', 'readonly']) !!}

                             </div>
                         </div>
                         <div class="col-md-3 p-2">
                             {!! Form::label('status', __('hrm.status') . ':*') !!}
                             @show_tooltip(__('hrm.group_status_tooltip'))
                             {!! Form::select('status', ['final' => __('hrm.final'), 'pending' => __('hrm.pending')], 'final', ['class' => 'form-control select2', 'required', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select')]) !!}

                         </div>
                     </div>
                     <div class="d-lg-flex align-items-center mt-4 gap-3">
                         <div class="ms-auto"><button class="btn btn-primary radius-30 mt-2 mt-lg-0" type="submit">
                                 <i class="fas fa-filter"></i>@lang('lang.filter')</button></div>
                     </div>
                 </div>
             </div>


             {{ Form::close() }}



         </div>
     </div>

 @endsection

 @section('javascript')

     <script type="text/javascript">
         $(document).ready(function() {

             $('#month_year').datepicker({
                 autoclose: true,
                 format: 'mm/yyyy',
                 minViewMode: "months"
             });


         });
     </script>
 @endsection
