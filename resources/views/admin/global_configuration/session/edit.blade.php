{{-- <div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('\App\Http\Controllers\SessionController@update', [$session->id]), 'method' => 'PUT', 'id' => 'session_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'session.edit_session' )</h4>
    </div>

    <div class="modal-body">
       <div class="form-group">
        {!! Form::label('session', __( 'session.session_name' ) . ':*') !!}
          {!! Form::text('session', $session->session, ['class' => 'form-control', 'required', 'placeholder' => __( 'session.session_name' ) ]); !!}
      </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'global_lang.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'global_lang.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog --> --}}



<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    {!! Form::open(['url' => action('\App\Http\Controllers\SessionController@update', [$session->id]), 'method' => 'PUT', 'id' => 'session_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Update Session(Sping)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted">Update sessions here. Please provide required information to proceed next...</p>
            <div class="form-group">
        {!! Form::label('session', __( 'session.session_title' ) . ':*') !!}
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
