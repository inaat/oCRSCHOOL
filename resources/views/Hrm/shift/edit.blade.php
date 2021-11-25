<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('HRM\HrmLeaveCategoryController@update', [$leave_category->id]), 'method' => 'PUT', 'id' => 'leave_category_edit_form']) !!}

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">@lang('hrm.update_leave_category')</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row ">
                <div class="col-md-12 p-1">
                    {!! Form::label('leave_category', __('hrm.leave_category_name') . ':*') !!}
                    {!! Form::text('leave_category', $leave_category->leave_category, ['class' => 'form-control', 'required', 'placeholder' => __('hrm.leave_category_name')]) !!}
                </div>
                <div class="col-md-12 p-1">
                    {!! Form::label('leave_category_description', __('hrm.description') . ':') !!}
                    {!! Form::textarea('leave_category_description', $leave_category->leave_category_description, ['class' => 'form-control', 'required', 'placeholder' => __('hrm.description')]) !!}

                </div>
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
