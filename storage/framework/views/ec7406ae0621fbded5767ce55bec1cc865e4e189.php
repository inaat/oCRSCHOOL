 <div class="dropdown">
     <?php if($status=='pending'): ?>
     <button class="btn badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo app('translator')->get('lang.planned_on'); ?><?php echo e(' '. $start_date .'  ', false); ?></button>
  <ul class="dropdown-menu" style="">
         <li><a class="dropdown-item  text-success class_subject_progress_status" data-href="<?php echo e(action('Curriculum\ClassSubjectProgressController@edit', [$id]), false); ?>?status=completed"><i class="bx bxs-circle me-1"></i><?php echo app('translator')->get('lang.mark_completed'); ?></a></li>
         <li><a class="dropdown-item  text-info class_subject_progress_status" data-href="<?php echo e(action('Curriculum\ClassSubjectProgressController@edit', [$id]), false); ?>?status=reading"><i class="bx bxs-circle me-1"></i><?php echo app('translator')->get('lang.mark_reading'); ?></a></li>

     </ul>
     <?php elseif($status=='reading'): ?>
     <button class="btn badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo app('translator')->get('lang.inprogress_reading'); ?></button>
      <ul class="dropdown-menu" style="">
         <li><a class="dropdown-item  text-success class_subject_progress_status" data-href="<?php echo e(action('Curriculum\ClassSubjectProgressController@edit', [$id]), false); ?>?status=completed"><i class="bx bxs-circle me-1"></i><?php echo app('translator')->get('lang.mark_completed'); ?></a></li>
         <li><a class="dropdown-item  text-danger class_subject_progress_status" data-href="<?php echo e(action('Curriculum\ClassSubjectProgressController@edit', [$id]), false); ?>?status=pending"><i class="bx bxs-circle me-1"></i><?php echo app('translator')->get('lang.mark_pending'); ?></a></li>

     </ul>
     <?php else: ?>
     <button class="btn badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo app('translator')->get('lang.completed_on'); ?><?php echo e(' '. $complete_date .'  ', false); ?></button>
     <ul class="dropdown-menu" style="">
                 <li><a class="dropdown-item  text-info class_subject_progress_status" data-href="<?php echo e(action('Curriculum\ClassSubjectProgressController@edit', [$id]), false); ?>?status=reading"><i class="bx bxs-circle me-1"></i><?php echo app('translator')->get('lang.mark_reading'); ?></a></li>

         <li><a class="dropdown-item  text-danger class_subject_progress_status" data-href="<?php echo e(action('Curriculum\ClassSubjectProgressController@edit', [$id]), false); ?>?status=pending"><i class="bx bxs-circle me-1"></i><?php echo app('translator')->get('lang.mark_pending'); ?></a></li>

     </ul>
 </div>

 <?php endif; ?>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\progress/session_status.blade.php ENDPATH**/ ?>