<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('Curriculum\ClassSubjectLessonController@store'), 'method' => 'post', 'id' =>'lesson_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title text-uppercase" id="exampleModalLabel">@lang('lang.add_new_lesson')For<small>(@lang('lang.subject_detail') - {{ $class_subject->name }} of class {{ $class_subject->classes->title }})</small></h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            {!! Form::hidden('subject_id', $class_subject->id,[ 'id' => 'subject_id', ]) !!}
            {!! Form::hidden('campus_id', $class_subject->campus_id,[ 'id' => 'campus_id', ]) !!}

        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-4 p-2 ">
                    {!! Form::label('chapter_number', __('lang.chapters') . ':*') !!}
                    {!! Form::select('chapter_number', $chapters, null, ['class' => 'form-select select2 ', 'required', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-8 p-2 ">
                    {!! Form::label('name', __('lang.lesson_title') . ':*') !!}
                    {!! Form::text('name', null, ['class' => 'form-control  ', 'required','placeholder' => __('lang.lesson_title')]) !!}
                </div>
                <div class="clearfix"></div>
                 <div class="col-md-12 p-2">
                    {!! Form::label('description', __( 'lang.description' ) . ':') !!}
                    {!! Form::textarea('description',null ,['class' => 'form-control', 'rows=4','placeholder' => __( 'lang.description' ) ]); !!}
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
