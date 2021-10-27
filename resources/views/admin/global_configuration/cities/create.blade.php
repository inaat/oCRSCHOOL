<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\CityController@store'), 'method' => 'post', 'id' =>'city_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('lang.add_new_city')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
               

                  <div class="col-md-6 p-3">
                    {!! Form::label('country_id', __('lang.country_name') . ':*') !!}
                    {!! Form::select('country_id',$countries,null, ['class' => 'form-select  select2 ','required','id'=>'country_id', 'style' => 'width:100%', 'required', 'placeholder' => __('lang.please_select')]) !!}
                </div>
                <div class="col-md-6 p-3">
                    {!! Form::label('province_id', __('lang.provinces') . ':*') !!}
                    {!! Form::select('province_id',[],null, ['class' => 'form-select  select2 ','required', 'style' => 'width:100%', 'required','id' => 'provinces_ids','placeholder' => __('lang.please_select')]) !!}
                </div>
                 <div class="col-md-6 p-3">
                    {!! Form::label('district_id', __('lang.district_name') . ':*') !!}
                    {!! Form::select('district_id',[],null, ['class' => 'form-select  select2 ','required', 'style' => 'width:100%', 'required','id' => 'district_ids','placeholder' => __('lang.district_name')]) !!}
                </div>
                <div class="col-md-6 p-3">
                    {!! Form::label('name', __('lang.city_name') . ':*', ['classs' => 'form-lable']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang.city_name')]) !!}

                </div>
                <div class="clearfix"></div>

            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary">@lang( 'lang.save' )</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'lang.close' )</button>
            </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

