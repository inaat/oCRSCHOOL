<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

        <?php echo Form::open(['url' => action('\App\Http\Controllers\StudentController@postAdmissionFee'), 'method' => 'post', 'id' => 'admission_fee_add_form']); ?>


        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('lang.create_admission_voucher'); ?>
                (<?php echo e(ucwords($student->first_name . ' ' . $student->last_name), false); ?>)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="<?php echo e(!empty($student->student_image) ? url('uploads/student_image/', $student->student_image) : url('uploads/student_image/default.png'), false); ?>"
                    alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                <h5>(<?php echo e(ucwords($student->first_name . ' ' . $student->last_name), false); ?>)</h5>
            </div>
            <input type="hidden" name="student_id" value="<?php echo e($student->id, false); ?>"/>
            <input type="hidden" name="class_id" value="<?php echo e($student->current_class_id, false); ?>"/>
            <input type="hidden" name="class_section_id" value="<?php echo e($student->current_class_section_id, false); ?>"/>
            <input type="hidden" name="campus_id" value="<?php echo e($student->campus_id, false); ?>"/>
            <div class="col-sm-12">
                <strong><?php echo app('translator')->get('lang.admission_fee_details'); ?></strong>
                <div class="form-group">
                    <table class="table table-condensed table-striped " id="admisssion-table">
                        <thead>
                            <tr>
                                <th class="text-center"><?php echo app('translator')->get('lang.fee_heads'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('lang.enable'); ?></th>
                                <th class="text-center "><?php echo app('translator')->get('lang.amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                         
                          <?php $__currentLoopData = $fee_heads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fee_head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <tr>
                                <td class="text-center"><div class="mt-2"><?php echo e($fee_head->description, false); ?></div></td>
                                <td class="text-center">
                                        
                               
                                     <?php echo Form::checkbox('fee_heads[' . $loop->iteration  . '][is_enabled]', 1, null, ['class' => 'form-check-input mt-2 fee-head-check']); ?>                                 </td>

                        
                                </td>

                                <td class="text-center ">
                                    <input  name="fee_heads[<?php echo e($loop->iteration, false); ?>][amount]" type="number" value=<?php echo e(number_format($fee_head->amount, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?> class="form-control amount"
                                        value="0">
                                    <input type="hidden" name="fee_heads[<?php echo e($loop->iteration, false); ?>][fee_head_id]" value="<?php echo e($fee_head->id, false); ?>">

                                </td>
                            </tr> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <tfoot>
                      <tr>
                        <th colspan="2" class="text-center">Total</th>
                        <td><span class="final_total">0</span></td>
                        <input type="hidden" name="final_total" id="final_total" value="0">
                      </tr>
                    </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get( 'global_lang.save' ); ?></button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo app('translator')->get( 'global_lang.close' ); ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>


</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/students/partials/admission_fee.blade.php ENDPATH**/ ?>