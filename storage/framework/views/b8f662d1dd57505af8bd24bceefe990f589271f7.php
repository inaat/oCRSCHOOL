<?php $__env->startSection('wrapper'); ?>
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('hrm.all_your_shifts'); ?></div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('hrm.shift'); ?></li>
                        </ol>
                    </nav>
                </div>
                
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary"><?php echo app('translator')->get('hrm.shift_list'); ?>
                        <small class="text-info font-13"></small>
                    </h5>


                    <div class="d-lg-flex align-items-center mb-4 gap-3">

                        <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="<?php echo e(action('HRM\HrmShiftController@create'), false); ?>" data-container=".shift_modal">
                                <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('hrm.add_new_shift'); ?></button></div>

                    </div>


                    <hr>

                    <div class="table-responsive">
                        <table class="table mb-0" width="100%" id="shift_table">
                            <thead class="table-light" width="100%">
                                <tr>
                                    <th><?php echo app('translator')->get( 'hrm.name' ); ?></th>
                                    <th><?php echo app('translator')->get( 'hrm.shift_type' ); ?></th>
                                    <th><?php echo app('translator')->get( 'hrm.start_time' ); ?></th>
                                    <th><?php echo app('translator')->get( 'hrm.end_time' ); ?></th>
                                    <th><?php echo app('translator')->get( 'hrm.holiday' ); ?></th>
                                    <th><?php echo app('translator')->get( 'hrm.action' ); ?></th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <div class="modal fade shift_modal contains_select2" id="shift_modal" tabindex="-1" role="dialog"
        aria-labelledby="gridSystemModalLabel"></div>
    <div class="modal fade contains_select2 edit_shift_modal" id="edit_shift_modal" tabindex="-1" role="dialog"
        aria-labelledby="gridSystemModalLabel"></div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>
    <script type="text/javascript">
        $(document).ready(function() {

            //shift table
            var shift_table = $("#shift_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/hrm-shift",
                columnDefs: [{
                    targets: 4,
                    orderable: false,
                    searchable: false,
                }, ],
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'holidays',
                        name: 'holidays'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
            });
            $('#shift_modal,#edit_shift_modal').on('shown.bs.modal', function(e) {
                var $p = $(this);
                $('#shift_modal .select2').select2({
                    dropdownParent: $p
                });
                $('#start_timepicker,#end_timepicker').datetimepicker({
                    format: moment_time_format,
                    ignoreReadonly: true,
                });
                $('#shift_modal .select2, #edit_shift_modal .select2').select2();

                if ($('select#shift_type').val() == 'fixed_shift') {
                    $('div.time_div').show();
                } else if ($('select#shift_type').val() == 'flexible_shift') {
                    $('div.time_div').hide();
                }

                $('select#shift_type').change(function() {
                    var shift_type = $(this).val();
                    if (shift_type == 'fixed_shift') {
                        $('div.time_div').fadeIn();
                    } else if (shift_type == 'flexible_shift') {
                        $('div.time_div').fadeOut();
                    }
                });
            });

            $(document).on("submit", "form#add_shift_form", function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();
                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function(xhr) {
                        __enable_submit_button(form.find('button[type="submit"]'));
                    },
                    success: function(result) {
                        if (result.success == true) {
                            if ($('div#edit_shift_modal').hasClass('edit_shift_modal')) {
                                $('div#edit_shift_modal').modal("hide");
                            } else if ($('div#shift_modal').hasClass('shift_modal')) {
                                $('div#shift_modal').modal('hide');
                            }
                            toastr.success(result.msg);
                            shift_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }

                    },
                });
            });


            ////
            $(document).on("click", "button.edit_leave_category_button", function() {
                $("div.shift_modal").load($(this).data("href"), function() {
                    $(this).modal("show");

                    $("form#leave_category_edit_form").submit(function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var data = form.serialize();

                        $.ajax({
                            method: "POST",
                            url: $(this).attr("action"),
                            dataType: "json",
                            data: data,
                            beforeSend: function(xhr) {
                                __disable_submit_button(
                                    form.find('button[type="submit"]')
                                );
                            },
                            success: function(result) {
                                if (result.success == true) {
                                    $("div.shift_modal").modal(
                                        "hide");
                                    toastr.success(result.msg);
                                    shift_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    });
                });
            });

            $(document).on("click", "button.delete_leave_category_button", function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_leave_category,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var href = $(this).data("href");
                        var data = $(this).serialize();

                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            data: data,
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    shift_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    }
                });
            });

            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\shift/index.blade.php ENDPATH**/ ?>