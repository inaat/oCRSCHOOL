<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('HRM\HrmEducationController@store'), 'method' => 'post', 'id' =>'education_add_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('hrm.register_new_education'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted">Register as many education as you need. Please provide required information to proceed next...</p>
            <div class="form-group">
                <?php echo Form::label('education', __( 'hrm.education_title' ) . ':*'); ?>

                <?php echo Form::text('education', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'hrm.education_title' ) ]); ?>

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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\education/create.blade.php ENDPATH**/ ?>