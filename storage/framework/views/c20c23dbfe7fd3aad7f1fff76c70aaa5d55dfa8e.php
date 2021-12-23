<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('Curriculum\CurriculumController@store'), 'method' => 'post', 'id' =>'class_subject_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.register_new_subject_for_class'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <?php echo Form::hidden('class_id', $class_detail->id); ?>

            <?php echo Form::hidden('campus_id', $class_detail->campus_id,[ 'id' => 'campus_id', ]); ?>


        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-3 p-2">
                    <?php echo Form::label('name', __( 'lang.class_subject_name' ) . ':'); ?>

                    <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_name' ) ]); ?>

                </div>
  
                    <div class="col-md-3 p-2">
                    <?php echo Form::label('code', __( 'lang.class_subject_code' ) . ':'); ?>

                    <?php echo Form::text('code', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_code' ) ]); ?>

                </div>
                <div class="col-md-3 p-2">
                    <?php echo Form::label('passing_percentage', __( 'lang.passing_percentage' ) . ':'); ?>

                    <?php echo Form::number('passing_percentage', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.passing_percentage' ) ]); ?>

                </div>
                <div class="col-md-3 p-2">
                    <?php echo Form::label('chapters', __( 'lang.chapters' ) . ':'); ?>

                    <?php echo Form::number('chapters', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.chapters' ) ]); ?>

                </div>
                <div class="col-md-12 p-2">
                    <?php echo Form::label('description', __( 'lang.description' ) . ':'); ?>

                    <?php echo Form::textarea('description', null, ['class' => 'form-control','rows=4','placeholder' => __( 'lang.description' ) ]); ?>

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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\class_wise_subject/create.blade.php ENDPATH**/ ?>