<?php $__env->startSection("wrapper"); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('session.all_your_sessions'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('session.sessions'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"><?php echo app('translator')->get('session.session_list'); ?>
                    <small class="text-info font-13">(<?php echo app('translator')->get('session.an_academic_session_is_the_time_period_during_which_a_school_perform_academic_activities._You_may_register_sessions_here._Later_campus_admin_can_use_session_to_manage_academic_activities'); ?>)</small>
                </h5>


                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="<?php echo e(action('SessionController@create'), false); ?>" data-container=".sessions_modal">
                            <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('session.add_new_session'); ?></button></div>

                </div>


                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="sessions_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th><?php echo app('translator')->get('session.session_name'); ?></th>
                                <th><?php echo app('translator')->get('session.prefix'); ?></th>
                                <th><?php echo app('translator')->get('global_lang.status'); ?></th>
                                <th><?php echo app('translator')->get('session.start_date'); ?></th>
                                <th><?php echo app('translator')->get('session.end_date'); ?></th>
                                <th><?php echo app('translator')->get('global_lang.action'); ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<div class="modal fade sessions_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('.sessions_modal').on('keyup', '.mask', function() {
            $('.mask').inputmask('9999-9999');
        });
        //sessions table
        var sessions_table = $("#sessions_table").DataTable({
            processing: true
            , serverSide: true
            , ajax: "/session"
            , columns: [{
                    data: "title"
                    , name: "title"
                }
                , {
                    data: "prefix"
                    , name: "prefix"
                }
                , {
                    data: "status"
                    , name: "status"
                }
                , {
                    data: "start_date"
                    , name: "start_date"
                }
                , {
                    data: "end_date"
                    , name: "end_date"
                }
                , {
                    data: "action"
                    , name: "action"
                }
            , ]
        , });

        $(document).on("submit", "form#session_add_form", function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                method: "POST"
                , url: $(this).attr("action")
                , dataType: "json"
                , data: data
                , beforeSend: function(xhr) {
                    __disable_submit_button(form.find('button[type="submit"]'));
                }
                , success: function(result) {
                    if (result.success == true) {
                        $("div.sessions_modal").modal("hide");
                        toastr.success(result.msg);
                        sessions_table.ajax.reload();
                    } else {
                        toastr.error(result.msg);
                    }
                }
            , });
        });
        $(document).on('click', 'a.session_activate', function() {
            swal({
                title: LANG.sure
                , text: LANG.confirm_session_activate
                , icon: 'warning'
                , buttons: true
                , dangerMode: true
            , }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    $.ajax({
                        method: 'PUT'
                        , url: href
                        , dataType: 'json'
                        , data: data
                        , success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                sessions_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    , });
                }
            });
        });
        $(document).on("click", "button.edit_session_button", function() {
            $("div.sessions_modal").load($(this).data("href"), function() {
                $(this).modal("show");

                $("form#session_edit_form").submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var data = form.serialize();

                    $.ajax({
                        method: "POST"
                        , url: $(this).attr("action")
                        , dataType: "json"
                        , data: data
                        , beforeSend: function(xhr) {
                            __disable_submit_button(
                                form.find('button[type="submit"]')
                            );
                        }
                        , success: function(result) {
                            if (result.success == true) {
                                $("div.sessions_modal").modal("hide");
                                toastr.success(result.msg);
                                sessions_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    , });
                });
            });
        });

        $(document).on("click", "button.delete_session_button", function() {
            swal({
                title: LANG.sure
                , text: LANG.confirm_delete_session
                , icon: "warning"
                , buttons: true
                , dangerMode: true
            , }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data("href");
                    var data = $(this).serialize();

                    $.ajax({
                        method: "DELETE"
                        , url: href
                        , dataType: "json"
                        , data: data
                        , success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                sessions_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    , });
                }
            });
        });



     
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\session/index.blade.php ENDPATH**/ ?>