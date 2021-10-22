
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
                <h5 class="card-title text-primary"><?php echo app('translator')->get('campus.add_new_campus'); ?></h5>
                <div class="row">
                    <div class="col-md-4 p-3">
                        <?php echo Form::label('campus_name', __('campus.campus_name') . ':*', ['classs' => 'form-lable']); ?>

                        <?php echo Form::text('campus_name', null, ['class' => 'form-control', 'required', 'placeholder' => __('campus.campus_name')]); ?>


                    </div>
                    <div class="col-md-4 p-3">
                        <?php echo Form::label('registration_code', __('campus.registration_code') . ':*'); ?>

                        <?php echo Form::text('registration_code', null, ['class' => 'form-control','required', 'placeholder' => __('campus.registration_code')]); ?>

                    </div>
                    <div class="col-md-4 p-3">
                        <?php echo Form::label('registration_date', __('campus.registration_date') . ':*', ['classs' => 'form-lable']); ?>


                        <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                            <?php echo Form::text('registration_date', \Carbon::createFromTimestamp(strtotime('now'))->format(session('system_details.date_format')), ['class' => 'form-control start-date-picker', 'placeholder' => __('campus.registration_date'), 'readonly']); ?>


                        </div>
                    </div>
                                        <div class="clearfix"></div>

                    <div class="col-md-4 p-3">
                        <?php echo Form::label('mobile', __('lang_v1.mobile') . ':'); ?>

                        <?php echo Form::text('mobile', null, ['class' => 'form-control', 'required', 'pattern' => '\d{11}','maxlength' => '11','placeholder' => __('lang_v1.mobile')]); ?>

                    </div>

                    <div class="col-md-4 p-3">
                        <?php echo Form::label('phone', __('lang_v1.phone') . ':'); ?>

                        <?php echo Form::text('phone', null, ['class' => 'form-control','required', 'placeholder' => __('lang_v1.phone')]); ?>

                    </div>
                    <div class="col-md-4 p-3">
                        <?php echo Form::label('address', __('lang_v1.address') . ':', ['classs' => 'form-lable']); ?>

                        <?php echo Form::text('address', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang_v1.address')]); ?>


                    </div>

                    <div class="clearfix"></div>
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


<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\campuses/create.blade.php ENDPATH**/ ?>