<div class="modal fade" id="update_employee_status_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

		<?php echo Form::open(['url' => action('HRM\HrmEmployeeController@updateStatus'), 'method' => 'post', 'id' => 'update_employee_status_form' ]); ?>



           <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('hrm.update_status'); ?>
                </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

		<div class="modal-body">
			<div class="form-group">
				<?php echo Form::label('status', __('hrm.employee_status') . ':*'); ?> 
				<?php echo Form::select('status', __('hrm.emp_status'), null, ['class' => 'form-select', 'placeholder' => __('messages.please_select'), 'required']); ?>


				<?php echo Form::hidden('employee_id', null, ['id' => 'employee_id']); ?>

			</div>
		</div>

		<div class="modal-footer">
			
            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'hrm.update' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'hrm.close' ); ?></button>

		</div>

		<?php echo Form::close(); ?>


		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm/employee/partials/update_employee_status_modal.blade.php ENDPATH**/ ?>