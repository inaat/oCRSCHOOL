

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

    <?php echo Form::open(['url' => action('AccountController@update',$account->id), 'method' => 'PUT', 'id' => 'edit_payment_account_form' ]); ?>


        <div class="modal-header bg-primary">
            <h4 class="modal-title"><?php echo app('translator')->get( 'account.edit_account' ); ?></h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <div class="modal-body">
            <div class="form-group">
                <?php echo Form::label('name', __( 'lang_v1.name' ) .":*"); ?>

                <?php echo Form::text('name', $account->name, ['class' => 'form-control', 'required','placeholder' => __( 'lang_v1.name' ) ]); ?>

            </div>

             <div class="form-group">
                <?php echo Form::label('account_number', __( 'account.account_number' ) .":*"); ?>

                <?php echo Form::text('account_number', $account->account_number, ['class' => 'form-control', 'required','placeholder' => __( 'account.account_number' ) ]); ?>

            </div>

            <div class="form-group">
                <?php echo Form::label('account_type_id', __( 'account.account_type' ) .":"); ?>

                <select name="account_type_id" class="form-control select2">
                    <option><?php echo app('translator')->get('messages.please_select'); ?></option>
                    <?php $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <optgroup label="<?php echo e($account_type->name, false); ?>">
                            <option value="<?php echo e($account_type->id, false); ?>" <?php if($account->account_type_id == $account_type->id): ?> selected <?php endif; ?> ><?php echo e($account_type->name, false); ?></option>
                            <?php $__currentLoopData = $account_type->sub_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sub_type->id, false); ?>" <?php if($account->account_type_id == $sub_type->id): ?> selected <?php endif; ?> ><?php echo e($sub_type->name, false); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </optgroup>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <?php echo Form::label('note', __( 'brand.note' )); ?>

                <?php echo Form::textarea('note', $account->note, ['class' => 'form-control', 'placeholder' => __( 'brand.note' ), 'rows' => 4]); ?>

            </div>
    </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.update' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog --><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/account/edit.blade.php ENDPATH**/ ?>