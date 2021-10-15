<div class="card">
    <div class="card-body">
        <h5 class="card-title text-primary">System Settings
            <small class="text-info font-13">(You can update here the organizational settings. These settings will effect
                all the campuses of this organization.
                .)</small>
        </h5>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                {!! Form::label('theme_color', __('lang_v1.theme_color')); !!}
                {!! Form::select('theme_color', $theme_colors, $general_settings->theme_color,
                ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'style' => 'width: 100%;']); !!}

            </div>
            <div class="col-sm-4">
                @php
                $page_entries = [25 => 25, 50 => 50, 100 => 100, 200 => 200, 500 => 500, 1000 => 1000, -1 => __('lang_v1.all')];
                @endphp
                {!! Form::label('default_datatable_page_entries', __('lang_v1.default_datatable_page_entries')); !!}
                {!! Form::select('common_settings[default_datatable_page_entries]', $page_entries, !empty($common_settings['default_datatable_page_entries']) ? $common_settings['default_datatable_page_entries'] : 25 ,
                ['class' => 'form-control select2', 'style' => 'width: 100%;', 'id' => 'default_datatable_page_entries']); !!}

            </div>
            <div class="col-sm-4">
                {{-- <div class="checkbox mt-3">
                        <label class="form-lable">
                            {!! Form::checkbox('enable_tooltip', 1, $general_settings->enable_tooltip ,
                            [ 'class' => 'form-check-input big-checkbox']); !!} <span class="mt-3"> {{ __( 'system_settings.show_help_text' ) }}</span>
                </label>
            </div> --}}
            <div class="form-check mt-3 ">
            {!! Form::checkbox('enable_tooltip', 1, $general_settings->enable_tooltip ,[ 'class' => 'form-check-input big-checkbox']); !!}
                <label class="form-check-label p-2" >{{ __( 'system_settings.show_help_text' ) }}</label>
            </div>

        </div>
    </div>
</div>

</div>
