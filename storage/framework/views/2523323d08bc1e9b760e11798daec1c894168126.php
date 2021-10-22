
<?php $__env->startSection("wrapper"); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('campus.manage_your_campuses'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('campus.campuses'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo app('translator')->get('campus.campuses_list'); ?></h5>

                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="ms-auto"><a class="btn btn-primary radius-30 mt-2 mt-lg-0" href="<?php echo e(action('CampusController@create'), false); ?>">
                            <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('campus.add_new_campus'); ?></a></div>
                </div>


                <hr>

                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="campuses_table">
                        <thead class="table-light" width="100%">
                            <tr>
                                <th><?php echo app('translator')->get('global_lang.action'); ?></th>
                                <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                                <th><?php echo app('translator')->get('campus.registration_date'); ?></th>
                                <th><?php echo app('translator')->get('campus.registration_code'); ?></th>
                                <th><?php echo app('translator')->get('lang_v1.mobile'); ?></th>
                                <th><?php echo app('translator')->get('lang_v1.phone'); ?></th>
                                <th><?php echo app('translator')->get('lang_v1.address'); ?></th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function() {

        //campuses_table
        var campuses_table = $("#campuses_table").DataTable({
            processing: true
            , serverSide: true
            , ajax: "/campuses"
            , columns: [{
                    data: "action"
                    , name: "action"
                }
                , {
                    data: "campus_name"
                    , name: "campus_name"
                }
                , {
                    data: "registration_date"
                    , name: "registration_date"
                }
                , {
                    data: "registration_code"
                    , name: "registration_code"
                }
                , {
                    data: "mobile"
                    , name: "mobile"
                }
                , {
                    data: "phone"
                    , name: "phone"
                }
                , {
                    data: "address"
                    , name: "address"
                }
            , ]
        , });



    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\campuses/index.blade.php ENDPATH**/ ?>