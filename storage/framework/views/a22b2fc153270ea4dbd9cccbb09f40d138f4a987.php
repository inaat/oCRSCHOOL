
<?php $__env->startSection('wrapper'); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('lang.student_admission_form'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('lang.student_admission_form'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <?php echo Form::open(['url' => action('\App\Http\Controllers\StudentController@store'), 'method' => 'post', 'class'=>'needs-validation was-validated','novalidate'.'id' =>'student_add_form' ,'files' => true]); ?>


        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-primary"><?php echo app('translator')->get('lang.student_admission_form'); ?></h6>
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('campus.campuses', __('campus.campuses') . ':*'); ?>

                                <?php echo Form::select('campus_id',$campuses,null, ['class' => 'form-select select2 campuses','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'),'id' =>'campus_id']); ?>

                            </div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('session.sessions', __('session.sessions') . ':*'); ?>

                                <?php echo Form::select('adm_session_id',$sessions,null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'),'id'=>'session_id']); ?>

                            </div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('admission_no', __('lang.admission_no') . ':*', ['classs' => 'form-lable']); ?>

                                <?php echo Form::text('admission_no',$admission_no, ['class' => 'form-control', 'required', 'readonly','placeholder' => __('lang.admission_no')]); ?>


                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.admission_date', __('lang.admission_date') . ':*'); ?>

                                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                    <?php echo Form::text('admission_date',\Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format')), ['class' => 'form-control date-picker', 'readonly', 'placeholder' => __('lang.admission_date')]); ?>


                                </div>
                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('roll_no', __('lang.roll_no') . ':*'); ?>

                                <?php echo Form::text('roll_no', null, ['class' => 'form-control','required','readonly', 'placeholder' => __('lang.roll_no'),'id' => 'roll_no']); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                                <?php echo Form::select('adm_class_id',[],null, ['class' => 'form-select select2 classes','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select'),'id' =>'class_ids']); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('class_section.sections', __('class_section.sections') . ':*'); ?>

                                <?php echo Form::select('adm_class_section_id',[],null, ['class' => 'form-select select2 class_sections','id'=>'class_section_ids','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.first_name', __('lang.first_name') . ':*'); ?>

                                <?php echo Form::text('first_name', null, ['class' => 'form-control','required', 'placeholder' => __('lang.first_name')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.last_name', __('lang.last_name') . ':*'); ?>

                                <?php echo Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('lang.last_name')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.gender', __('lang.gender') . ':*'); ?>

                                <?php echo Form::select('gender', ['male' => __('lang_v1.male'), 'female' => __('lang_v1.female'), 'others' => __('lang_v1.others')],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.date_of_birth', __('lang.date_of_birth') . ':*'); ?>

                                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                    <?php echo Form::text('birth_date',\Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format')), ['class' => 'form-control start-date-picker', 'placeholder' => __('lang.date_of_birth')]); ?>


                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.student_categories', __('lang.student_categories') . ':*'); ?>

                                <?php echo Form::select('category_id',$categories,null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.domicile', __('lang.domicile') . ':*'); ?>

                                <?php echo Form::select('domicile_id',$districts, null, ['class' => 'form-select select2 ','style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.religion', __('lang.religion') . ':*'); ?>

                                <?php echo Form::select('religion',['Islam'=>'Islam', 'Hinduism'=>'Hinduism', 'Christianity'=>'Christianity','Sikhism'=>'Sikhism','Buddhism'=>'Buddhism','Secular/Nonreligious/Agnostic/Atheist'=>'Secular/Nonreligious/Atheist','Other'=>'Other'],'Islam', ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('mobile', __('lang_v1.mobile') . ':'); ?>

                                <input type="text" name="mobile_no" class="mobile form-control" value="3 ">

                            </div>
                            <div class="clearfix"></div>


                            <div class="col-md-3 p-1">
                                <?php echo Form::label('email', __('lang.email') . ':'); ?>

                                <?php echo Form::email('email', null, ['class' => 'form-control','placeholder' => __('lang.email'),'id' => 'student_email']); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.cnic_number', __('lang.cnic_number') . ':*'); ?>

                                <?php echo Form::text('cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.blood_group', __('lang.blood_group') . ':'); ?>

                                <?php echo Form::select('blood_group',['O+'=>'O+', 'O-'=>'O-', 'A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-'],null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('nationality', __('lang.nationality') . ':'); ?>

                                <?php echo Form::text('nationality', 'Pakistani', ['class' => 'form-control','placeholder' => __('lang.nationality')]); ?>


                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('mother_tongue', __('lang.mother_tongue') . ':'); ?>

                                <?php echo Form::text('mother_tongue', null, ['class' => 'form-control','placeholder' => __('lang.mother_tongue')]); ?>


                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('medical_history', __('lang.medical_history') . ':'); ?>

                                <?php echo Form::textarea('medical_history', null, ['class' => 'form-control','rows' => 1,'placeholder' => __('lang.medical_history')]); ?>


                            </div>
                            <div class="col-md-3 p-1">

                                <div class="ms-auto p-3 ">
                                    <button type="button" class="btn btn-primary radius-30 mt-lg-0 btn-modal" data-href="<?php echo e(action('StudentController@addSibling'), false); ?>" data-container=".sibling_modal">
                                        <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('lang.add_sibling'); ?></button>
                                </div>

                            </div>
                            <div class="col-md-3 p-1">

                                <div class="ms-auto p-3 ">
                                    <span id="sibling_name" class="badge bg-success"></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title "><?php echo app('translator')->get('lang.student_image'); ?></h5>
                                <img src="https://demo.unlimitededufirm.com/assets/images/avatars/profile-pic.jpg" class="student_image card-img-top" width="192px" height="192px" alt="...">
                                <?php echo Form::label('student_image', __('lang.student_image') . ':'); ?>

                                <?php echo Form::file('student_image', ['accept' => 'image/*','class' => 'form-control upload_student_image']); ?>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row pt-4  remove">
                    <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.parent_detail'); ?></h5>

                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.father_name', __('lang.father_name') . ':*'); ?>

                        <?php echo Form::text('father_name', null, ['class' => 'form-control', 'required','id'=>'father_name','placeholder' => __('lang.father_name')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.father_phone', __('lang.father_phone') . ':*'); ?>

                        <?php echo Form::text('father_phone', 3, ['class' => 'form-control mobile','required','id'=>'father_phone', 'placeholder' => __('lang.father_phone')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.father_occupation', __('lang.father_occupation') . ':*'); ?>

                        <?php echo Form::text('father_occupation', null, ['class' => 'form-control','id'=>'father_occupation', 'placeholder' => __('lang.father_occupation')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.father_cnic_no', __('lang.father_cnic_no') . ':*'); ?>

                        <?php echo Form::text('father_cnic_no', null, ['class' => 'form-control cnic','id'=>'father_cnic_no', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.mother_name', __('lang.mother_name') . ':*'); ?>

                        <?php echo Form::text('mother_name', null, ['class' => 'form-control','id'=>'mother_name', 'placeholder' => __('lang.mother_name')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.mother_phone', __('lang.mother_phone') . ':*'); ?>

                        <?php echo Form::text('mother_phone', 3, ['class' => 'form-control mobile', 'id'=>'mother_phone','placeholder' => __('lang.mother_phone')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.mother_occupation', __('lang.mother_occupation') . ':*'); ?>

                        <?php echo Form::text('mother_occupation', null, ['class' => 'form-control', 'id'=>'mother_occupation','placeholder' => __('lang.mother_occupation')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.mother_cnic_no', __('lang.mother_cnic_no') . ':*'); ?>

                        <?php echo Form::text('mother_cnic_no', null, ['class' => 'form-control cnic','id'=>'mother_cnic_no', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="row  remove">
                    <div class="form-group col-md-12">
                        <label><?php echo app('translator')->get('lang.if_guardian_is'); ?><small class="req form-check-label"> *</small>&nbsp;&nbsp;&nbsp;</label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" required value="Father" autocomplete="off"> <?php echo app('translator')->get('lang.father'); ?> </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" value="Mother" autocomplete="off"> <?php echo app('translator')->get('lang.mother'); ?> </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" value="Other" autocomplete="off"> <?php echo app('translator')->get('lang.other'); ?> </label>
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="row pt-4  remove ">
                    <div class="col-md-12">
                        <div class="row">
                            <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.parent_guardian_detail'); ?></h5>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.guardian_name', __('lang.guardian_name') . ':*'); ?>

                                <?php echo Form::text('guardian[guardian_name]', null, ['class' => 'form-control', 'id'=>'guardian_name','required','placeholder' => __('lang.guardian_name')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.guardian_relation', __('lang.guardian_relation') . ':*'); ?>

                                <?php echo Form::text('guardian[guardian_relation]', null, ['class' => 'form-control','id'=>'guardian_relation', 'required','placeholder' => __('lang.guardian_relation')]); ?>

                            </div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.guardian_occupation', __('lang.guardian_occupation') . ':*'); ?>

                                <?php echo Form::text('guardian[guardian_occupation]', null, ['class' => 'form-control','id'=>'guardian_occupation', 'placeholder' => __('lang.guardian_occupation')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.guardian_email', __('lang.guardian_email') . ':*'); ?>

                                <?php echo Form::email('guardian[guardian_email]', null, ['class' => 'form-control','id'=>'guardian_email', 'placeholder' => __('lang.guardian_email')]); ?>

                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('lang.guardian_phone', __('lang.guardian_phone') . ':*'); ?>

                                <?php echo Form::text('guardian[guardian_phone]', 3, ['class' => 'form-control mobile','id'=>'guardian_phone','required', 'placeholder' => __('lang.guardian_phone')]); ?>

                            </div>
                            <div class="col-md-9 p-1">
                                <?php echo Form::label('lang.guardian_address', __('lang.guardian_address') . ':*'); ?>

                                <?php echo Form::textarea('guardian[guardian_address]', null, ['class' => 'form-control ','rows' => 1,'id'=>'guardian_address', 'placeholder' => __('lang.guardian_address')]); ?>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="row pt-4  remove">
                    <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.student_address_details'); ?></h5>


                    <div class="col-md-3 p-1">
                        <?php echo Form::label('country_id', __('lang.country_name') . ':*'); ?>

                        <?php echo Form::select('country_id',$countries,null, ['class' => 'form-select select2 ','required','id'=>'country_id', 'style' => 'width:100%', 'required', 'placeholder' => __('lang.please_select')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('province_id', __('lang.provinces') . ':*'); ?>

                        <?php echo Form::select('province_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required','id' => 'provinces_ids','placeholder' => __('lang.please_select')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('district_id', __('lang.district_name') . ':*'); ?>

                        <?php echo Form::select('district_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required','id' => 'district_ids','placeholder' => __('lang.district_name')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('city_id', __('lang.city_name') . ':*'); ?>

                        <?php echo Form::select('city_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required','id' => 'city_ids','placeholder' => __('lang.city_name')]); ?>

                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('region.regions', __('region.regions') . ':*'); ?>

                        <?php echo Form::select('region_id',[],null, ['class' => 'form-select select2 ','required','id'=>'region_ids', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.current_address', __('lang.current_address') . ':*'); ?>

                        <?php echo Form::textarea('std_current_address', null, ['class' => 'form-control ','rows' => 1, 'placeholder' => __('lang.current_address')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.permanent_address', __('lang.permanent_address') . ':*'); ?>

                        <?php echo Form::textarea('std_permanent_address', null, ['class' => 'form-control ','rows' => 1, 'placeholder' => __('lang.permanent_address')]); ?>

                    </div>

                    <div class="clearfix"></div>

                </div>

                <div class="row pt-4">

                    <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.miscellaneous_details'); ?></h5>

                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.student_tuition_fee', __('lang.student_tuition_fee') . ':*'); ?>

                        <?php echo Form::number('student_tuition_fee', null, ['class' => 'form-control', 'required','placeholder' => __('lang.student_tuition_fee'),'id' => 'student_tuition_fee']); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('lang.student_discounts', __('lang.student_discounts') . ':*'); ?>

                        <?php echo Form::select('discount_id',$discounts,null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                    </div>


                    <div class="col-md-3  opening_balance p-1">
                        <?php echo Form::label('opening_balance', __('lang_v1.opening_balance') . ':'); ?>

                        <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-bill-alt"></i></span>

                            <?php echo Form::text('opening_balance', 0, ['class' => 'form-control input_number']); ?>


                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('previous_school_name', __('lang.previous_school_name') . ':'); ?>

                        <?php echo Form::text('previous_school_name', null, ['class' => 'form-control','placeholder' => __('lang.previous_school_name')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('last_grade', __('lang.last_grade') . ':'); ?>

                        <?php echo Form::text('last_grade', null, ['class' => 'form-control','placeholder' => __('lang.last_grade')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('remark', __('lang.remark') . ':'); ?>

                        <?php echo Form::textarea('remark', null, ['class' => 'form-control','rows' => 3,'placeholder' => __('lang.remark')]); ?>


                    </div>

                </div>
            </div>
            <input type="hidden" name="sibling_id" id="sibling_id">
            <input type="hidden" name="guardian_link_id" id="guardian_link_id">

            <div class="row">
                <div class="col-sm-12">

                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <button class="btn- btn btn-primary radius-30 mt-2 mt-lg-0"><?php echo app('translator')->get('messages.save'); ?></button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end row-->


    <?php echo Form::close(); ?>


</div>
</div>
<div class="modal fade sibling_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datepicker();
        $('.cnic').inputmask('99999-9999999-9');
        $('.mobile').inputmask('09999999999');

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
        $(document).on('change', '.campuses', function() {
            var doc = $(this);
            get_campus_class(doc);
        });
        $(document).on('change', '.class_sections', function() {
            var doc = $(this);
            getByClassAndSection(doc)
        });
        $(document).on('change', '.classes', function() {
            var doc = $(this);
            get_class_fee(doc);
            get_class_Section(doc);
        });
        $(document).on('change', '#session_id', function() {
            get_get_roll_no();
        });


        function getByClassAndSection(doc) {
            var class_id = doc.closest(".row")
                .find(".classes").val();
            var section_id = doc.closest(".row")
                .find(".class_sections").val();
            $.ajax({
                method: 'GET'
                , url: '/student/getByClassAndSection'
                , dataType: 'html'
                , data: {
                    class_id: class_id
                    , section_id: section_id
                }
                , success: function(result) {
                    if (result) {
                        doc.closest(".row")
                            .find("#sibiling_student_id").html(result);

                    }
                }
            , });
        }


        function get_campus_class(doc) {
            //Add dropdown for sub units if sub unit field is visible
            var campus_id = doc.closest(".row")
                .find(".campuses").val();
            $.ajax({
                method: 'GET'
                , url: '/classes/get_campus_classes'
                , dataType: 'html'
                , data: {
                    campus_id: campus_id
                }
                , success: function(result) {
                    if (result) {
                        doc.closest(".row")
                            .find(".classes").html(result);

                    }
                }
            , });
        }

        function get_class_Section(doc) {
            //Add dropdown for sub units if sub unit field is visible
            var class_id = doc.closest(".row")
                .find('.classes').val();
            $.ajax({
                method: 'GET'
                , url: '/classes/get_class_section'
                , dataType: 'html'
                , data: {
                    class_id: class_id
                }
                , success: function(result) {
                    if (result) {
                        doc.closest(".row")
                            .find('.class_sections').html(result);

                    }
                }
            , });
        }

        function get_class_fee(doc) {
            //Add dropdown for sub units if sub unit field is visible
            var class_id = doc.closest(".row")
                .find('.classes').val();
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
                        $('#student_email').val(result + '@edu.pk');
                    }
                }
            , });
        }

        $('input:radio[name="guardian_is"]').change(
            function() {
                if ($(this).is(':checked')) {
                    var value = $(this).val();
                    if (value == "Father") {
                        $('#guardian_name').val($('#father_name').val());
                        $('#guardian_phone').val($('#father_phone').val());
                        $('#guardian_occupation').val($('#father_occupation').val());
                        $('#guardian_relation').val("Father")
                    } else if (value == "Mother") {
                        $('#guardian_name').val($('#mother_name').val());
                        $('#guardian_phone').val($('#mother_phone').val());
                        $('#guardian_occupation').val($('#mother_occupation').val());
                        $('#guardian_relation').val("Mother")
                    } else {
                        $('#guardian_name').val("");
                        $('#guardian_phone').val("");
                        $('#guardian_occupation').val("");
                        $('#guardian_relation').val("")
                    }
                }
            });


        $(document).on('click', '.add_sibling', function() {
            var student_id = $('#sibiling_student_id').val();

            if (student_id.length > 0) {
                $.ajax({
                    type: "GET"
                    , url: "/student/getStudentRecordByID"
                    , data: {
                        'student_id': student_id
                    }
                    , dataType: "json"
                    , success: function(data) {
                        console.log(data);
                        $('#sibling_name').text("Sibling: " + data.full_name);
                        $('#sibling_id').val(student_id);
                        $('#guardian_link_id').val(data.guardian.guardian_id);
                        $('.remove').remove();
                        $('.sibling_modal').modal('hide');
                    }

                });
            } else {
                $('.sibling_msg').html("<div class='alert alert-danger text-center'>'no_student_selected'</div>");
            }
        });

    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/students/create.blade.php ENDPATH**/ ?>