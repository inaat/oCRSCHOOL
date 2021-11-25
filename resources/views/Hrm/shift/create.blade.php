<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

  		{!! Form::open(['url' => empty($shift) ? action('HRM\HrmShiftController@store') : action('HRM\HrmShiftController@update', [$shift->id]), 'method' => empty($shift) ? 'post' : 'put', 'id' => 'add_shift_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('hrm.add_shift')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
                <div class="col-md-12 p-2">
                    {!! Form::label('name', __('hrm.name') . ':*') !!}
                    {!! Form::text('name', !empty($shift->name) ? $shift->name : null, ['class' => 'form-control', 'placeholder' => __('hrm.name'), 'required']) !!}

                </div>
                <div class="col-md-12 p-2">
                    {!! Form::label('type', __('hrm.shift_type') . ':*') !!} @show_tooltip(__('hrm.shift_type_tooltip'))
                    {!! Form::select('type', ['fixed_shift' => __('hrm.fixed_shift'), 'flexible_shift' => __('hrm.flexible_shift')], !empty($shift->type) ? $shift->type : null, ['class' => 'form-control select2', 'required', 'id' => 'shift_type']) !!}

                </div>
                <div class="col-md-12 p-2 time_div" id="start_timepicker" data-target-input="nearest"
                    data-target="#start_timepicker" data-toggle="datetimepicker">
                    {!! Form::label('start_time', __('hrm.start_time') . ':*') !!}
                    <div class="input-group flex-nowrap input-group-append  input-group date">
                        {!! Form::text('start_time', !empty($shift->start_time) ? @format_time($shift->start_time) : null, ['class' => 'form-control datetimepicker-input', 'data-target' => '#start_timepicker', 'required']) !!}
                        <span class="input-group-text" id="addon-wrapping"><i class="fa fa-clock"></i></span>
                    </div>
                </div>
                <div class="col-md-12 p-2 time_div" id="end_timepicker" data-target-input="nearest"
                    data-target="#end_timepicker" data-toggle="datetimepicker">
                    {!! Form::label('end_time', __('hrm.end_time') . ':*') !!}
                    <div class="input-group flex-nowrap input-group-append  input-group date">
                        {!! Form::text('end_time', !empty($shift->end_time) ? @format_time($shift->end_time) : null, ['class' => 'form-control datetimepicker-input', 'data-target' => '#end_timepicker', 'required']) !!}
                        <span class="input-group-text" id="addon-wrapping"><i class="fa fa-clock"></i></span>
                    </div>
                </div>
                <div class="col-md-12 p-2" >
                	        	{!! Form::label('holidays', __( 'hrm.holiday' ) . ':') !!}
	        	{!! Form::select('holidays[]', $days,  !empty($shift->holidays) ? $shift->holidays : null, ['class' => 'form-control select2', 'multiple' ]); !!}

                   
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'lang.close' )</button>
        </div>
    </div>

    {!! Form::close() !!}

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
