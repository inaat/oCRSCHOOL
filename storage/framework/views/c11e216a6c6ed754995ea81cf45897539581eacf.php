<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('HRM\HrmLeaveCategoryController@update', [$leave_category->id]), 'method' => 'PUT', 'id' => 'leave_category_edit_form']); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('hrm.update_leave_category'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
                <div class="col-md-12 p-1">
                    <?php echo Form::label('leave_category', __('hrm.leave_category_name') . ':*'); ?>

                    <?php echo Form::text('leave_category', $leave_category->leave_category, ['class' => 'form-control', 'required', 'placeholder' => __('hrm.leave_category_name')]); ?>

                </div>
                <div class="col-md-12 p-1">
                    <?php echo Form::label('max_leave_count', __('essentials::lang.max_leave_count') . ':'); ?>

                    <?php echo Form::number('max_leave_count', $leave_category->max_leave_count, ['class' => 'form-control', 'placeholder' => __('essentials::lang.max_leave_count')]); ?>

                </div>
                <div class="col-md-12 p-1">
                    <strong><?php echo app('translator')->get('hrm.leave_count_interval'); ?></strong><br>
                    <label class="radio-inline">
                        <?php echo Form::radio('leave_count_interval', 'month', $leave_category->leave_count_interval == 'month', ['class' => 'form-check-input']); ?> <?php echo app('translator')->get('hrm.current_month'); ?>
                    </label>
                    <label class="radio-inline">
                        <?php echo Form::radio('leave_count_interval', 'year', $leave_category->leave_count_interval == 'year', ['class' => 'form-check-input']); ?> <?php echo app('translator')->get('hrm.current_fy'); ?>
                    </label>
                    <label class="radio-inline">
                        <?php echo Form::radio('leave_count_interval', null, empty($leave_category->leave_count_interval), ['class' => 'form-check-input']); ?> <?php echo app('translator')->get('hrm.none'); ?>
                    </label>
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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\leave_category/edit.blade.php ENDPATH**/ ?>