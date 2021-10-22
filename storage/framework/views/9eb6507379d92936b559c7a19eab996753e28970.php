<?php $__env->startSection("wrapper"); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('award.manage_your_awards'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('award.awards'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"><?php echo app('translator')->get('award.awards_list'); ?>
                    <small class="text-info font-13">(An academic award is the time period during which a
                        school perform academic activities. You may register award here. Later campus admin
                        can use award to manage academic activities.)</small>
                </h5>


                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="<?php echo e(action('AwardController@create'), false); ?>" data-container=".award_modal">
                            <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('award.add_new_award'); ?></button></div>

                </div>


                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="awards_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th><?php echo app('translator')->get('award.award_title'); ?></th>
                                <th><?php echo app('translator')->get('award.description'); ?></th>
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
<div class="modal fade award_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            //designations table
            var awards_table = $("#awards_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/awards",
                columns: [{
                    data: "title",
                    name: "title"
                },
                {
                    data: "description",
                    name: "description"
                },
                {
                    data: "action",
                    name: "action"
                },
                ],
            });

            $(document).on("submit", "form#award_add_form", function(e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();

                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    beforeSend: function(xhr) {
                        __disable_submit_button(form.find('button[type="submit"]'));
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $("div.award_modal").modal("hide");
                            toastr.success(result.msg);
                            awards_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });


            $(document).on("click", "button.edit_award_button", function() {
                $("div.award_modal").load($(this).data("href"), function() {
                    $(this).modal("show");

                    $("form#award_edit_form").submit(function(e) {
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
                                    $("div.award_modal").modal("hide");
                                    toastr.success(result.msg);
                                    awards_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    });
                });
            });

            $(document).on("click", "button.delete_award_button", function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_award,
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
                                    awards_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\award/index.blade.php ENDPATH**/ ?>