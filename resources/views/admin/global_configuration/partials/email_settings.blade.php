<div class="card">
    <div class="card-body">
        <h5 class="card-title text-primary">Email Settings
            <small class="text-info font-13">(You can update here the organizational settings. These settings will effect
                all the campuses of this organization.
                .)</small>
        </h5>
        <hr>
        <div class="row">  
            <div class="col-md-4 p-3">
                    {!! Form::label('mail_driver', __('lang_v1.mail_driver') . ':' , ['classs' => 'form-lable']) !!}
                    {!! Form::select('email_settings[mail_driver]', $mail_drivers, !empty($email_settings['mail_driver']) ? $email_settings['mail_driver'] : 'mdtp', ['class' => 'select2', 'id' => 'mail_driver']); !!}
            </div>
            <div class="col-md-4 p-3">
                    {!! Form::label('mail_host', __('lang_v1.mail_host') . ':') !!}
                    {!! Form::text('email_settings[mail_host]', $email_settings['mail_host'], ['class' => 'form-control','placeholder' => __('lang_v1.mail_host'), 'id' => 'mail_host']); !!}
            </div>
            <div class="col-md-4 p-3">
            	{!! Form::label('mail_port' , __('lang_v1.mail_port') . ':') !!}
            	{!! Form::text('email_settings[mail_port]', $email_settings['mail_port'], ['class' => 'form-control','placeholder' => __('lang_v1.mail_port'), 'id' => 'mail_port']); !!}
            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('mail_username', __('lang_v1.mail_username') . ':') !!}
                {!! Form::text('email_settings[mail_username]', $email_settings['mail_username'], ['class' => 'form-control','placeholder' => __('lang_v1.mail_username'), 'id' => 'mail_username']); !!}

            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('mail_password', __('lang_v1.mail_password') . ':') !!}
                <input type="password" name="email_settings[mail_password]" value="{{$email_settings['mail_password']}}" class="form-control" placeholder="{{__('lang_v1.mail_password')}}", id="mail_password">

            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('mail_encryption', __('lang_v1.mail_encryption') . ':') !!}
                {!! Form::text('email_settings[mail_encryption]', $email_settings['mail_encryption'], ['class' => 'form-control','placeholder' => __('lang_v1.mail_encryption_place'), 'id' => 'mail_encryption']); !!}

            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('mail_from_address', __('lang_v1.mail_from_address') . ':') !!}
                {!! Form::email('email_settings[mail_from_address]', $email_settings['mail_from_address'], ['class' => 'form-control','placeholder' => __('lang_v1.mail_from_address'), 'id' => 'mail_from_address' ]); !!}

            </div>
            <div class="col-md-4 p-3">
                {!! Form::label('mail_from_name', __('lang_v1.mail_from_name') . ':') !!}
                {!! Form::text('email_settings[mail_from_name]', $email_settings['mail_from_name'], ['class' => 'form-control','placeholder' => __('lang_v1.mail_from_name'), 'id' => 'mail_from_name']); !!}

            </div>

<div class="clearfix"></div>
        <div class="col-xs-12 test_email_btn @if(!empty($email_settings['use_superadmin_settings'])) hide @endif">
            <button type="button" class="btn btn-success pull-right" id="test_email_btn">@lang('lang_v1.test_email_configuration')</button>
        </div>
        </div>
    </div>

</div>
