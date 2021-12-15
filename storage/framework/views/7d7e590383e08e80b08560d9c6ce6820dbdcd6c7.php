<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('Curriculum\ClassSubjectLessonController@store'), 'method' => 'post', 'id' =>'lesson_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title text-uppercase" id="exampleModalLabel"><?php echo app('translator')->get('lang.add_new_lesson'); ?>For<small>(<?php echo app('translator')->get('lang.subject_detail'); ?> - <?php echo e($class_subject->name, false); ?> of class <?php echo e($class_subject->classes->title, false); ?>)</small></h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <?php echo Form::hidden('subject_id', $class_subject->id,[ 'id' => 'subject_id', ]); ?>

            <?php echo Form::hidden('campus_id', $class_subject->campus_id,[ 'id' => 'campus_id', ]); ?>


        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-4 p-2 ">
                    <?php echo Form::label('chapter_number', __('lang.chapters') . ':*'); ?>

                    <?php echo Form::select('chapter_number', $chapters, null, ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-8 p-2 ">
                    <?php echo Form::label('name', __('lang.lesson_title') . ':*'); ?>

                    <?php echo Form::text('name', null, ['class' => 'form-control  ', 'required','placeholder' => __('lang.lesson_title')]); ?>

                </div>
                <div class="clearfix"></div>
                 <div class="col-md-12 p-2">
                    <?php echo Form::label('description', __( 'lang.description' ) . ':'); ?>

                    <?php echo Form::textarea('description',null ,['class' => 'form-control', 'rows=4','placeholder' => __( 'lang.description' ) ]); ?>

                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'lang.save' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\lesson/create.blade.php ENDPATH**/ ?>