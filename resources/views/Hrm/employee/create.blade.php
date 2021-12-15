@extends("admin_layouts.app")
@section('wrapper')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">@lang('hrm.employee')</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('hrm.employee')</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            {!! Form::open(['url' => action('HRM\HrmEmployeeController@store'), 'method' => 'post', 'id' => 'employee_add_form', 'files' => true]) !!}

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-primary">@lang('hrm.add_new_employee')</h6>
                    <hr>

                    <h6 class="card-title text-info"><i class="fa fa-user p-1"></i>@lang('hrm.personal_details')</h6>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4 p-1">
                                    {!! Form::label('campus.campuses', __('campus.campuses') . ':*') !!}
                                    {!! Form::select('campus_id', $campuses, null, ['class' => 'form-select select2 campuses', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'), 'id' => 'campus_id']) !!}
                                </div>

                                <div class="col-md-4 p-1">
                                    {!! Form::label('employeeID', __('hrm.employee_id') . ':*', ['classs' => 'form-lable']) !!}
                                    {!! Form::text('employeeID', $admission_no, ['class' => 'form-control', 'required', 'readonly', 'placeholder' => __('hrm.employee_id')]) !!}

                                </div>
                                <div class="col-md-4 p-1">
                                    {!! Form::label('lang.first_name', __('lang.first_name') . ':*') !!}
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang.first_name')]) !!}
                                </div>
                                <div class="clearfix"></div>


                                <div class="col-md-4 p-1">
                                    {!! Form::label('lang.last_name', __('lang.last_name') . ':*') !!}
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('lang.last_name')]) !!}
                                </div>
                                <div class="col-md-4 p-1">
                                    {!! Form::label('lang.father_name', __('lang.father_name') . ':*') !!}
                                    {!! Form::text('father_name', null, ['class' => 'form-control', 'required', 'id' => 'father_name', 'placeholder' => __('lang.father_name')]) !!}
                                </div>
                                <div class="col-md-4 p-1">
                                    {!! Form::label('lang.gender', __('lang.gender') . ':*') !!}
                                    {!! Form::select('gender', ['male' => __('lang_v1.male'), 'female' => __('lang_v1.female'), 'others' => __('lang_v1.others')], null, ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-4 p-1">
                                    {!! Form::label('lang.date_of_birth', __('lang.date_of_birth') . ':*') !!}
                                    <div class="input-group flex-nowrap"> <span class="input-group-text"
                                            id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                        {!! Form::text('birth_date', @format_date('now'), ['class' => 'form-control start-date-picker', 'placeholder' => __('lang.date_of_birth')]) !!}

                                    </div>
                                </div>
                                <div class="col-md-4 p-1">
                                    {!! Form::label('hrm.joining_date', __('hrm.joining_date') . ':*') !!}
                                    <div class="input-group flex-nowrap"> <span class="input-group-text"
                                            id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                        {!! Form::text('joining_date', @format_date('now'), ['class' => 'form-control date-picker', 'readonly', 'placeholder' => __('hrm.joining_date')]) !!}

                                    </div>
                                </div>
                                <div class="col-md-4 p-1">
                                    {!! Form::label('lang.religion', __('lang.religion') . ':*') !!}
                                    {!! Form::select('religion', ['Islam' => 'Islam', 'Hinduism' => 'Hinduism', 'Christianity' => 'Christianity', 'Sikhism' => 'Sikhism', 'Buddhism' => 'Buddhism', 'Secular/Nonreligious/Agnostic/Atheist' => 'Secular/Nonreligious/Atheist', 'Other' => 'Other'], 'Islam', ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                                </div>


                                <div class="clearfix"></div>
                                <div class="col-md-3 p-1">
                                    {!! Form::label('mobile', __('lang_v1.mobile') . ':') !!}
                                    <input type="text" name="mobile_no" class="mobile form-control" value="3 ">

                                </div>


                                <div class="col-md-3 p-1">
                                    {!! Form::label('lang.cnic_number', __('lang.cnic_number') . ':*') !!}
                                    {!! Form::text('cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]) !!}
                                </div>
                                <div class="col-md-3 p-1">
                                    {!! Form::label('lang.blood_group', __('lang.blood_group') . ':') !!}
                                    {!! Form::select('blood_group', ['O+' => 'O+', 'O-' => 'O-', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-'], null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-md-3 p-1">
                                    {!! Form::label('nationality', __('lang.nationality') . ':') !!}
                                    {!! Form::text('nationality', 'Pakistani', ['class' => 'form-control', 'placeholder' => __('lang.nationality')]) !!}

                                </div>
                                <div class="col-md-3 p-1">
                                    {!! Form::label('mother_tongue', __('lang.mother_tongue') . ':') !!}
                                    {!! Form::text('mother_tongue', null, ['class' => 'form-control', 'placeholder' => __('lang.mother_tongue')]) !!}

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="{{ url('/uploads/employee_image/default.png') }}"
                                        class="employee_image card-img-top" width="192px" height="200px" alt="...">
                                    {!! Form::label('employee_image', __('hrm.employee_image') . ':') !!}
                                    {!! Form::file('employee_image', ['accept' => 'image/*', 'class' => 'form-control upload_employee_image']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">

                        <div class="col-md-6">

                            <div class="row">
                                <div class="card border-top border-0 border-4 border-info">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="fas fa-address-card me-1 font-22 text-info"></i>
                                            </div>
                                            <h5 class="mb-0 text-info">@lang('hrm.address_details')</h5>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            {!! Form::label('country_id', __('lang.country_name') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::select('country_id', $countries, null, ['class' => 'form-select select2 ', 'required', 'id' => 'country_id', 'style' => 'width:100%', 'required', 'placeholder' => __('lang.please_select')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {!! Form::label('province_id', __('lang.province_name') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::select('province_id', [], null, ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'required', 'id' => 'provinces_ids', 'placeholder' => __('lang.please_select')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {!! Form::label('district_id', __('lang.district_name') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::select('district_id', [], null, ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'required', 'id' => 'district_ids', 'placeholder' => __('lang.district_name')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {!! Form::label('city_id', __('lang.city_name') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::select('city_id', [], null, ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'required', 'id' => 'city_ids', 'placeholder' => __('lang.city_name')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {!! Form::label('region_id', __('lang.regions') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::select('region_id', [], null, ['class' => 'form-select select2 ', 'required', 'id' => 'region_ids', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {!! Form::label('current_address', __('lang.current_address') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::textarea('current_address', null, ['class' => 'form-control ', 'rows' => 1, 'placeholder' => __('lang.current_address')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            {!! Form::label('permanent_address', __('lang.permanent_address') . ':*', ['class' => 'col-sm-4 col-form-label']) !!}

                                            <div class="col-sm-8">
                                                {!! Form::textarea('permanent_address', null, ['class' => 'form-control ', 'rows' => 1, 'placeholder' => __('lang.permanent_address')]) !!}

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="row">
                                <div class="card border-top border-0 border-4 border-info">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-center">
                                            <div><i class="fas fa-money-bill-alt  me-1 font-22 text-info"></i>
                                            </div>
                                            <h5 class="mb-0 text-info">@lang('hrm.bank_details')</h5>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <label for="inputEnterYourName"
                                                class="col-sm-4 col-form-label">@lang('hrm.account_holder')</label>
                                            <div class="col-sm-8">
                                                {!! Form::text('bank_details[account_name]', null, ['class' => 'form-control', 'placeholder' => __('hrm.account_holder')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="account_number"
                                                class="col-sm-4 col-form-label">@lang('hrm.account_number')</label>
                                            <div class="col-sm-8">
                                                {!! Form::text('bank_details[account_number]', null, ['class' => 'form-control', 'placeholder' => __('hrm.account_number')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="bank" class="col-sm-4 col-form-label">@lang('hrm.bank')</label>
                                            <div class="col-sm-8">
                                                {!! Form::text('bank_details[bank]', null, ['class' => 'form-control', 'placeholder' => __('hrm.bank')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="bin" class="col-sm-4 col-form-label">@lang('hrm.bin')</label>
                                            <div class="col-sm-8">
                                                {!! Form::text('bank_details[bin]', null, ['class' => 'form-control', 'placeholder' => __('hrm.bin')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="branch" class="col-sm-4 col-form-label">@lang('hrm.branch')</label>
                                            <div class="col-sm-8">
                                                {!! Form::text('bank_details[branch]', null, ['class' => 'form-control', 'placeholder' => __('hrm.branch')]) !!}

                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tax_payer_id"
                                                class="col-sm-4 col-form-label">@lang('hrm.tax_payer_id')</label>
                                            <div class="col-sm-8">
                                                {!! Form::text('bank_details[tax_payer_id]', null, ['class' => 'form-control', 'placeholder' => __('hrm.tax_payer_id')]) !!}

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row pt-4">

                        <h5 class="card-title text-info">@lang('hrm.hrm_details')</h5>

                        <div class="col-md-4  p-1">
                            {!! Form::label('hrm.departments', __('hrm.departments') . ':*') !!}
                            {!! Form::select('department_id', $departments, null, ['class' => 'form-select select2', 'style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'id' => 'department_id']) !!}
                        </div>
                        <div class="col-md-4  p-1">
                            {!! Form::label('hrm.designations', __('hrm.designations') . ':*') !!}
                            {!! Form::select('designation_id', $designations, null, ['class' => 'form-select select2', 'style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'id' => 'designation_id']) !!}
                        </div>
                        <div class="col-md-4  p-1">
                            {!! Form::label('hrm.educations', __('hrm.educations') . ':*') !!}
                            {!! Form::select('education_id', $educations, null, ['class' => 'form-select select2', 'style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'id' => 'education_id']) !!}
                        </div>


                    </div>
                    <div class="row pt-4">

                        <h5 class="card-title text-info">@lang('hrm.payroll_details')</h5>

                        <div class="col-md-6  p-1">
                            {!! Form::label('hrm.basic_salary', __('hrm.basic_salary') . ':*') !!}
                            <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                                        class="fas fa-money-bill-alt"></i></span>
                                {!! Form::number('basic_salary', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __('hrm.basic_salary'), 'id' => 'basic salary']) !!}
                                {!! Form::select('pay_period', ['month' => __('hrm.per') . ' ' . __('hrm.month'), 'week' => __('hrm.per') . ' ' . __('hrm.week'), 'day' => __('hrm.per') . ' ' . __('hrm.day')], null, ['class' => 'width-60 pull-left form-select select2']) !!}

                            </div>
                        </div>
                        <div class="col-md-6 p-1">
                            {!! Form::label('remark', __('lang.remark') . ':') !!}
                            {!! Form::textarea('remark', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('lang.remark')]) !!}

                        </div>

                    </div>
                    <div class="row pt-4">

                        <h5 class="card-title text-info">@lang('hrm.roles_and_permissions')</h5>
                        <div class="col-md-4 p-1">
                            {!! Form::label('email', __('lang.email') . ':') !!}
                            {!! Form::email('email', $admission_no.'@gmail.com', ['class' => 'form-control', 'placeholder' => __('lang.email'), 'id' => 'email']) !!}
                        </div>
                        <div class="col-md-4  p-1">
                            {!! Form::label('password', __('hrm.password') . ':*') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('hrm.password')]) !!}

                        </div>
                        <div class="col-md-4 p-1">
                            {!! Form::label('confirm_password', __('hrm.confirm_password') . ':*') !!}
                            {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => __('hrm.confirm_password')]) !!}

                        </div>

                    </div>
                    <div class="row pt-4">
                        <h5 class="card-title text-info">@lang('hrm.document_details')</h5>


                        <div class="col-md-4  p-1">
                            {!! Form::label('resume', __('hrm.attach_resume') . ':') !!}
                            {!! Form::file('resume', ['class' => 'form-control upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]) !!}
                            @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                            @includeIf('components.document_help_text')

                        </div>
                        <div class="col-md-4  p-1">
                            {!! Form::label('offerLetter', __('hrm.attach_offerLetter') . ':') !!}
                            {!! Form::file('offerLetter', ['class' => 'form-control upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]) !!}
                            @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                            @includeIf('components.document_help_text')

                        </div>
                        <div class="col-md-4  p-1">
                            {!! Form::label('joiningLetter', __('hrm.attach_joiningLetter') . ':') !!}
                            {!! Form::file('joiningLetter', ['class' => 'form-control upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]) !!}
                            @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                            @includeIf('components.document_help_text')

                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-4  p-1">
                            {!! Form::label('contractOrAgreement', __('hrm.attach_contractOrAgreement') . ':') !!}
                            {!! Form::file('contract', ['class' => 'form-control upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]) !!}
                            @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                            @includeIf('components.document_help_text')

                        </div>
                        <div class="col-md-4  p-1">
                            {!! Form::label('IDProof', __('hrm.attach_IDProof') . ':') !!}
                            {!! Form::file('IDProof', ['class' => 'form-control upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]) !!}
                            @lang('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)])
                            @includeIf('components.document_help_text')

                        </div>


                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">

                        <div class="d-lg-flex align-items-center mb-4 gap-3">
                            <div class="ms-auto">
                                <button class="btn- btn btn-primary radius-30 mt-2 mt-lg-0">@lang('messages.save')</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--end row-->


        {!! Form::close() !!}

    </div>
    </div>
@endsection

@section('javascript')
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.date-picker').datepicker();
            $('.cnic').inputmask('99999-9999999-9');
            $('.mobile').inputmask('09999999999');

            $(".upload_employee_image").on('change', function() {
                __readURL(this, '.employee_image');
            });



  $('form#employee_add_form').validate({
                rules: {
                       first_name: {
                        required: true,
                    },
                    email: {
                        email: false,
                        remote: {
                            url: "/employee/register/check-email",
                            type: "post",
                            data: {
                                email: function() {
                                    return $( "#email" ).val();
                                }
                            }
                        }
                    },
                    password: {
                        required: false,
                        minlength: 8
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                 
                },
                messages: {
                    password: {
                        minlength: 'Password should be minimum 8 characters',
                    },
                    confirm_password: {
                        equalTo: 'Should be same as password'
                    },
                      email: {
                        remote: '{{ __("validation.unique", ["attribute" => __("business.email")]) }}'
                    }
                }
            });


        });
    </script>
@endsection
