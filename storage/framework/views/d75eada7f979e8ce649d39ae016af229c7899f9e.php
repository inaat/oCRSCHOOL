<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\ClassController@update',[$classes->id]), 'method' => 'PUT', 'id' =>'class_edit_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('class.edit_class'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    <?php echo Form::label('title', __('class.title') . ':*', ['classs' => 'form-lable']); ?>

                    <?php echo Form::text('title', $classes->title, ['class' => 'form-control', 'required', 'placeholder' => __('class.title')]); ?>


                </div>
                <div class="col-md-6 p-3">
                    <?php echo Form::label('campus.campuses', __('campus.campuses') . ':*'); ?>

                    <?php echo Form::select('campus_id',$campuses,$classes->campus_id, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('class_level.class_level', __('class_level.class_levels') . ':*'); ?>

                    <?php echo Form::select('class_level_id',$classLevel,$classes->class_level_id, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-6 p-3">
                    <?php echo Form::label('tuition_fee', __( 'class.tuition_fee' ) . ':*'); ?>

                    <?php echo Form::text('tuition_fee',number_format($classes->tuition_fee, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'class.tuition_fee' ) ]); ?>


                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    <?php echo Form::label('admission_fee', __( 'class.admission_fee' ) . ':*'); ?>

                    <?php echo Form::text('admission_fee',number_format($classes->admission_fee, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'class.admission_fee' ) ]); ?>


                </div>


                <div class="clearfix"></div>
            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.update' ); ?></button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
            </div>
        </div>

        <?php echo Form::close(); ?>


    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\classes/edit.blade.php ENDPATH**/ ?>