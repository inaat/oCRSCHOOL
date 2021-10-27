<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\SessionController@store'), 'method' => 'post', 'id' =>'session_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('session.register_new_session')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
        <p class="text-muted">@lang('session.register_as_many_sessions_as_you_need._please_provide_required_information_to_proceed_next...')</p>
            <div class="form-group">
            </div>
              <div class="row">
                <div class="col-md-6 p-3">
                    {!! Form::label('session', __( 'session.session_information' ) . ':') !!}
                    {!! Form::text('title', null, ['class' => 'form-control title mask', 'required','min'=>8,'placeholder' => __( 'session.session_title' ) ]); !!}

                </div>

                <div class="col-md-6 p-3">
                    {!! Form::label('prefix', __('session.prefix') . ':*') !!}
                    {!! Form::text('prefix', null, ['class' => 'form-control', 'required', 'placeholder' => __('session.prefix')]) !!}
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
