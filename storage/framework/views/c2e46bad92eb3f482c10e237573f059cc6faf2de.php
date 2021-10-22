<?php $__env->startSection("wrapper"); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('categories.manage_your_categories'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('categories.categories'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"><?php echo app('translator')->get('categories.categories_list'); ?>
                    
                </h5>


                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="<?php echo e(action('CategoryController@create'), false); ?>" data-container=".categories_modal">
                            <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('categories.add_new_categories'); ?></button></div>

                </div>


                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="categories_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th><?php echo app('translator')->get('categories.cat_name'); ?></th>
                                <th><?php echo app('translator')->get('categories.description'); ?></th>
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
<div class="modal fade categories_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            //designations table
            var categories_table = $("#categories_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "/categories",
                columns: [{
                    data: "cat_name",
                    name: "cat_name"
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

            $(document).on("submit", "form#category_add_form", function(e) {
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
                            $("div.categories_modal").modal("hide");
                            toastr.success(result.msg);
                            categories_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                });
            });


            $(document).on("click", "button.edit_category_button", function() {
                $("div.categories_modal").load($(this).data("href"), function() {
                    $(this).modal("show");

                    $("form#category_edit_form").submit(function(e) {
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
                                    $("div.categories_modal").modal("hide");
                                    toastr.success(result.msg);
                                    categories_table.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                        });
                    });
                });
            });

            $(document).on("click", "button.delete_category_button", function() {
                swal({
                    title: LANG.sure,
                    text: LANG.confirm_delete_categories,
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
                                    categories_table.ajax.reload();
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

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\categories/index.blade.php ENDPATH**/ ?>