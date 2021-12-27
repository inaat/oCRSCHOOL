<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

  		{!! Form::open(['url' => action('Curriculum\ClassTimeTableController@store') , 'method' => 'post' , 'id' => 'add_time_table_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.assign_new_period')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
               <div class="col-md-4 p-2 ">
                    {!! Form::label('campus.student', __('campus.campuses') . ':*') !!}
                    {!! Form::select('campus_id', $campuses, null,['class' => 'form-select select2 global-campuses','style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-4 p-2">
                    {!! Form::label('class.classes', __('class.classes') . ':*') !!}
                    {!! Form::select('class_id',[],null, ['class' => 'form-select  select2 global-classes ','style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-4 p-2">
                {!! Form::label('class_section.sections', __('class_section.sections') . ':*') !!}
                {!! Form::select('class_section_id', [], null, ['class' => 'form-select select2 global-class_sections', 'required', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-4 p-2">
                {!! Form::label('subjects', __('lang.subjects') . ':') !!}
                {!! Form::select('subject_id', [], null, ['class' => 'form-select select2 global-subjects', 'id' => 'subjects', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                </div>
                <div class="col-md-4 p-2">
                {!! Form::label('periods', __('lang.periods') . ':*') !!}
                {!! Form::select('period_id', [], null, ['class' => 'form-select select2 global-periods','required', 'id' => 'periods', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
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
<script type="text/javascript">
    $(document).ready(function() {
         $("form#add_time_table_form").validate({
        rules: {
            period_id: {
                required: true,
            },
        },
    });
      
       
    });

</script>