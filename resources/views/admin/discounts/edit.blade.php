<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('\App\Http\Controllers\DiscountController@update',[$discount->id]), 'method' => 'PUT', 'id' =>'discount_edit_form' ]) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('discount.edit_discount')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 p-3">
                    {!! Form::label('discount_name', __('discount.discount_name') . ':*', ['classs' => 'form-lable']) !!}
                    {!! Form::text('discount_name',$discount->discount_name, ['class' => 'form-control', 'required', 'placeholder' => __('discount.discount_name')]) !!}

                </div>
                <div class="col-md-6 p-3">
                    {!! Form::label('campus.campuses', __('campus.campuses') . ':*') !!}
                    {!! Form::select('campus_id',$campuses,$discount->campus_id, ['class' => 'form-select  select2 ','required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]) !!}
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6 p-3">
                    {!! Form::label('discount_type', __('discount.discount_type') . ':*') !!}
                    {!! Form::select('discount_type', ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], $discount->discount_type, ['style' => 'width:100%', 'placeholder' => __('messages.please_select'), 'class' => 'form-select  select2', 'required']); !!}

                </div>

                <div class="col-md-6 p-3">
                    {!! Form::label('discount_amount', __( 'discount.discount_amount' ) . ':*') !!}
                    {!! Form::text('discount_amount',@num_format($discount->discount_amount), ['class' => 'form-control input_number', 'required', 'placeholder' => __( 'discount.discount_amount' ) ]); !!}

                </div>


                <div class="clearfix"></div>
            </div>


            <div class="modal-footer">




                <button type="submit" class="btn btn-primary">@lang( 'global_lang.update' )</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">@lang( 'global_lang.close' )</button>
            </div>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

