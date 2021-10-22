
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    {!! Form::open(['url' => action('\App\Http\Controllers\SessionController@update', [$session->id]), 'method' => 'PUT', 'id' => 'session_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('session.update_session')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">@lang('session.update')</button>
        </div>

        <div class="modal-body">
        <p class="text-muted">@lang('session.update_sessions_here._please_provide_required_information_to_proceed_next.')</p>
            <div class="form-group">
        {!! Form::label('session', __( 'session.session_information' ) . ':*') !!}
          {!! Form::text('title', $session->title, ['class' => 'form-control', 'required', 'placeholder' => __( 'session.session_title' ) ]); !!}
            </div>
            
        </div>
        <div class="modal-footer">
            
      <button type="submit" class="btn btn-primary">@lang( 'global_lang.update' )</button>
      <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
        </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
