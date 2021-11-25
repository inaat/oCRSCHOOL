<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\ClassSectionController@update',[$sections->id]), 'method' => 'PUT', 'id' =>'class_section_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('class_section.edit_section')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    {!! Form::label('class_section.section_name', __('class_section.section_name') . ':*', ['classs' => 'form-lable']) !!}
                    {!! Form::text('section_name', $sections->section_name, ['class' => 'form-control ', 'required', 'placeholder' => __('class_section.section_name')]) !!}

                </div>
                <div class="col-md-6 p-3">
                    {!! Form::label('campus.campuses', __('campus.campuses') . ':*') !!}
                    {!! Form::select('campus_id',$campuses,$sections->campus_id, ['class' => 'form-select select2 global-campuses ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="clearfix"></div>

                <div class="col-md-6 p-3">
                    {!! Form::label('class.classes', __('class.classes') . ':*') !!}
                    {!! Form::select('class_id',$classes,$sections->class_id, ['class' => 'form-select select2 global-classes ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="clearfix"></div>
            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary">@lang( 'global_lang.update' )</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
            </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
