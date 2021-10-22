
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    {!! Form::open(['url' => action('AccountController@store'), 'method' => 'post', 'id' => 'payment_account_form' ]) !!}

        <div class="modal-header bg-primary">
            <h4 class="modal-title">@lang( 'account.add_account' )</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">

                        <div class="form-group">
                {!! Form::label('name', __( 'lang_v1.name' ) .":*") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required','placeholder' => __( 'lang_v1.name' ) ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('account_number', __( 'account.account_number' ) .":*") !!}
                {!! Form::text('account_number', null, ['class' => 'form-control', 'required','placeholder' => __( 'account.account_number' ) ]); !!}
            </div>

            <div class="form-group">
                {!! Form::label('account_type_id', __( 'account.account_type' ) .":") !!}
                 <select name="account_type_id" class="form-control select2" style = "width: 100%;">
                    <option>@lang('messages.please_select')</option>
                    @foreach($account_types as $account_type)
                        <optgroup label="{{$account_type->name}}">
                            <option value="{{$account_type->id}}">{{$account_type->name}}</option>
                            @foreach($account_type->sub_types as $sub_type)
                                <option value="{{$sub_type->id}}">{{$sub_type->name}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                {!! Form::label('opening_balance', __( 'account.opening_balance' ) .":") !!}
                {!! Form::text('opening_balance', 0, ['class' => 'form-control input_number','placeholder' => __( 'account.opening_balance' ) ]); !!}
            </div>

        
            <div class="form-group">
                {!! Form::label('note', __( 'account.note' )) !!}
                {!! Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __( 'account.note' ), 'rows' => 4]); !!}
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





