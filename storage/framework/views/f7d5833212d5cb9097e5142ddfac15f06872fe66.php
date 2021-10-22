
<?php $__env->startSection("wrapper"); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('discount.manage_your_discounts'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('discount.discounts'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo app('translator')->get('discount.discounts_list'); ?></h5>

                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="<?php echo e(action('DiscountController@create'), false); ?>"
                                data-container=".discounts_modal">
                                <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('discount.add_new_discount'); ?></button></div>
                </div>


                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="discount_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th><?php echo app('translator')->get('global_lang.action'); ?></th>
                                <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                                <th><?php echo app('translator')->get('discount.discount_name'); ?></th>
                                <th><?php echo app('translator')->get('discount.discount_type'); ?></th>
                                <th><?php echo app('translator')->get('discount.discount_amount'); ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
 <div class="modal fade discounts_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function() {

        //discount_table
        var discount_table = $("#discount_table").DataTable({
            processing: true
            , serverSide: true
            , ajax: "/discounts"
            , columns: [{
                    data: "action"
                    , name: "action"
                }
                , {
                    data: "campus_name"
                    , name: "campus_name"
                }
                , {
                    data: "discount_name"
                    , name: "discount_name"
                }
                , {
                    data: "discount_type"
                    , name: "discount_type"
                }
                , {
                    data: "discount_amount"
                    , name: "discount_amount"
                }
            ]
        , });


   $(document).on("submit", "form#discount_add_form", function (e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();

        $.ajax({
            method: "POST",
            url: $(this).attr("action"),
            dataType: "json",
            data: data,
            beforeSend: function (xhr) {
                __disable_submit_button(form.find('button[type="submit"]'));
            },
            success: function (result) {
                if (result.success == true) {
                    $("div.discounts_modal").modal("hide");
                    toastr.success(result.msg);
                    discount_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
        $(document).on("click", ".edit_discount_button", function () {
        $("div.discounts_modal").load($(this).data("href"), function () {
            $(this).modal("show");

            $("form#discount_edit_form").submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var data = form.serialize();

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
                            $("div.discounts_modal").modal("hide");
                            toastr.success(result.msg);
                           discount_table.ajax.reload();
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

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\discounts/index.blade.php ENDPATH**/ ?>