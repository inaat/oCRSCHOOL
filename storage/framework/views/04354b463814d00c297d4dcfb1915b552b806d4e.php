<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('Curriculum\ClassTimeTablePeriodController@update', [$classTimeTablePeriod->id]), 'method' => 'PUT', 'id' => 'period_edit_form' ]); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.edit_period'); ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

         <div class="modal-body">
            <div class="row ">
               <div class="col-md-12 p-2 ">
                    <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                    <?php echo Form::select('campus_id', $campuses,$classTimeTablePeriod->campus_id,['class' => 'form-select select2 global-campuses', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                </div>
                <div class="col-md-12 p-2">
                    <?php echo Form::label('name', __('lang.name') . ':*'); ?>

                    <?php echo Form::text('name',  $classTimeTablePeriod->name, ['class' => 'form-control', 'placeholder' => __('lang.name'), 'required']); ?>


                </div>
                <div class="col-md-12 p-2">
                    <?php echo Form::label('type', __('lang.type') . ':*'); ?> 
                    <?php echo Form::select('type', __('lang.period_type'),  $classTimeTablePeriod->type, ['class' => 'form-control select2', 'required','placeholder' => __('messages.please_select')]); ?>


                </div>
                <div class="col-md-12 p-2 time_div" id="start_timepicker" data-target-input="nearest"
                    data-target="#start_timepicker" data-toggle="datetimepicker">
                    <?php echo Form::label('start_time', __('lang.start_time') . ':*'); ?>

                    <div class="input-group flex-nowrap input-group-append  input-group date">
                        <?php echo Form::text('start_time',  \Carbon::createFromTimestamp(strtotime($classTimeTablePeriod->start_time))->format('h:i A'), ['class' => 'form-control datetimepicker-input', 'data-target' => '#start_timepicker', 'required']); ?>

                        <span class="input-group-text" id="addon-wrapping"><i class="fa fa-clock"></i></span>
                    </div>
                </div>
                <div class="col-md-12 p-2 time_div" id="end_timepicker" data-target-input="nearest"
                    data-target="#end_timepicker" data-toggle="datetimepicker">
                    <?php echo Form::label('end_time', __('lang.end_time') . ':*'); ?>

                    <div class="input-group flex-nowrap input-group-append  input-group date">
                        <?php echo Form::text('end_time', \Carbon::createFromTimestamp(strtotime($classTimeTablePeriod->end_time))->format('h:i A'), ['class' => 'form-control datetimepicker-input', 'data-target' => '#end_timepicker', 'required']); ?>

                        <span class="input-group-text" id="addon-wrapping"><i class="fa fa-clock"></i></span>
                    </div>
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
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\class_time_table_period/edit.blade.php ENDPATH**/ ?>