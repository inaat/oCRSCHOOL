<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\ClassController@update',[$classes->id]), 'method' => 'PUT', 'id' =>'class_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('class.edit_class')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    {!! Form::label('title', __('class.title') . ':*', ['classs' => 'form-lable']) !!}
                    {!! Form::text('title', $classes->title, ['class' => 'form-control', 'required', 'placeholder' => __('class.title')]) !!}

                </div>
                <div class="col-md-6 p-3">
                    {!! Form::label('campus.campuses', __('campus.campuses') . ':*') !!}
                    {!! Form::select('campus_id',$campuses,$classes->campus_id, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    {!! Form::label('class_level.class_level', __('class_level.class_levels') . ':*') !!}
                    {!! Form::select('class_level_id',$classLevel,$classes->class_level_id, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-6 p-3">
                    {!! Form::label('tuition_fee', __( 'class.tuition_fee' ) . ':*') !!}
                    {!! Form::text('tuition_fee',@num_format($classes->tuition_fee), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'class.tuition_fee' ) ]); !!}

                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    {!! Form::label('admission_fee', __( 'class.admission_fee' ) . ':*') !!}
                    {!! Form::text('admission_fee',@num_format($classes->admission_fee), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'class.admission_fee' ) ]); !!}

                </div>

                <div class="col-md-6 p-3">
                    {!! Form::label('transport_fee', __('lang.transport_fee') . ':*') !!}
                    {!! Form::text('transport_fee',@num_format($classes->transport_fee), ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.transport_fee')]) !!}

                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    {!! Form::label('security_fee', __('lang.security_fee') . ':*') !!}
                    {!! Form::text('security_fee',@num_format($classes->security_fee), ['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.security_fee')]) !!}

                </div>

                <div class="col-md-6 p-3">
                    {!! Form::label('prospectus_fee', __('lang.prospectus_fee') . ':*') !!}
                    {!! Form::text('prospectus_fee',@num_format($classes->prospectus_fee) ,['class' => 'form-control input_number', 'required', 'placeholder' => __('lang.prospectus_fee')]) !!}

                </div>
            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary">@lang( 'lang.update' )</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'lang.close' )</button>
            </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
