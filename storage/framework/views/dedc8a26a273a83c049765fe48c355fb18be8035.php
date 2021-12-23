<div class="modal fade" id="employee_resign_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

		<?php echo Form::open(['url' => action('HRM\HrmEmployeeController@employeeResign'), 'method' => 'post', 'id' => 'employee_resign_form','files' => true ]); ?>



           <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('hrm.employee_resign'); ?>
                </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

		<div class="modal-body">
		   
		     <strong><?php echo app('translator')->get('hrm.employee_name'); ?>:</strong>
                            </strong><span id="employee_name"></span></strong><br>
			<div class="form-group pt-2">
			      <?php echo Form::label('resign', __('hrm.attach_resign') . ':'); ?>

                            <?php echo Form::file('resign', ['class' => 'form-control upload_document', 'accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); ?>

                            <?php echo app('translator')->get('account.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]); ?>
                            <?php if ($__env->exists('components.document_help_text')) echo $__env->make('components.document_help_text', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php echo Form::hidden('employee_id', null, ['id' => 'employee_id']); ?>

			</div>
	         <div class="col-md-12 p-1">
                <?php echo Form::label('remark', __('lang.remark') . ':'); ?>

                <?php echo Form::textarea('resign_remark',null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('lang.remark')]); ?>


            </div>
		</div>

		<div class="modal-footer">
			
            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'hrm.update' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'hrm.close' ); ?></button>

		</div>

		<?php echo Form::close(); ?>


		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm/employee/partials/employee_resign_modal.blade.php ENDPATH**/ ?>