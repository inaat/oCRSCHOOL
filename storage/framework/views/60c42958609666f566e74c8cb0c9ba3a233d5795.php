
<?php $__env->startSection('wrapper'); ?>
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('lang.timetables'); ?></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.classes_timetable'); ?><br>
                    </small>
                </h5>


                <div class="d-lg-flex align-items-center mb-4 gap-3">

                    <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="<?php echo e(action('Curriculum\ClassTimeTableController@create'), false); ?>" data-container=".time_table_modal">
                            <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('lang.assign_period'); ?></button></div>

                </div>


                <hr>
                <?php echo Form::open(['url' => action('Curriculum\ClassTimeTableController@index'), 'method' => 'GET' ,'id'=>'time-table-form']); ?>

                <div class="row align-items-center">
                    <div class="col-sm-3">
                        <?php echo Form::label('campus.student', __('campus.campuses') . ':*'); ?>

                        <?php echo Form::select('campus_id', $campuses, $campus_id,['class' => 'form-select select2 global-campuses','style' => 'width:100%', 'required', 'placeholder' => __('messages.please_select')]); ?>

                    </div>
                    <div class="col-sm-3">
                        <?php echo Form::label('class.classes', __('class.classes') . ':'); ?>

                        <?php echo Form::select('class_id',$classes,$class_id, ['class' => 'form-select select2 global-classes ','style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                    </div>
                    <div class="col-sm-3">
                        <?php echo Form::label('class_section.sections', __('class_section.sections') . ':'); ?>

                        <?php echo Form::select('class_section_id', $class_sections, $class_section_id, ['class' => 'form-select select2 global-class_sections', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

                    </div>
                    <div class="col-sm-3 mt-3">
                        <button type="submit" class="btn  btn-primary"><?php echo app('translator')->get( 'lang.filter' ); ?></button>
                        <?php echo Form::hidden('print', null,[ 'id' => 'print', ]); ?>

                        <button class="btn  btn-primary print"><?php echo app('translator')->get( 'lang.print' ); ?></button>
                    </div>
                </div>
                <?php echo Form::close(); ?>


                <hr>
                <div class="table-responsive">
                    <table class="table mb-0" width="100%" id="class_time_table">
                        <thead class="table-light" width="100%">

                            <tr>
                                <th>#</th>
                                <th>Clsases</th>
                                <?php
                                foreach ($class_time_table_title as $t) {
                                echo '<th>'.$t.'</th>';
                                }
                                ?>

                            <tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td> <?php echo e($loop->iteration, false); ?>

                                </td>
                                <td><?php echo e($section->classes->title, false); ?> <?php echo e($section->section_name, false); ?></td>
                                <?php $__currentLoopData = $section->time_table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time_table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($time_table->subjects)): ?>
                                <td> <a data-href="<?php echo e(action('Curriculum\ClassTimeTableController@edit', [$time_table->id]), false); ?>" class="edit_time_table"><?php echo e($time_table->subjects->name, false); ?><br><?php if(!empty($time_table->subjects->employees)): ?> <strong>(<?php echo e(ucwords($time_table->subjects->employees->first_name . ' ' . $time_table->subjects->employees->last_name), false); ?>)<?php endif; ?></strong></a></td>
                                <?php else: ?>

                                <td style="text-align:center;   vertical-align: middle;
 writing-mode: vertical-lr;"><a data-href="<?php echo e(action('Curriculum\ClassTimeTableController@edit', [$time_table->id]), false); ?>" class="edit_time_table"><?php echo app('translator')->get('lang.'.$time_table->periods->type); ?></a></td>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</div>
<div class="modal fade time_table_modal contains_select2" id="time_table_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    $(document).ready(function() {


        $(document).on("submit", "form#add_time_table_form", function(e) {
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
                        $("div.time_table_modal").modal("hide");
                        toastr.success(result.msg);
                    } else {
                        toastr.error(result.msg);
                    }
                }
            , });
        });
         
 $("form#time-table-form").validate({
        rules: {
            campus_id: {
                required: true,
            },
        },
    });
        $(document).on("click", "button.print", function() {

            $('#print').val('print');
            $('#time-table-form').submit();
        });
           $(document).on("click", "a.edit_time_table", function() {
                $("div.time_table_modal").load($(this).data("href"), function() {
                    $(this).modal("show");

                    $("form#edit_time_table_form").submit(function(e) {
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
                                    $("div.time_table_modal").modal("hide");
                                    toastr.success(result.msg);
                                    window.location.reload(true);
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

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\class_time_table/index.blade.php ENDPATH**/ ?>