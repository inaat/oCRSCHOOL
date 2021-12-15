<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('Curriculum\ClassSubjectController@update', [$class_subject->id]), 'method' => 'PUT', 'id' => 'class_subject_edit_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.update_class_subject'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-4 p-2 ">
                    <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                    <?php echo Form::select('campus_id', $campuses,$class_subject->campus_id, ['class' => 'form-select select2 global-campuses', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                    <?php echo Form::select('class_id', $classes,$class_subject->class_id, ['class' => 'form-select select2 global-classes', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('name', __( 'lang.class_subject_name' ) . ':'); ?>

                    <?php echo Form::text('name', $class_subject->name, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_name' ) ]); ?>

                </div>

                <div class="clear-fix"></div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('code', __( 'lang.class_subject_code' ) . ':'); ?>

                    <?php echo Form::text('code', $class_subject->code, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_code' ) ]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('passing_percentage', __( 'lang.passing_percentage' ) . ':'); ?>

                    <?php echo Form::number('passing_percentage',$class_subject->passing_percentage, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.passing_percentage' ) ]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('chapters', __( 'lang.chapters' ) . ':'); ?>

                    <?php echo Form::number('chapters',$class_subject->chapters, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.chapters' ) ]); ?>

                </div>
                <div class="col-md-12 p-2">
                    <?php echo Form::label('description', __( 'lang.description' ) . ':'); ?>

                    <?php echo Form::textarea('description',$class_subject->description, ['class' => 'form-control', 'required','rows=4','placeholder' => __( 'lang.description' ) ]); ?>

                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'lang.update' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\class_subject/edit.blade.php ENDPATH**/ ?>