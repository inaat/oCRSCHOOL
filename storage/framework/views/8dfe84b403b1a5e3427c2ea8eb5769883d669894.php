<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('Curriculum\ClassSubjectController@store'), 'method' => 'post', 'id' =>'class_subject_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.add_new_class_subject'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-4 p-2 ">
                    <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                    <?php echo Form::select('campus_id', $campuses, null, ['class' => 'form-select select2 global-campuses', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                    <?php echo Form::select('class_id', [], null, ['class' => 'form-select select2 global-classes', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('name', __( 'lang.class_subject_name' ) . ':'); ?>

                    <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_name' ) ]); ?>

                </div>
  
                <div class="clear-fix"></div>
                    <div class="col-md-4 p-2">
                    <?php echo Form::label('code', __( 'lang.class_subject_code' ) . ':'); ?>

                    <?php echo Form::text('code', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_code' ) ]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('passing_percentage', __( 'lang.passing_percentage' ) . ':'); ?>

                    <?php echo Form::number('passing_percentage', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.passing_percentage' ) ]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('chapters', __( 'lang.chapters' ) . ':'); ?>

                    <?php echo Form::number('chapters', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.chapters' ) ]); ?>

                </div>
                <div class="col-md-12 p-2">
                    <?php echo Form::label('description', __( 'lang.description' ) . ':'); ?>

                    <?php echo Form::textarea('description', null, ['class' => 'form-control',  'required','rows=4','placeholder' => __( 'lang.description' ) ]); ?>

                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.save' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\class_subject/create.blade.php ENDPATH**/ ?>