
<?php $__env->startSection("wrapper"); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('class_section.manage_your_sections'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('class_section.sections'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo app('translator')->get('class_section.section_list'); ?></h5>

               <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto"><button type="button"
                                class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal"
                                data-href="<?php echo e(action('ClassSectionController@create'), false); ?>"
                                data-container=".class_section_modal">
                                <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('class_section.add_new_section'); ?></button></div>
                </div>



                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="class_section_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th><?php echo app('translator')->get('global_lang.action'); ?></th>
                                <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                                <th><?php echo app('translator')->get('class_section.class_name'); ?></th>
                                <th><?php echo app('translator')->get('class_section.section_name'); ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
 <div class="modal fade class_section_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function() {

        //class_section_table
        var class_section_table = $("#class_section_table").DataTable({
            processing: true
            , serverSide: true
            , ajax: "/sections"
            , columns: [{
                    data: "action"
                    , name: "action"
                }
                , {
                    data: "campus_name"
                    , name: "campus_name"
                }
                , {
                    data: "class_name"
                    , name: "class_name"
                }
                 , {
                    data: "section_name"
                    , name: "section_name"
                }
            , ]
        , });

   $(document).on("submit", "form#class_section_add_form", function (e) {
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
                    $("div.class_section_modal").modal("hide");
                    toastr.success(result.msg);
                   class_section_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
 $(document).on("click", ".edit_class_section_button", function () {
        $("div.class_section_modal").load($(this).data("href"), function () {
            $(this).modal("show");

            $("form#class_section_edit_form").submit(function (e) {
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
                            $("div.class_section_modal").modal("hide");
                            toastr.success(result.msg);
                           class_section_table.ajax.reload();
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

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\class_section/index.blade.php ENDPATH**/ ?>