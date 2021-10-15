<div class="card">
    <div class="card-body">
        <h5 class="card-title text-primary">Prefix Settings
            <small class="text-info font-13">(You can update here the organizational settings. These settings will effect
                all the campuses of this organization.
                .)</small>
        </h5>
        <hr>
        <div class="row">
            <div class="col-md-4 p-3">
            @php
                    $student = '';
                    if(!empty($general_settings->ref_no_prefixes['student'])){
                        $student = $general_settings->ref_no_prefixes['student'];
                    }
                @endphp
                {!! Form::label('ref_no_prefixes[student]', __('lang_v1.student') . ':') !!}
                {!! Form::text('ref_no_prefixes[student]', $student, ['class' => 'form-control']); !!}
              

            </div>
            <div class="col-md-4 p-3">
            @php
                    $employee = '';
                    if(!empty($general_settings->ref_no_prefixes['employee'])){
                        $employee = $general_settings->ref_no_prefixes['employee'];
                    }
                @endphp
                {!! Form::label('ref_no_prefixes[employee]', __('lang_v1.employee') . ':') !!}
                {!! Form::text('ref_no_prefixes[employee]', $employee, ['class' => 'form-control']); !!}
              

            </div>
            <div class="col-md-4 p-3">
            @php
                    $fee_payment = '';
                    if(!empty($general_settings->ref_no_prefixes['fee_payment'])){
                        $fee_payment = $general_settings->ref_no_prefixes['fee_payment'];
                    }
                @endphp
                {!! Form::label('ref_no_prefixes[fee_payment]', __('lang_v1.fee_payment') . ':') !!}
                {!! Form::text('ref_no_prefixes[fee_payment]', $fee_payment, ['class' => 'form-control']); !!}
              

            </div>
            <div class="col-md-4 p-3">
            @php
                    $expenses_payment = '';
                    if(!empty($general_settings->ref_no_prefixes['expenses_payment'])){
                        $expenses_payment = $general_settings->ref_no_prefixes['expenses_payment'];
                    }
                @endphp
                {!! Form::label('ref_no_prefixes[expenses_payment]', __('lang_v1.expenses_payment') . ':') !!}
                {!! Form::text('ref_no_prefixes[expenses_payment]', $fee_payment, ['class' => 'form-control']); !!}
              

            </div>
            <div class="col-md-4 p-3">
            @php
                    $addmission = '';
                    if(!empty($general_settings->ref_no_prefixes['addmission'])){
                        $addmission = $general_settings->ref_no_prefixes['addmission'];
                    }
                @endphp
                {!! Form::label('ref_no_prefixes[addmission]', __('lang_v1.addmission') . ':') !!}
                {!! Form::text('ref_no_prefixes[addmission]', $addmission, ['class' => 'form-control']); !!}
              

            </div>
        </div>
    </div>
</div>
