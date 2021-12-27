<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

  		<?php echo Form::open(['url' => action('Curriculum\ClassTimeTableController@store') , 'method' => 'post' , 'id' => 'add_time_table_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.assign_new_period'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
               <div class="col-md-4 p-2 ">
                    <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                    <?php echo Form::select('campus_id', $campuses, null,['class' => 'form-select select2 global-campuses','style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                    <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                    <?php echo Form::select('class_id',[],null, ['class' => 'form-select  select2 global-classes ','style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                <?php echo Form::label('class_section.sections', __('class_section.sections') . ':*'); ?>

                <?php echo Form::select('class_section_id', [], null, ['class' => 'form-select select2 global-class_sections', 'required', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                <?php echo Form::label('subjects', __('lang.subjects') . ':*'); ?>

                <?php echo Form::select('subject_id', [], null, ['class' => 'form-select select2 global-subjects','required', 'id' => 'subjects', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-4 p-2">
                <?php echo Form::label('periods', __('lang.periods') . ':*'); ?>

                <?php echo Form::select('period_id', [], null, ['class' => 'form-select select2 global-periods','required', 'id' => 'periods', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

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
<script type="text/javascript">
    $(document).ready(function() {
         $("form#add_time_table_form").validate({
        rules: {
            period_id: {
                required: true,
            },
        },
    });
      
       
    });

</script><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\class_time_table/create.blade.php ENDPATH**/ ?>