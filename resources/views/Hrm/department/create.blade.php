<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('HRM\HrmDepartmentController@store'), 'method' => 'post', 'id' =>'department_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('hrm.register_new_department')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted">Register as many departments as you need. Please provide required information to proceed next...</p>
            <div class="form-group">
                {!! Form::label('department', __( 'hrm.department_title' ) . ':*') !!}
                {!! Form::text('department', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'hrm.department_title' ) ]); !!}
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
