<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

  		{!! Form::open(['url' => action('Curriculum\ClassTimeTablePeriodController@store') , 'method' => 'post' , 'id' => 'add_period_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.assign_new_period')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
               <div class="col-md-12 p-2 ">
                    {!! Form::label('campus.student', __('campus.campuses') . ':*') !!}
                    {!! Form::select('campus_id', $campuses, null,['class' => 'form-select select2 global-campuses', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-12 p-2">
                    {!! Form::label('name', __('lang.name') . ':*') !!}
                    {!! Form::text('name',  null, ['class' => 'form-control', 'placeholder' => __('lang.name'), 'required']) !!}

                </div>
                <div class="col-md-12 p-2">
                    {!! Form::label('type', __('lang.type') . ':*') !!} 
                    {!! Form::select('type', __('lang.period_type'),  null, ['class' => 'form-control select2', 'required','placeholder' => __('messages.please_select')]) !!}

                </div>
                <div class="col-md-12 p-2 time_div" id="start_timepicker" data-target-input="nearest"
                    data-target="#start_timepicker" data-toggle="datetimepicker">
                    {!! Form::label('start_time', __('lang.start_time') . ':*') !!}
                    <div class="input-group flex-nowrap input-group-append  input-group date">
                        {!! Form::text('start_time',  null, ['class' => 'form-control datetimepicker-input', 'data-target' => '#start_timepicker', 'required']) !!}
                        <span class="input-group-text" id="addon-wrapping"><i class="fa fa-clock"></i></span>
                    </div>
                </div>
                <div class="col-md-12 p-2 time_div" id="end_timepicker" data-target-input="nearest"
                    data-target="#end_timepicker" data-toggle="datetimepicker">
                    {!! Form::label('end_time', __('lang.end_time') . ':*') !!}
                    <div class="input-group flex-nowrap input-group-append  input-group date">
                        {!! Form::text('end_time',  null, ['class' => 'form-control datetimepicker-input', 'data-target' => '#end_timepicker', 'required']) !!}
                        <span class="input-group-text" id="addon-wrapping"><i class="fa fa-clock"></i></span>
                    </div>
                </div>
             {{-- <div class="col-md-12 p-2">
                    {!! Form::label('duration', __('lang.duration') . ':*') !!} 
                    {!! Form::text('total_time', !empty($period->total_time) ? $period->total_time : null, ['class' => 'form-control', 'placeholder' => __('lang.total_time'), 'required']) !!}

                </div> --}}
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
