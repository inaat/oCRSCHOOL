
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    <?php echo Form::open(['url' => action('HRM\HrmDesignationController@update', [$designation->id]), 'method' => 'PUT', 'id' => 'designation_edit_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('hrm.update_designation'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted">Update designation here. Please provide required information to proceed next...</p>
            <div class="form-group">
        <?php echo Form::label('designation', __( 'hrm.designation_title' ) . ':'); ?>

          <?php echo Form::text('designation', $designation->designation, ['class' => 'form-control', 'required', 'placeholder' => __( 'hrm.designation_title' ) ]); ?>

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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\designation/edit.blade.php ENDPATH**/ ?>