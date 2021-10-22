<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\RegionController@store'), 'method' => 'post', 'id' =>'region_add_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('class.add_new_region')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    {!! Form::label('city', __('region.city') . ':*', ['classs' => 'form-lable']) !!}
                    {!! Form::text('city', null, ['class' => 'form-control', 'required', 'placeholder' => __('region.city')]) !!}

                </div>

                <div class="col-md-6 p-3">
                    {!! Form::label('region.village', __('region.village') . ':*') !!}
                    {!! Form::text('village', null, ['class' => 'form-control', 'required', 'placeholder' => __('region.village')]) !!}
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

