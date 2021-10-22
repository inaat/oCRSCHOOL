
<?php $__env->startSection('wrapper'); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('campus.campus_details'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('campus.campuses'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <?php echo Form::open(['url' => action('\App\Http\Controllers\CampusController@store'), 'method' => 'post', 'class'=>'needs-validation was-validated','novalidate'.'id' =>'campus_add_form' ]); ?>


        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-primary"><?php echo app('translator')->get('campus.add_new_campus'); ?></h6>
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('campus.campuses', __('campus.campuses') . ':*'); ?>

                                <?php echo Form::select('campus_id',$campuses,null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('admission_no', __('student.admission_no') . ':*', ['classs' => 'form-lable']); ?>

                                <?php echo Form::text('admission_no', null, ['class' => 'form-control', 'required', 'readonly','placeholder' => __('student.admission_no')]); ?>


                            </div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('student.admission_date', __('student.admission_date') . ':*'); ?>

                                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                    <?php echo Form::text('birth_date',\Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format')), ['class' => 'form-control date-picker', 'readonly', 'placeholder' => __('student.admission_date')]); ?>


                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('roll_no', __('student.roll_no') . ':*'); ?>

                                <?php echo Form::text('roll_no', null, ['class' => 'form-control','required','readonly', 'placeholder' => __('student.roll_no')]); ?>

                            </div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                                <?php echo Form::select('admission_class_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-4 p-1">
                                <?php echo Form::label('class_section.sections', __('class_section.sections') . ':*'); ?>

                                <?php echo Form::select('admission_class_section_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('session.sessions', __('session.sessions') . ':*'); ?>

                                <?php echo Form::select('admission_session_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.first_name', __('student.first_name') . ':*'); ?>

                                <?php echo Form::text('first_name', null, ['class' => 'form-control','required', 'placeholder' => __('student.first_name')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.last_name', __('student.last_name') . ':*'); ?>

                                <?php echo Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __('student.last_name')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.gender', __('student.gender') . ':*'); ?>

                                <?php echo Form::select('class_id',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.date_of_birth', __('student.date_of_birth') . ':*'); ?>

                                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                    <?php echo Form::text('birth_date',\Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format')), ['class' => 'form-control start-date-picker', 'placeholder' => __('student.date_of_birth')]); ?>


                                </div>
                            </div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.category', __('student.category') . ':*'); ?>

                                <?php echo Form::select('category_id',[],null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.domicile', __('student.domicile') . ':*'); ?>

                                <?php echo Form::text('domicile', null, ['class' => 'form-control', 'placeholder' => __('student.domicile')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.religion', __('student.religion') . ':*'); ?>

                                <?php echo Form::select('religion',[],null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.caste', __('student.caste') . ':*'); ?>

                                <?php echo Form::text('caste', null, ['class' => 'form-control', 'placeholder' => __('student.caste')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('mobile', __('lang_v1.mobile') . ':'); ?>

                                <input type="text" name="mobile_no" class="mobile form-control" value="92 ">

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('email', __('student.email') . ':'); ?>

                                <?php echo Form::email('email', null, ['class' => 'form-control','placeholder' => __('student.email')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.cnic_number', __('student.cnic_number') . ':*'); ?>

                                <?php echo Form::text('cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>



                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.blood_group', __('student.blood_group') . ':'); ?>

                                <?php echo Form::select('blood_group',[],null, ['class' => 'form-select select2 ', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('nationality', __('student.nationality') . ':'); ?>

                                <?php echo Form::text('nationality', 'Pakistani', ['class' => 'form-control','placeholder' => __('student.nationality')]); ?>


                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('mother_tongue', __('student.mother_tongue') . ':'); ?>

                                <?php echo Form::text('mother_tongue', null, ['class' => 'form-control','placeholder' => __('student.mother_tongue')]); ?>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title "><?php echo app('translator')->get('student.student_image'); ?></h5>
                                <img src="https://demo.unlimitededufirm.com/assets/images/avatars/profile-pic.jpg" class="student_image card-img-top" width="192px" height="192px" alt="...">
                                <?php echo Form::label('student_image', __('student.student_image') . ':'); ?>

                                <?php echo Form::file('student_image', ['accept' => 'image/*','class' => 'form-control upload_student_image']); ?>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row pt-4">
                    <h5 class="card-title text-primary"><?php echo app('translator')->get('student.parent_guardian_detail'); ?></h5>

                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.father_name', __('student.father_name') . ':*'); ?>

                        <?php echo Form::text('father_name', null, ['class' => 'form-control', 'required','placeholder' => __('student.father_name')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.father_phone', __('student.father_phone') . ':*'); ?>

                        <?php echo Form::text('father_phone', 92, ['class' => 'form-control mobile','required', 'placeholder' => __('student.father_phone')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.father_occupation', __('student.father_occupation') . ':*'); ?>

                        <?php echo Form::text('father_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.father_occupation')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.father_cnic_no', __('student.father_cnic_no') . ':*'); ?>

                        <?php echo Form::text('father_cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.mother_name', __('student.mother_name') . ':*'); ?>

                        <?php echo Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => __('student.mother_name')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.mother_phone', __('student.mother_phone') . ':*'); ?>

                        <?php echo Form::text('mother_phone', 92, ['class' => 'form-control mobile', 'placeholder' => __('student.mother_phone')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.mother_occupation', __('student.mother_occupation') . ':*'); ?>

                        <?php echo Form::text('mother_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.mother_occupation')]); ?>

                    </div>
                    <div class="col-md-3 p-1">
                        <?php echo Form::label('student.mother_cnic_no', __('student.mother_cnic_no') . ':*'); ?>

                        <?php echo Form::text('mother_cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                    </div>
                    <div class="clearfix"></div>

                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label><?php echo app('translator')->get('student.if_guardian_is'); ?><small class="req form-check-label"> *</small>&nbsp;&nbsp;&nbsp;</label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" required value="father" autocomplete="off"> <?php echo app('translator')->get('student.father'); ?> </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" value="mother" autocomplete="off"> <?php echo app('translator')->get('student.mother'); ?> </label>
                        <label class="radio-inline">
                            <input class="form-check-input" type="radio" name="guardian_is" value="other" autocomplete="off"> <?php echo app('translator')->get('student.other'); ?> </label>
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-md-10">
                        <div class="row">
                            <h5 class="card-title text-primary"><?php echo app('translator')->get('student.parent_guardian_detail'); ?></h5>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.guardian_name', __('student.guardian_name') . ':*'); ?>

                                <?php echo Form::text('guardian_name', null, ['class' => 'form-control', 'required','placeholder' => __('student.guardian_name')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.guardian_relation', __('student.guardian_relation') . ':*'); ?>

                                <?php echo Form::text('guardian_relation', null, ['class' => 'form-control', 'required','placeholder' => __('student.guardian_relation')]); ?>

                            </div>

                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.guardian_occupation', __('student.guardian_occupation') . ':*'); ?>

                                <?php echo Form::text('guardian_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.guardian_occupation')]); ?>

                            </div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.guardian_email', __('student.guardian_email') . ':*'); ?>

                                <?php echo Form::email('guardian_email', null, ['class' => 'form-control', 'placeholder' => __('student.guardian_email')]); ?>

                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3 p-1">
                                <?php echo Form::label('student.guardian_phone', __('student.guardian_phone') . ':*'); ?>

                                <?php echo Form::text('guardian_phone', 92, ['class' => 'form-control mobile','required', 'placeholder' => __('student.guardian_phone')]); ?>

                            </div>
                            <div class="col-md-9 p-1">
                                <?php echo Form::label('student.guardian_address', __('student.guardian_address') . ':*'); ?>

                                <?php echo Form::textarea('guardian_address', null, ['class' => 'form-control ','rows' => 1, 'placeholder' => __('student.guardian_address')]); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title "><?php echo app('translator')->get('student.student_image'); ?></h5>
                                <img src="https://demo.unlimitededufirm.com/assets/images/avatars/profile-pic.jpg" class="student_image card-img-top" width="192px" height="100px" alt="...">
                                <?php echo Form::label('student_image', __('student.student_image') . ':'); ?>

                                <?php echo Form::file('student_image', ['accept' => 'image/*','class' => 'form-control upload_student_image']); ?>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row pt-4">
                    <div class="col-md-12">
                        <div class="accordion-wrap">
                            <div class="accordion-panel">
                                <div class="accordion__header">
                                    <h5 class="card-title text-primary"><?php echo app('translator')->get('student.add_more_detail'); ?></h5>

                                    <i class="bx bx-plus btn btn-primary radius-30 mt-2 mt-lg-0 accordion__button"></i>
                                </div>
                                <div class="accordion__body animated">
                                    
                                    
                                                                        <h5 class="card-title text-primary"><?php echo app('translator')->get('student.student_address_details'); ?></h5>


                                    <div class="row pt-1">
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.father_name', __('student.father_name') . ':*'); ?>

                                            <?php echo Form::text('father_name', null, ['class' => 'form-control', 'required','placeholder' => __('student.father_name')]); ?>

                                        </div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.father_phone', __('student.father_phone') . ':*'); ?>

                                            <?php echo Form::text('father_phone', 92, ['class' => 'form-control mobile','required', 'placeholder' => __('student.father_phone')]); ?>

                                        </div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.father_occupation', __('student.father_occupation') . ':*'); ?>

                                            <?php echo Form::text('father_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.father_occupation')]); ?>

                                        </div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.father_cnic_no', __('student.father_cnic_no') . ':*'); ?>

                                            <?php echo Form::text('father_cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.mother_name', __('student.mother_name') . ':*'); ?>

                                            <?php echo Form::text('mother_name', null, ['class' => 'form-control', 'placeholder' => __('student.mother_name')]); ?>

                                        </div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.mother_phone', __('student.mother_phone') . ':*'); ?>

                                            <?php echo Form::text('mother_phone', 92, ['class' => 'form-control mobile', 'placeholder' => __('student.mother_phone')]); ?>

                                        </div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.mother_occupation', __('student.mother_occupation') . ':*'); ?>

                                            <?php echo Form::text('mother_occupation', null, ['class' => 'form-control', 'placeholder' => __('student.mother_occupation')]); ?>

                                        </div>
                                        <div class="col-md-3 p-1">
                                            <?php echo Form::label('student.mother_cnic_no', __('student.mother_cnic_no') . ':*'); ?>

                                            <?php echo Form::text('mother_cnic_no', null, ['class' => 'form-control cnic', 'placeholder' => __('XXXXX-XXXXXXX-X')]); ?>

                                        </div>
                                        <div class="clearfix"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
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
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/students/create.blade.php ENDPATH**/ ?>