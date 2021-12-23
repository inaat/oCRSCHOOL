<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('Curriculum\ClassSubjectQuestionBankController@update', [$class_subject_question_bank->id]), 'method' => 'PUT', 'id' => 'question_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title text-uppercase" id="exampleModalLabel">@lang('lang.edit_question') For <small>(@lang('lang.subject_detail') - {{ $class_subject->name }} of class {{ $class_subject->classes->title }})</small></h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        {!! Form::hidden('subject_id', $class_subject->id,[ 'id' => 'subject_id', ]) !!}
        {!! Form::hidden('campus_id', $class_subject->campus_id,[ 'id' => 'campus_id', ]) !!}

        <div class="modal-body">
            <div class="row m-0">
                <div class="col-md-3 p-2  ">
                    {!! Form::label('chapter_number', __('lang.chapters') . ':*') !!}
                    {!! Form::select('chapter_number', $chapters, $class_subject_question_bank->chapter_number, ['class' => 'form-select select2 chapter_question', 'required', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-3 p-2 ">
                    {!! Form::label('lesson_id', __('lang.lessons') . ':*') !!}
                    {!! Form::select('lesson_id', $lesson, $class_subject_question_bank->lesson_id, ['class' => 'form-select select2 lessons', 'required', 'id' => '','style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-3 p-2">
                    {!! Form::label('lang.question_types', __('lang.question_types') . ':*') !!}
                    {!! Form::select('type',__('lang.question_type'),$class_subject_question_bank->type, ['class' => 'form-select select2 question_type', 'disabled'=>'true' ,'required', 'style' => 'width:100%']) !!}
                </div>
                <div class="col-md-3 p-2">
                    {!! Form::label('lang.marks', __('lang.marks') . ':*') !!}
                    {!! Form::text('marks', $class_subject_question_bank->marks, ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'lang.marks' ) ]); !!}
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        {!! Form::label('question', __('lang.question') . ':') !!}
                        {!! Form::textarea('question',$class_subject_question_bank->question, ['class' => 'form-control','row'=>4,'required' ]); !!}
                        <span class="question_type_error error"></span>

                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
             
            <div class="row mt-1 mcqs-form @if($class_subject_question_bank->type == 'mcq') @else hide @endif">
                <div class="col-md-3">
                    {!! Form::label('name', __('lang.option_a') . ':*') !!}
                    <div class="mcq"> <i class="mcq-badge badge bg-primary">A</i>
                        {!! Form::text('option_a',$class_subject_question_bank->option_a, ['class' => 'form-control mcqs-form-input', 'required','placeholder' => __('lang.option_a')]) !!}</div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('name', __('lang.option_b') . ':*') !!}
                    <div class="mcq"> <i class="mcq-badge badge bg-primary">B</i>
                        {!! Form::text('option_b',$class_subject_question_bank->option_b, ['class' => 'form-control mcqs-form-input', 'required','placeholder' => __('lang.option_b')]) !!}</div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('name', __('lang.option_c') . ':*') !!}
                    <div class="mcq"> <i class="mcq-badge badge bg-primary">C</i>
                        {!! Form::text('option_c',$class_subject_question_bank->option_c, ['class' => 'form-control mcqs-form-input', 'required','placeholder' => __('lang.option_c')]) !!}</div>
                </div>
                <div class="col-md-3">
                    {!! Form::label('name', __('lang.option_d') . ':*') !!}
                    <div class="mcq"> <i class="mcq-badge badge bg-primary">D</i>
                        {!! Form::text('option_d',$class_subject_question_bank->option_d, ['class' => 'form-control mcqs-form-input', 'required','placeholder' => __('lang.option_d')]) !!}</div>
                </div>

            </div>
            
            <div class="row mt-1 form-data ">

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        {!! Form::label('hint', __('lang.hint') . ':') !!}
                        {!! Form::textarea('hint',$class_subject_question_bank->hint, ['class' => 'form-control','row'=>4]); !!}
                    </div>
                </div>
                <div class="col-md-4 p-2  hide-answer @if($class_subject_question_bank->type == 'mcq'|| $class_subject_question_bank->type == 'true_and_false') @else hide @endif">
                  @if($class_subject_question_bank->type == 'mcq')
                    {!! Form::label('lang.answer', __('lang.answer') . ':*') !!}
                    {!! Form::select('answer',__('lang.quest_options'),$class_subject_question_bank->answer, ['class' => 'form-select select2 answer-input','placeholder' => __('lang.please_select'), 'required', 'style' => 'width:100%']) !!}
                   @else
                                       {!! Form::label('lang.answer', __('lang.answer') . ':*') !!}
                    {!! Form::select('answer',__('lang.true_false'),$class_subject_question_bank->answer, ['class' => 'form-select select2 answer-input','placeholder' => __('lang.please_select'), 'required', 'style' => 'width:100%']) !!}

                    @endif
                </div>
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

<script type="text/javascript">
    $(document).ready(function() {
         $("form#question_edit_form").validate({
        rules: {
            question: {
                required: true,
            },
        },
    });
      
       
    });

</script>
