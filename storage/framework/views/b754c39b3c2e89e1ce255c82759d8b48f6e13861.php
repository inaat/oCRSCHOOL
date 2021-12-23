 
 <?php $__env->startSection('wrapper'); ?>
     <div class="page-wrapper">
         <div class="page-content">
             <!--breadcrumb-->
             <div class="card">
                 <div class="card-body">
                     <div class="accordion" id="student-fillter">
                         <div class="accordion-item">
                             <h2 class="accordion-header" id="student-fillter">
                                 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                     data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                     <h5 class="card-title"><?php echo app('translator')->get('lang.students_flitters'); ?></h5>
                                 </button>
                             </h2>
                             <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="student-fillter"
                                 data-bs-parent="#student-fillter" style="">
                                 <div class="accordion-body">
                                     <div class="row">
                                         <div class="col-md-4 p-1">
                                             <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                                             <?php echo Form::select('campus_id', $campuses, null, ['class' => 'form-select select2 global-campuses', 'required', 'id'=>'students_list_filter_campus_id','style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]); ?>

                                         </div>
                                         <div class="col-md-4 p-1">
                                             <?php echo Form::label('class.classes', __('class.classes') . ':*'); ?>

                                             <?php echo Form::select('adm_class_id', [], null, ['class' => 'form-select select2 global-classes', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all'), 'id' => 'students_list_filter_class_id']); ?>

                                         </div>
                                         <div class="col-md-4 p-1">
                                             <?php echo Form::label('class_section.sections', __('class_section.sections') . ':*'); ?>

                                             <?php echo Form::select('adm_class_section_id', [], null, ['class' => 'form-select select2 global-class_sections', 'id' => 'students_list_filter_class_section_id', 'required', 'style' => 'width:100%', 'required', 'placeholder' => __('messages.all')]); ?>

                                         </div>
                                         <div class="clearfix"></div>
                                         <div class="col-md-3 p-1">
                                             <?php echo Form::label('admission_no', __('lang.admission_no'), ['classs' => 'form-lable']); ?>

                                             <?php echo Form::text('admission_no', null, ['class' => 'form-control', 'id'=>'students_list_filter_admission_no','placeholder' => __('lang.admission_no')]); ?>

                                         </div>
                                         <div class="col-md-3 p-1">
                                             <?php echo Form::label('roll_no', __('lang.roll_no')); ?>

                                             <?php echo Form::text('roll_no', null, ['class' => 'form-control', 'placeholder' => __('lang.roll_no'), 'id' => 'students_list_filter_roll_no']); ?>

                                         </div>
                                         <div class="col-md-3 p-1">
                                             <?php echo Form::label('lang.admission_date', __('lang.admission_date') . ':*'); ?>

                                             <div class="input-group flex-nowrap"> <span class="input-group-text"
                                                     id="addon-wrapping"><i class="fa fa-calendar"></i></span>
                                                 <?php echo Form::text('student_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'id' =>'student_list_filter_date_range','class' => 'form-control', 'readonly']); ?>


                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>





               <div class="card">
            <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.student_list'); ?></h5>

                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto"><a class="btn btn-primary radius-30 mt-2 mt-lg-0" href="<?php echo e(action('StudentController@create'), false); ?>">
                            <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('lang.add_new_admission'); ?></a></div>
                </div>


                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="students_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                
                                <th><?php echo app('translator')->get('lang.action'); ?></th>
                                <th><?php echo app('translator')->get('lang.student_name'); ?></th>
                                <th><?php echo app('translator')->get('lang.father_name'); ?></th>
                                <th><?php echo app('translator')->get('lang.status'); ?></th>
                                <th><?php echo app('translator')->get('lang.roll_no'); ?></th>
                                <th><?php echo app('translator')->get('lang.admission_no'); ?></th>
                                <th><?php echo app('translator')->get('lang.admission_date'); ?></th>
                                <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                                <th><?php echo app('translator')->get('lang.admission_class'); ?></th>
                                <th><?php echo app('translator')->get('lang.current_class'); ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
         </div>
     </div>
     <div class="modal fade admission_fee_modal contains_select2" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>
     <div class="modal fade pay_fee_due_modal contains_select2" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>
<?php echo $__env->make('students.partials.update_student_status_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 <?php $__env->stopSection(); ?>

 <?php $__env->startSection('javascript'); ?>

     <script type="text/javascript">
  $(document).ready(function() {
      
                //students_table
        var students_table = $("#students_table").DataTable({
            processing: true
            , serverSide: true,
               "ajax": {
            "url": "/students",
            "data": function ( d ) {
                 if($('#student_list_filter_date_range').val()) {
                    var start = $('#student_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#student_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    d.start_date = start;
                    d.end_date = end;
                }
                
                if($('#students_list_filter_campus_id').length) {
                    d.campus_id = $('#students_list_filter_campus_id').val();
                }
                if($('#students_list_filter_class_id').length) {
                    d.class_id = $('#students_list_filter_class_id').val();
                }
                if($('#students_list_filter_class_section_id').length) {
                    d.class_section_id = $('#students_list_filter_class_section_id').val();
                }
                if($('#students_list_filter_admission_no').length) {
                    d.admission_no = $('#students_list_filter_admission_no').val();
                }
                if($('#students_list_filter_roll_no').length) {
                    d.roll_no = $('#students_list_filter_roll_no').val();
                }
                d = __datatable_ajax_callback(d);
            }
        }

            , columns: [{
                    data: "action"
                    , name: "action",
                         orderable: false,
                         "searchable": false
                }
               
                , {
                    data: "student_name"
                    , name: "student_name"
                }
                , {
                    data: "father_name"
                    , name: "father_name"
                }
                 , {
                    data: "status"
                    , name: "status",
                         orderable: false,
                         "searchable": false
                }
                , {
                    data: "roll_no"
                    , name: "roll_no"
                }
                , {
                    data: "admission_no"
                    , name: "admission_no"
                }
                , {
                    data: "admission_date"
                    , name: "admission_date"
                }
                 , {
                    data: "campus_name"
                    , name: "campus_name",
                         orderable: false,
                         "searchable": false
                }
                , {
                    data: "adm_class"
                    , name: "adm_class",
                         orderable: false,
                         "searchable": false
                }
                , {
                    data: "current_class"
                    , name: "current_class",
                         orderable: false,
                         "searchable": false
                }
               
            , ]
        , });
      //If change in amount amount update amount including tax and line total
            

             $(document).on('click', '.update_status', function(e) {
            e.preventDefault();
            $('#update_student_status_form').find('#status').val($(this).data('status'));
            $('#update_student_status_form').find('#student_id').val($(this).data('student_id'));
            $('#update_student_status_modal').modal('show');
            });

            
        $(document).on('submit', '#update_student_status_form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                },
                success: function(result) {
                    if (result.success == true) {
                        $('#update_student_status_modal').modal('hide');
                        toastr.success(result.msg);
                        students_table.ajax.reload();
                        $('#update_student_status_form')
                            .find('button[type="submit"]')
                            .attr('disabled', false);
                    } else {
                        toastr.error(result.msg);
                    }
                },
            });
        });

         $('.admission_fee_modal > table#admisssion-table tbody').on('keyup', 'input.amount',  function() {
             alert(5);
        });
            $(document).on('change', 'input.amount,input.fee-head-check', function(){
        var total = 0;
        var table = $(this).closest('table');
        table.find('tbody tr').each( function(){
            if($(this).find('input.fee-head-check').is(':checked')){
            var line = __read_number($(this).find('input.amount'));
            var subtotal = line;
            total = total + subtotal;
            }
        });
         table.find('span.final_total').text(__currency_trans_from_en(total, true));
        $('input#final_total').val(total);
        
        });
        //Date range as a button
        $('#student_list_filter_date_range').daterangepicker(
           dateRangeSettingsForAdmissionDate,
            function (start, end) {
                $('#student_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                students_table.ajax.reload();
            }
        );
        $('#student_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#student_list_filter_date_range').val('');
            students_table.ajax.reload();
        });
        $(document).on('change', '#students_list_filter_campus_id,#students_list_filter_class_id,#students_list_filter_class_section_id',  function() {
            students_table.ajax.reload();
        });
        $(document).on('keyup', '#students_list_filter_admission_no,#students_list_filter_roll_no',  function() {
            students_table.ajax.reload();
        });
 

 $(document).on("click", ".admission_add_button", function () {
        $("div.admission_fee_modal").load($(this).data("href"), function () {
            $(this).modal("show");
             
            $("form#admission_fee_add_form").submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                var boxes = $('.fee-head-check');
                    if (boxes.length > 0) {
                        if ($('.fee-head-check:checked').length < 1) {
                            toastr.error(LANG.fee_heads);
                            boxes[0].focus();
                                return false;
                            }
                    }
                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function (xhr) {
                        __disable_submit_button(
                            form.find('button[type="submit"]')
                        );
                    },
                    success: function (result) {
                        if (result.success == true) {
                            $("div.admission_fee_modal").modal("d-none");
                            toastr.success(result.msg);
                           students_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });
        });
    });
        



    });

     </script>
 <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/students/index.blade.php ENDPATH**/ ?>