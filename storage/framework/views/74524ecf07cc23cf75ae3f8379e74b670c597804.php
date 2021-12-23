<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\ClassController@store'), 'method' => 'post', 'id' => 'class_add_form']); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.add_new_class'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    <?php echo Form::label('title', __('lang.title') . ':*', ['classs' => 'form-lable']); ?>

                    <?php echo Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang.title')]); ?>


                </div>
                <div class="col-md-6 p-3">
                    <?php echo Form::label('campus.campuses', __('campus.campuses') . ':*'); ?>

                    <?php echo Form::select('campus_id', $campuses, null, ['class' => 'form-select  select2 ', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('class_level.class_level', __('class_level.class_levels') . ':*'); ?>

                    <?php echo Form::select('class_level_id', $classLevel, null, ['class' => 'form-select  select2 ', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('tuition_fee', __('lang.tuition_fee') . ':*'); ?>

                    <?php echo Form::text('tuition_fee', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.tuition_fee')]); ?>


                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('admission_fee', __('lang.admission_fee') . ':*'); ?>

                    <?php echo Form::text('admission_fee', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.admission_fee')]); ?>


                </div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('transport_fee', __('lang.transport_fee') . ':*'); ?>

                    <?php echo Form::text('transport_fee', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.transport_fee')]); ?>


                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('security_fee', __('lang.security_fee') . ':*'); ?>

                    <?php echo Form::text('security_fee', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.security_fee')]); ?>


                </div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('prospectus_fee', __('lang.prospectus_fee') . ':*'); ?>

                    <?php echo Form::text('prospectus_fee', null, ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.prospectus_fee')]); ?>


                </div>

            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.save' ); ?></button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close'
                    ); ?></button>
            </div>
        </div>

        <?php echo Form::close(); ?>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\classes/create.blade.php ENDPATH**/ ?>