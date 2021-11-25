 
 <?php $__env->startSection('wrapper'); ?>
     <div class="page-wrapper">
         <div class="page-content">
             <!--breadcrumb-->





             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.all_fee_transaction'); ?></h5>

                     <div class="d-lg-flex align-items-center mb-4 gap-3">
                         <div class="ms-auto"><a class="btn btn-primary radius-30 mt-2 mt-lg-0"
                                 href="<?php echo e(action('StudentController@create'), false); ?>">
                                 <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('lang.add_new_admission'); ?></a></div>
                     </div>


                     <hr>

                     <div class="table-responsive">
                         <table class="table mb-0" width="100%" id="fee_transaction_table">
                             <thead class="table-light" width="100%">
                                 <tr>
                                     
                                     <th><?php echo app('translator')->get('lang.action'); ?></th>
                                     <th><?php echo app('translator')->get('lang.fee_transaction_date'); ?></th>
                                     <th><?php echo app('translator')->get('lang.challan_no'); ?></th>
                                     <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                                    <th><?php echo app('translator')->get('lang.student_name'); ?></th>
                                     <th><?php echo app('translator')->get('lang.payment_status'); ?></th>
                                     <th><?php echo app('translator')->get('lang.final_total'); ?></th>
                                     <th><?php echo app('translator')->get('lang.total_paid'); ?></th>
                                     <th><?php echo app('translator')->get('lang.fee_due'); ?></th>
                                     <th><?php echo app('translator')->get('lang.session'); ?></th>
                                     <th><?php echo app('translator')->get('lang.father_name'); ?></th>
                                     <th><?php echo app('translator')->get('lang.status'); ?></th>
                                     <th><?php echo app('translator')->get('lang.roll_no'); ?></th>
                                     <th><?php echo app('translator')->get('lang.current_class'); ?></th>

                                 </tr>
                             </thead>

                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="modal fade payment_modal contains_select2" tabindex="-1" role="dialog"
         aria-labelledby="gridSystemModalLabel">
     </div>
     <div class="modal fade pay_fee_due_modal contains_select2" tabindex="-1" role="dialog"
         aria-labelledby="gridSystemModalLabel">
     </div>
     <div class="modal fade edit_payment_modal contains_select2" tabindex="-1" role="dialog"
         aria-labelledby="gridSystemModalLabel">
     </div>
 <?php $__env->stopSection(); ?>

 <?php $__env->startSection('javascript'); ?>

     <script type="text/javascript">
         $(document).ready(function() {
             $(document).on('click', '.delete_payment', function(e) {
                 swal({
                     title: LANG.sure,
                     text: LANG.confirm_delete_payment,
                     icon: 'warning',
                     buttons: true,
                     dangerMode: true,
                 }).then(willDelete => {
                     if (willDelete) {
                         $.ajax({
                             url: $(this).data('href'),
                             method: 'delete',
                             dataType: 'json',
                             success: function(result) {
                                 if (result.success === true) {
                                     $('div.payment_modal').modal('hide');
                                     $('div.edit_payment_modal').modal('hide');
                                     toastr.success(result.msg);
                                     fee_transaction_table.ajax.reload();

                                 } else {
                                     toastr.error(result.msg);
                                 }
                             },
                         });
                     }
                 });
             });

             $(document).on('click', '.edit_payment', function(e) {
                 e.preventDefault();
                 var container = $('.edit_payment_modal');

                 $.ajax({
                     url: $(this).data('href'),
                     dataType: 'html',
                     success: function(result) {
                         container.html(result).modal('show');
                         __currency_convert_recursively(container);
                         $('#datetimepicker').datetimepicker({
                             format: moment_date_format + ' ' + moment_time_format,
                             ignoreReadonly: true,
                         });
                         $('div.payment_modal').modal('hide');

                         container.find('form#transaction_payment_add_form').validate();
                     },
                 });
             });
             $(document).on('click', '.add_payment_modal', function(e) {
                 e.preventDefault();
                 var container = $('.payment_modal');

                 $.ajax({
                     url: $(this).attr('href'),
                     dataType: 'json',
                     success: function(result) {
                         if (result.status == 'due') {
                             container.html(result.view).modal('show');
                             __currency_convert_recursively(container);
                             $('#datetimepicker').datetimepicker({
                                 format: moment_date_format + ' ' + moment_time_format,
                                 ignoreReadonly: true,
                             });
                             container.find('form#transaction_payment_add_form').validate();
                             $('.payment_modal')
                                 .find('input[type="checkbox"].input-icheck')
                                 .each(function() {
                                     $(this).iCheck({
                                         checkboxClass: 'icheckbox_square-blue',
                                         radioClass: 'iradio_square-blue',
                                     });
                                 });
                         } else {
                             toastr.error(result.msg);
                         }
                     },
                 });
             });
             //fee_transaction_table
             var fee_transaction_table = $("#fee_transaction_table").DataTable({
                 processing: true,
                 serverSide: true,
                 "ajax": {
                     "url": "/fee-allocation",

                 }

                 ,
                 columns: [{
                         data: "action",
                         name: "action",
                         orderable: false,
                         "searchable": false
                     }

                     , {
                         data: "transaction_date",
                         name: "transaction_date"
                     }, {
                         data: "voucher_no",
                         name: "voucher_no"
                     }, {
                         data: "campus_name",
                         name: "campus_name",
                         orderable: false,
                         "searchable": false
                     },
                     {
                         data: "student_name",
                         name: "student_name",
                       
                     }, {
                         data: "payment_status",
                         name: "payment_status",
                         orderable: false,
                         "searchable": false
                     }, {
                         data: "final_total",
                         name: "final_total",
                         orderable: false,
                         "searchable": false
                     }, {
                         data: "total_paid",
                         name: "total_paid",
                         orderable: false,
                         "searchable": false
                     }, {
                         data: "total_remaining",
                         name: "total_remaining",
                         orderable: false,
                         "searchable": false
                     }, {
                         data: "session_info",
                         name: "session_info",
                         orderable: false,
                         "searchable": false
                     },  {
                         data: "father_name",
                         name: "father_name",
                      
                     }, {
                         data: "status",
                         name: "status",
                         orderable: false,
                         "searchable": false
                     }, {
                         data: "roll_no",
                         name: "roll_no",
                       
                     }, {
                         data: "current_class",
                         name: "current_class",
                         orderable: false,
                         "searchable": false
                     }


                     ,
                 ],
             });

         });
     </script>
 <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/fee_allocation/index.blade.php ENDPATH**/ ?>