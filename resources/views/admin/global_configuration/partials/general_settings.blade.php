<div class="card">
    <div class="card-body">
        <h5 class="card-title text-primary">General Settings
            <small class="text-info font-13">(You can update here the organizational settings. These settings will effect
                all the campuses of this organization.
                .)</small>
        </h5>
        <hr>
        
        <div class="row">
            <div class="col-md-4 p-3">
                {!! Form::label('org_name', __('Organazation Name') . ':*', ['classs' => 'form-lable']) !!}
                {!! Form::text('org_name', $general_settings->org_name, ['class' => 'form-control','required','placeholder' => __('Organazation Name')]) !!}
                @if ($errors->has('org_name'))
                    <span class="text-danger">{{ $errors->first('org_name') }}</span>
                @endif
                <div class="invalid-feedback">Looks good!</div>

            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('org_address', __('Organazation Address') . ':*', ['classs' => 'form-lable']) !!}
                {!! Form::text('org_address', $general_settings->org_address, ['class' => 'form-control', 'required', 'placeholder' => __('Organazation Address')]) !!}

            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('org_contact_number', __('Organazation Contact Number') . ':*', ['classs' => 'form-lable']) !!}
                {!! Form::text('org_contact_number', $general_settings->org_contact_number, ['class' => 'form-control', 'pattern' => '\d{11}', 'required', 'maxlength' => '11', 'placeholder' => __('Organazation Contact Number')]) !!}

            </div>

            <div class="clearfix"></div>
            <div class="col-sm-4 p-3">
                {!! Form::label('start_date', __('settings.start_date') . ':*', ['classs' => 'form-lable']) !!}

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fa fa-calendar"></i></span>

                    {!! Form::text('start_date', @format_date($general_settings->start_date), ['class' => 'form-control start-date-picker', 'placeholder' => __('settings.start_date'), 'readonly']) !!}

                </div>
            </div>
            <div class="col-sm-4 p-3">
                {!! Form::label('school_name', __('settings.currency') . ':*', ['classs' => 'form-lable']) !!}

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fas fa-money-bill-alt"></i></span>

                    {!! Form::select('currency_id', $currencies, $general_settings->currency_id, ['class' => 'form-control select2', 'placeholder' => __('settings.currency'), 'required']) !!}

                </div>
            </div>
            <div class="col-md-4  p-3 ">
                <div class="form-group">
                    {!! Form::label('currency_symbol_placement', __('global_lang.currency_symbol_placement') . ':') !!}
                    {!! Form::select('currency_symbol_placement', ['before' => __('global_lang.before_amount'), 'after' => __('global_lang.after_amount')], $general_settings->currency_symbol_placement, ['class' => 'form-control select2', 'required']) !!}
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-4 p-3">
                {!! Form::label('session_start_month', __('settings.session_start_month') . ':') !!} @show_tooltip(__('tooltip.session_start_month'))

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fa fa-calendar"></i></span>

                    {!! Form::select('session_start_month', $month_list, $general_settings->session_start_month, ['class' => 'form-control select2', 'required']) !!}

                </div>
            </div>
            <div class="col-sm-4 p-3">
                {!! Form::label('transaction_edit_days', __('settings.transaction_edit_days') . ':*') !!} @show_tooltip(__('tooltip.transaction_edit_days'))

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fa fa-edit"></i></span>

                    {!! Form::number('transaction_edit_days', $general_settings->transaction_edit_days, ['class' => 'form-control input_number', 'min' => '0', 'placeholder' => __('settings.transaction_edit_days'), 'required']) !!}

                </div>
            </div>

            <div class="col-sm-4 p-3">
                {!! Form::label('date_format', __('global_lang.date_format') . ':*') !!}

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fa fa-calendar"></i></span>

                    {!! Form::select('date_format', $date_formats, $general_settings->date_format, ['class' => 'form-control select2', 'required']) !!}

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-sm-4  p-3">
                {!! Form::label('time_zone', __('settings.time_zone') . ':*', ['classs' => 'form-lable']) !!}

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fas fa-clock"></i></span>

                    {!! Form::select('time_zone', $timezone_list, $general_settings->time_zone, ['class' => 'form-control select2', 'required']) !!}

                </div>
            </div>
            <div class="col-sm-4 p-3">
                {!! Form::label('time_format', __('global_lang.time_format') . ':*') !!}

                <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i
                            class="fas fa-clock"></i></span>

                    {!! Form::select('time_format', [12 => __('global_lang.12_hour'), 24 => __('global_lang.24_hour')], $general_settings->time_format, ['class' => 'form-control select2', 'required']) !!}

                </div>
            </div>
        </div>
        <div class="row p-3">
            <div class="col-sm-4">
                <h5 class="card-title ">Organazation Logo</h5>
                <img src="{{'uploads/business_logos/'.$general_settings->org_logo }}" class="org_logo card-img-top" width="170" height="170"
                    alt="...">
                     {!! Form::label('org_logo', __('Organazation Logo') . ':') !!}
                    {!! Form::file('org_logo', ['accept' => 'image/*','class' => 'form-control upload_org_logo']); !!}
                    <p class="card-text fs-6 help-block"><i> @lang('settings.logo_help')</i></p>
            </div>
            <div class="col-sm-4">
                <h5 class="card-title ">Organazation Favicon</h5>

                <img src="{{'uploads/business_logos/'.$general_settings->org_favicon }}" class="org_favicon card-img-top" width="170" height="170"
                    alt="...">
                     {!! Form::label('org_favicon', __('Organazation Favicon') . ':') !!}
                    {!! Form::file('org_favicon', ['accept' => 'image/*','class' => 'form-control upload_org_favicon']); !!}
                    <p class="card-text fs-6 help-block"><i> @lang('settings.logo_help')</i></p>
            </div>
           
        </div>
        
     

    </div>
</div>
