@extends("admin_layouts.app")
@section('wrapper')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">@lang('campus.campus_details')</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('campus.campuses')</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        {!! Form::open(['url' => action('\App\Http\Controllers\StudentController@store'), 'method' => 'post', 'class'=>'needs-validation was-validated','novalidate'.'id' =>'student_add_form' ]) !!}

        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-primary">@lang('campus.add_new_campus')</h6>
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4 p-1">
                                {!! Form::label('campus.campuses', __('campus.campuses') . ':*') !!}
                                {!! Form::select('campus_id',$campuses,null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'),'id' =>'campus_id']) !!}
                            </div>
                            <div class="col-md-4 p-1">
                                {!! Form::label('session.sessions', __('session.sessions') . ':*') !!}
                                {!! Form::select('admission_session_id',$sessions,null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'),'id'=>'session_id']) !!}
                            </div>
                            <div class="col-md-4 p-1">
                                {!! Form::label('admission_no', __('student.admission_no') . ':*', ['classs' => 'form-lable']) !!}
                                {!! Form::text('admission_no',$admission_no, ['class' => 'form-control', 'required', 'readonly','placeholder' => __('student.admission_no')]) !!}

                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.admission_date', __('student.admission_date') . ':*') !!}
                                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                    {!! Form::text('birth_date',@format_date('now'), ['class' => 'form-control date-picker', 'readonly', 'placeholder' => __('student.admission_date')]) !!}

                                </div>
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('roll_no', __('student.roll_no') . ':*') !!}
                                {!! Form::text('roll_no', null, ['class' => 'form-control','required','readonly', 'placeholder' => __('student.roll_no'),'id' => 'roll_no']) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('class.classes', __('class.classes') . ':*') !!}
                                {!! Form::select('admission_class_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'),'id' =>'class_ids']) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('class_section.sections', __('class_section.sections') . ':*') !!}
                                {!! Form::select('admission_class_section_id',[],null, ['class' => 'form-select select2 ','id'=>'class_section_ids','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                {!! Form::label('student.first_name', __('student.first_name') . ':*') !!}
                                {!! Form::text('first_name', null, ['class' => 'form-control','required', 'placeholder' => __('student.first_name')]) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.last_name', __('student.last_name') . ':*') !!}
                                {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('student.last_name')]) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.gender', __('student.gender') . ':*') !!}
                                {!! Form::select('class_id', ['male' => __('lang_v1.male'), 'female' => __('lang_v1.female'), 'others' => __('lang_v1.others')],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                            </div>
                              <div class="col-md-3 p-1">
                                {!! Form::label('student.date_of_birth', __('student.date_of_birth') . ':*') !!}
                                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                    {!! Form::text('birth_date',@format_date('now'), ['class' => 'form-control start-date-picker', 'placeholder' => __('student.date_of_birth')]) !!}

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.student_categories', __('student.student_categories') . ':*') !!}
                                {!! Form::select('category_id',$categories,null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.domicile', __('student.domicile') . ':*') !!}
                                {!! Form::text('domicile', null, ['class' => 'form-control', 'placeholder' => __('student.domicile')]) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.religion', __('student.religion') . ':*') !!}
                                {!! Form::select('religion',['Islam'=>'Islam', 'Hinduism'=>'Hinduism', 'Christianity'=>'Christianity','Sikhism'=>'Sikhism','Buddhism'=>'Buddhism','Secular/Nonreligious/Agnostic/Atheist'=>'Secular/Nonreligious/Atheist','Other'=>'Other'],'Islam', ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                            </div>
                            
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.caste', __('student.caste') . ':*') !!}
                                {!! Form::text('caste', null, ['class' => 'form-control', 'placeholder' => __('student.caste')]) !!}
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                {!! Form::label('mobile', __('lang_v1.mobile') . ':') !!}
                                <input type="text" name="mobile_no" class="mobile form-control" value="92 ">

                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('email', __('student.email') . ':') !!}
                                {!! Form::email('email', null, ['class' => 'form-control','placeholder' => __('student.email'),'id' => 'student_email'])  !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.cnic_number', __('student.cnic_number') . ':*') !!}
                                {!! Form::text('cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]) !!}
                            </div>
                               <div class="col-md-3 p-1">
                                {!! Form::label('student.blood_group', __('student.blood_group') . ':') !!}
                                {!! Form::select('blood_group',['O+', 'O-', 'A+','A-','B+','B-','AB+','AB-'],null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                            </div>
                            <div class="clearfix"></div>

                         
                            <div class="col-md-3 p-1">
                                {!! Form::label('nationality', __('student.nationality') . ':') !!}
                                {!! Form::text('nationality', 'Pakistani', ['class' => 'form-control','placeholder' => __('student.nationality')]) !!}

                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('mother_tongue', __('student.mother_tongue') . ':') !!}
                                {!! Form::text('mother_tongue', null, ['class' => 'form-control','placeholder' => __('student.mother_tongue')]) !!}

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title ">@lang('student.student_image')</h5>
                                <img src="https://demo.unlimitededufirm.com/assets/images/avatars/profile-pic.jpg" class="student_image card-img-top" width="192px" height="192px" alt="...">
                                {!! Form::label('student_image', __('student.student_image') . ':') !!}
                                {!! Form::file('student_image', ['accept' => 'image/*','class' => 'form-control upload_student_image']); !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Parent Guardian Detail --}}
                <div class="row pt-4">
                    <h5 class="card-title text-primary">@lang('student.parent_detail')</h5>

                    <div class="col-md-3 p-1">
                        {!! Form::label('student.father_name', __('student.father_name') . ':*') !!}
                        {!! Form::text('father_name', null, ['class' => 'form-control', 'required','placeholder' => __('student.father_name')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.father_phone', __('student.father_phone') . ':*') !!}
                        {!! Form::text('father_phone', 92, ['class' => 'form-control mobile','required', 'placeholder' => __('student.father_phone')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.father_occupation', __('student.father_occupation') . ':*') !!}
                        {!! Form::text('father_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.father_occupation')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.father_cnic_no', __('student.father_cnic_no') . ':*') !!}
                        {!! Form::text('father_cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]) !!}
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.mother_name', __('student.mother_name') . ':*') !!}
                        {!! Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => __('student.mother_name')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.mother_phone', __('student.mother_phone') . ':*') !!}
                        {!! Form::text('mother_phone', 92, ['class' => 'form-control mobile', 'placeholder' => __('student.mother_phone')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.mother_occupation', __('student.mother_occupation') . ':*') !!}
                        {!! Form::text('mother_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.mother_occupation')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.mother_cnic_no', __('student.mother_cnic_no') . ':*') !!}
                        {!! Form::text('mother_cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]) !!}
                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>@lang('student.if_guardian_is')<small class="req form-check-label"> *</small>&nbsp;&nbsp;&nbsp;</label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" required value="father" autocomplete="off"> @lang('student.father') </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" value="mother" autocomplete="off"> @lang('student.mother') </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" value="other" autocomplete="off"> @lang('student.other') </label>
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-md-10">
                        <div class="row">
                            <h5 class="card-title text-primary">@lang('student.parent_guardian_detail')</h5>

                            <div class="col-md-3 p-1">
                                {!! Form::label('student.guardian_name', __('student.guardian_name') . ':*') !!}
                                {!! Form::text('guardian[guardian_name]', null, ['class' => 'form-control', 'required','placeholder' => __('student.guardian_name')]) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.guardian_relation', __('student.guardian_relation') . ':*') !!}
                                {!! Form::text('guardian_relation', null, ['class' => 'form-control', 'required','placeholder' => __('student.guardian_relation')]) !!}
                            </div>

                            <div class="col-md-3 p-1">
                                {!! Form::label('student.guardian_occupation', __('student.guardian_occupation') . ':*') !!}
                                {!! Form::text('guardian_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.guardian_occupation')]) !!}
                            </div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.guardian_email', __('student.guardian_email') . ':*') !!}
                                {!! Form::email('guardian_email', null, ['class' => 'form-control', 'placeholder' => __('student.guardian_email')]) !!}
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                {!! Form::label('student.guardian_phone', __('student.guardian_phone') . ':*') !!}
                                {!! Form::text('guardian_phone', 92, ['class' => 'form-control mobile','required', 'placeholder' => __('student.guardian_phone')]) !!}
                            </div>
                            <div class="col-md-9 p-1">
                                {!! Form::label('student.guardian_address', __('student.guardian_address') . ':*') !!}
                                {!! Form::textarea('guardian_address', null, ['class' => 'form-control ','rows' => 1, 'placeholder' => __('student.guardian_address')]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title ">@lang('student.student_image')</h5>
                                <img src="https://demo.unlimitededufirm.com/assets/images/avatars/profile-pic.jpg" class="student_image card-img-top" width="192px" height="100px" alt="...">
                                {!! Form::label('student_image', __('student.student_image') . ':') !!}
                                {!! Form::file('student_image', ['accept' => 'image/*','class' => 'form-control upload_student_image']); !!}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row pt-4">
                    <h5 class="card-title text-primary">@lang('student.student_address_details')</h5>

                    <div class="col-md-3 p-1">
                        {!! Form::label('country.countries', __('country.countries') . ':*') !!}
                        {!! Form::select('country_id',$countries,91, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('district.districts', __('district.districts') . ':*') !!}
                        {!! Form::select('district_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('city.cities', __('city.cities') . ':*') !!}
                        {!! Form::select('city_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('region.regions', __('region.regions') . ':*') !!}
                        {!! Form::select('region_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.current_address', __('student.current_address') . ':*') !!}
                        {!! Form::textarea('current_address', null, ['class' => 'form-control ','rows' => 1, 'placeholder' => __('student.current_address')]) !!}
                    </div>
                    <div class="col-md-3 p-1">
                        {!! Form::label('student.permanet_address', __('student.permanet_address') . ':*') !!}
                        {!! Form::textarea('permanet_address', null, ['class' => 'form-control ','rows' => 1, 'placeholder' => __('student.permanet_address')]) !!}
                    </div>

                    <div class="clearfix"></div>

                </div>

                <div class="row pt-4">

                    <h5 class="card-title text-primary">@lang('student.miscellaneous_details')</h5>

                    <div class="col-md-3 p-1">
                        {!! Form::label('student.student_tuition_fee', __('student.student_tuition_fee') . ':*') !!}
                        {!! Form::number('student_tuition_fee', null, ['class' => 'form-control', 'required','placeholder' => __('student.student_tuition_fee'),'id' => 'student_tuition_fee']) !!}
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
        $('.mobile').inputmask('+999999999999');

        $(".upload_student_image").on('change', function() {
            __readURL(this, '.student_image');
        });
        //toggle the component with class accordion_body
        $('.accordion-panel').on('click', '.accordion__header', function() {
            $('.accordion__body').slideUp().removeClass('flipInX');
            $('.accordion__button').removeClass('bx-plus');
            if ($(this).next().is(':hidden')) {
                $(this).next().slideDown().addClass('flipInX');
                $(this).find('.accordion__button').addClass('bx-minus');
            } else {
                $(this).next().slideUp();
                $(this).find('.accordion__button').addClass('bx-plus');
            }
        });
        $(document).on('change', '#campus_id', function() {
            get_campus_class();
        });
        $(document).on('change', '#class_ids', function() {
            get_class_fee();
            get_class_Section();
        });
        $(document).on('change', '#session_id', function() {
            get_get_roll_no();
        });

        function get_campus_class() {
            //Add dropdown for sub units if sub unit field is visible
            var campus_id = $('#campus_id').val();
            $.ajax({
                method: 'GET'
                , url: '/classes/get_campus_classes'
                , dataType: 'html'
                , data: {
                    campus_id: campus_id
                }
                , success: function(result) {
                    if (result) {
                        $('#class_ids').html(result);

                    }
                }
            , });
        }

        function get_class_Section() {
            //Add dropdown for sub units if sub unit field is visible
            var class_id = $('#class_ids').val();
            $.ajax({
                method: 'GET'
                , url: '/classes/get_class_section'
                , dataType: 'html'
                , data: {
                    class_id: class_id
                }
                , success: function(result) {
                    if (result) {
                        $('#class_section_ids').html(result);

                    }
                }
            , });
        }

        function get_class_fee() {
            //Add dropdown for sub units if sub unit field is visible
            var class_id = $('#class_ids').val();
            $.ajax({
                method: 'GET'
                , url: '/classes/get_class_fee'
                , dataType: 'json'
                , data: {
                    class_id: class_id
                }
                , success: function(result) {
                    if (result) {
                        $('#student_tuition_fee').val(result.tuition_fee)
                    }
                }
            , });

        }

        function get_get_roll_no() {
            //Add dropdown for get_roll_no if sub unit field is visible
            var session_id = $('#session_id').val();
            $.ajax({
                method: 'GET'
                , url: '/sessions/get_roll_no'
                , dataType: 'html'
                , data: {
                    session_id: session_id
                }
                , success: function(result) {
                    if (result) {
                        $('#roll_no').val(result);
                        $('#student_email').val(result+'@edu.pk');
                    }
                }
            , });
        }

    });

</script>
@endsection

