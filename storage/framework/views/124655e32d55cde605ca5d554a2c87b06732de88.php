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
            <?php
                    $student = '';
                    if(!empty($general_settings->ref_no_prefixes['student'])){
                        $student = $general_settings->ref_no_prefixes['student'];
                    }
                ?>
                <?php echo Form::label('ref_no_prefixes[student]', __('lang_v1.student') . ':'); ?>

                <?php echo Form::text('ref_no_prefixes[student]', $student, ['class' => 'form-control']); ?>

              

            </div>
            <div class="col-md-4 p-3">
            <?php
                    $employee = '';
                    if(!empty($general_settings->ref_no_prefixes['employee'])){
                        $employee = $general_settings->ref_no_prefixes['employee'];
                    }
                ?>
                <?php echo Form::label('ref_no_prefixes[employee]', __('lang_v1.employee') . ':'); ?>

                <?php echo Form::text('ref_no_prefixes[employee]', $employee, ['class' => 'form-control']); ?>

              

            </div>
            <div class="col-md-4 p-3">
            <?php
                    $fee_payment = '';
                    if(!empty($general_settings->ref_no_prefixes['fee_payment'])){
                        $fee_payment = $general_settings->ref_no_prefixes['fee_payment'];
                    }
                ?>
                <?php echo Form::label('ref_no_prefixes[fee_payment]', __('lang_v1.fee_payment') . ':'); ?>

                <?php echo Form::text('ref_no_prefixes[fee_payment]', $fee_payment, ['class' => 'form-control']); ?>

              

            </div>
            <div class="col-md-4 p-3">
            <?php
                    $expenses_payment = '';
                    if(!empty($general_settings->ref_no_prefixes['expenses_payment'])){
                        $expenses_payment = $general_settings->ref_no_prefixes['expenses_payment'];
                    }
                ?>
                <?php echo Form::label('ref_no_prefixes[expenses_payment]', __('lang_v1.expenses_payment') . ':'); ?>

                <?php echo Form::text('ref_no_prefixes[expenses_payment]', $fee_payment, ['class' => 'form-control']); ?>

              

            </div>
            <div class="col-md-4 p-3">
            <?php
                    $admission = '';
                    if(!empty($general_settings->ref_no_prefixes['admission'])){
                        $admission = $general_settings->ref_no_prefixes['admission'];
                    }
                ?>
                <?php echo Form::label('ref_no_prefixes[admission]', __('lang_v1.admission') . ':'); ?>

                <?php echo Form::text('ref_no_prefixes[admission]', $admission, ['class' => 'form-control']); ?>

              

            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin/global_configuration/partials/prefixes.blade.php ENDPATH**/ ?>