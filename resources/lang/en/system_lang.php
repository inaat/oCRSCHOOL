@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')


    <div class="container-fluid">
       

                
               
            </div>
           


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('phone', __('global_lang.phone') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('global_lang.phone')]) !!}
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', __('global_lang.email') . ':*') !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'required', 'placeholder' => __('global_lang.email')]) !!}
                                </div>
                            </div>
                        </div>
                        <hr>

                        <h4 class="sub-title">@lang('session.session')</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('session_id', __('session.session') . ':') !!}
                                    {!! Form::select('session_id', $sessions, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'session_id', 'placeholder' => __('global_lang.please_select')]) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('start_month', __('session.session_start_month') . ':*') !!}
                                    {!! Form::select('start_month', $month_list, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('global_lang.please_select')]) !!}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="sub-title">@lang('attendance.attendance_type')</h4>

                        <div class="row">

                            <div class="col-sm-12 col-xl-6 mb-30">
                                <h4 class="sub-title">@lang('attendance.attendance')</h4>
                                <div class="form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="radio" checked="checked">
                                            <i class="helper"></i>@lang('attendance.day_wise')
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="radio">
                                            <i class="helper"></i>@lang('attendance.period_wise')
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6 mb-30">
                                <h4 class="sub-title">@lang('attendance.biometric_attendance')</h4>
                                <div class="form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="radio">
                                            <i class="helper"></i>@lang('global_lang.disabled')
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="radio">
                                            <i class="helper"></i>@lang('global_lang.enabled')
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            {!! Form::label('currency', __('global_lang.currency') . ':*', ['class' => 'col-sm-2 col-form-label col-form-label-sm']) !!}
                            <div class="col-sm-10">
                                {!! Form::select('currency_id', $currencies, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('global_lang.please_select')]) !!}
                            </div>
                        </div>
                        <hr>
                        <h4 class="sub-title">@lang('student.student_admission_no_auto_generation')</h4>

                        <div class="row">

                            <div class="col-sm-12 col-xl-6 mb-30">
                                {!! Form::label('phone', __('student.admission_no') . ':*') !!}
                                <div class="form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="admission_no">
                                            <i class="helper"></i>@lang('global_lang.disabled')
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="admission_no">
                                            <i class="helper"></i>@lang('global_lang.enabled')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6 mb-30">
                                <div class="form-group">
                                    {!! Form::label('phone', __('student.admission_no_prefix') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('student_admission_no_prefix')]) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-12 col-xl-6 mb-30">

                                <div class="form-group">
                                    {!! Form::label('phone', __('student.admission_no_digit') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('student.admission_no_digit')]) !!}
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6 mb-30">
                                <div class="form-group">
                                    {!! Form::label('phone', __('student.admission_start_from') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('student.admission_start_from')]) !!}
                                </div>
                            </div>

                        </div>
                        <h4 class="sub-title">@lang('student.staff_id_auto_generation')</h4>

                        <div class="row">

                            <div class="col-sm-12 col-xl-6 mb-30">
                                {!! Form::label('phone', __('student.auto_staff_id') . ':*') !!}
                                <div class="form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="auto_staff_id">
                                            <i class="helper"></i>@lang('global_lang.disabled')
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" name="auto_staff_id">
                                            <i class="helper"></i>@lang('global_lang.enabled')
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6 mb-30">
                                <div class="form-group">
                                    {!! Form::label('phone', __('student.staff_no_prefix') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('student_staff_no_prefix')]) !!}
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-12 col-xl-6 mb-30">

                                <div class="form-group">
                                    {!! Form::label('phone', __('student.auto_staff_id') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('student.auto_staff_id')]) !!}
                                </div>
                            </div>
                            <div class="col-sm-12 col-xl-6 mb-30">
                                <div class="form-group">
                                    {!! Form::label('phone', __('student.staff_id_start_from') . ':*') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __('student.staff_id_start_from')]) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        @endsection
