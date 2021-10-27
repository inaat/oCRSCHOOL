<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\ProvinceController@store'), 'method' => 'post', 'id' =>'province_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.add_new_province')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">

                <div class="col-md-6 p-3">
                   
                    {!! Form::label('lang.countries', __('lang.countries') . ':*') !!}
                    {!! Form::select('country_id',$countries,null, ['class' => 'form-select select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('lang.please_select')]) !!}

                </div>

                <div class="col-md-6 p-3">
                    {!! Form::label('lang.province_name', __('lang.province_name') . ':*') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang.province_name')]) !!}
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
