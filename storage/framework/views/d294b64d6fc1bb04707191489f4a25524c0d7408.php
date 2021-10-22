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
                                <th><?php echo app('translator')->get('global_lang.status'); ?></th>
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


<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/admin\global_configuration\session/index.blade.php ENDPATH**/ ?>