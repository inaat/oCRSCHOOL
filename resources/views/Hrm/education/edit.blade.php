
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    {!! Form::open(['url' => action('HRM\HrmEducationController@update', [$education->id]), 'method' => 'PUT', 'id' => 'education_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('hrm.update_education')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted">Update education here. Please provide required information to proceed next...</p>
            <div class="form-group">
        {!! Form::label('education', __( 'hrm.education_title' ) . ':') !!}
          {!! Form::text('education', $education->education, ['class' => 'form-control', 'required', 'placeholder' => __( 'hrm.education_title' ) ]); !!}
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
