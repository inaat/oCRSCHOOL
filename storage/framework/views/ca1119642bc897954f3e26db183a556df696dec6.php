<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('HRM\HrmLeaveCategoryController@store'), 'method' => 'post', 'id' => 'leave_category_add_form']); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('hrm.register_new_leave_category'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
                <div class="col-md-12 p-1 <?php echo e($errors->has('hrm_leave_category') ? ' has-error' : '', false); ?> has-feedback">
                    <?php echo Form::label('leave_category', __('hrm.leave_category_name') . ':*'); ?>

                    <?php echo Form::text('leave_category', null, ['class' => 'form-control', 'required', 'placeholder' => __('hrm.leave_category_name')]); ?>


                    <span class="text-danger error-text leave_category_err"></span>

                </div>
                <div class="col-md-12 p-1">
                    <?php echo Form::label('max_leave_count', __('hrm.max_leave_count') . ':'); ?>

                    <?php echo Form::number('max_leave_count', null, ['class' => 'form-control', 'placeholder' => __('hrm.max_leave_count')]); ?>

                </div>
                <div class="col-md-12 p-1">
                    <strong><?php echo app('translator')->get('hrm.leave_count_interval'); ?></strong><br>
                    <label class="radio-inline">
                        <?php echo Form::radio('leave_count_interval', 'month', false,['class'=>'form-check-input']); ?> <?php echo app('translator')->get('hrm.current_month'); ?>
                    </label>
                    <label class="radio-inline">
                        <?php echo Form::radio('leave_count_interval', 'year', false,['class'=>'form-check-input']); ?> <?php echo app('translator')->get('hrm.current_fy'); ?>
                    </label>
                    <label class="radio-inline">
                        <?php echo Form::radio('leave_count_interval', null, false,['class'=>'form-check-input']); ?> <?php echo app('translator')->get('lang_v1.none'); ?>
                    </label>
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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\leave_category/create.blade.php ENDPATH**/ ?>