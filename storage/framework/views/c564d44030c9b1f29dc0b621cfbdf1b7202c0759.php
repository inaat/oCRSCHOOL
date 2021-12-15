 <div class="card">
     <div class="card-body">
         <h5 class="card-title text-primary"><?php echo app('translator')->get('lang.planning_&_progress'); ?></h5>
         <p class="text-info">You may create a plan to complete the subject content for the current session. Later, you can track the subject progress. It is very helpful for teachers, students and parents to follow the plan.
         </p>
         <?php echo Form::open(['url' => action('Curriculum\ClassSubjectProgressController@store'), 'method' => 'post', 'id' =>'progress_add_form' ]); ?>


         <div class="row align-items-center">
             <?php echo Form::hidden('subject_id', $class_subject->id,[ 'id' => 'subject_id', ]); ?>

             <?php echo Form::hidden('campus_id', $class_subject->campus_id,[ 'id' => 'campus_id', ]); ?>

             <div class="col-sm-3">
                 <?php echo Form::select('chapter', $chapters, null, ['class' => 'form-select select2 ', 'required', 'id' => 'chapter_progress', 'style' => 'width:100%', 'placeholder' => __('messages.all')]); ?>

             </div>
             <div class="col-sm-3">
                 <?php echo Form::select('lesson_id', [], null, ['class' => 'form-select select2', 'required', 'id' => 'lessons_ids','style' => 'width:100%', 'placeholder' => __('messages.please_select')]); ?>

             </div>

             <div class="col-sm-3 ">
                 <div class="input-group flex-nowrap"> <span class="input-group-text" id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                     <?php echo Form::text('start_date',null, ['class' => 'form-control date-picker', 'placeholder' => __('settings.start_date'), 'readonly']); ?>


                 </div>
                 </div>
                 <div class="col-sm-3">
                     <button type="submit" class="btn  btn-primary"><?php echo app('translator')->get( 'lang.save' ); ?></button>
                 </div>
             </div>
    <?php echo Form::close(); ?>


             <div class="table-responsive mt-3">
             <hr>
                 <table class="table mb-0" width="100%" id="progress_table">

                     <thead class="table-light" width="100%">
                         <tr>
                             <th><?php echo app('translator')->get('lang.action'); ?></th>
                             <th><?php echo app('translator')->get('lang.lesson_title'); ?></th>
                             <th><?php echo app('translator')->get('lang.chapter_number'); ?></th>
                             <th><?php echo app('translator')->get('lang.status'); ?></th>
                         </tr>
                     </thead>
                 </table>
             </div>
         </div>
     </div>
     <div class="modal fade progress_modal select" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

    <?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum/progress/partials/progress.blade.php ENDPATH**/ ?>