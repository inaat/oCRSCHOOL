<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('Curriculum\ClassSubjectController@store'), 'method' => 'post', 'id' =>'class_subject_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.add_new_class_subject')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-4 p-2 ">
                    {!! Form::label('campus.student', __('campus.campuses') . ':*') !!}
                    {!! Form::select('campus_id', $campuses, null, ['class' => 'form-select select2 global-campuses', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-4 p-2">
                    {!! Form::label('class.classes', __('class.classes') . ':*') !!}
                    {!! Form::select('class_id', [], null, ['class' => 'form-select select2 global-classes', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-4 p-2">
                    {!! Form::label('name', __( 'lang.class_subject_name' ) . ':') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_name' ) ]); !!}
                </div>
  
                <div class="clear-fix"></div>
                    <div class="col-md-4 p-2">
                    {!! Form::label('code', __( 'lang.class_subject_code' ) . ':') !!}
                    {!! Form::text('code', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.class_subject_code' ) ]); !!}
                </div>
                <div class="col-md-4 p-2">
                    {!! Form::label('passing_percentage', __( 'lang.passing_percentage' ) . ':') !!}
                    {!! Form::number('passing_percentage', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.passing_percentage' ) ]); !!}
                </div>
                <div class="col-md-4 p-2">
                    {!! Form::label('chapters', __( 'lang.chapters' ) . ':') !!}
                    {!! Form::number('chapters', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang.chapters' ) ]); !!}
                </div>
                <div class="col-md-12 p-2">
                    {!! Form::label('description', __( 'lang.description' ) . ':') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control',  'required','rows=4','placeholder' => __( 'lang.description' ) ]); !!}
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary">@lang( 'global_lang.save' )</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
        </div>
    </div>

    {!! Form::close() !!}

</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
