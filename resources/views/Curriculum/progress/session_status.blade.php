 <div class="dropdown">
     @if ($status=='pending')
     <button class="btn badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">@lang('lang.planned_on'){{' '. $start_date .'  ' }}</button>
  <ul class="dropdown-menu" style="">
         <li><a class="dropdown-item  text-success class_subject_progress_status" data-href="{{action('Curriculum\ClassSubjectProgressController@edit', [$id])}}?status=completed"><i class="bx bxs-circle me-1"></i>@lang('lang.mark_completed')</a></li>
         <li><a class="dropdown-item  text-info class_subject_progress_status" data-href="{{action('Curriculum\ClassSubjectProgressController@edit', [$id])}}?status=reading"><i class="bx bxs-circle me-1"></i>@lang('lang.mark_reading')</a></li>

     </ul>
     @elseif ($status=='reading')
     <button class="btn badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">@lang('lang.inprogress_reading')</button>
      <ul class="dropdown-menu" style="">
         <li><a class="dropdown-item  text-success class_subject_progress_status" data-href="{{action('Curriculum\ClassSubjectProgressController@edit', [$id])}}?status=completed"><i class="bx bxs-circle me-1"></i>@lang('lang.mark_completed')</a></li>
         <li><a class="dropdown-item  text-danger class_subject_progress_status" data-href="{{action('Curriculum\ClassSubjectProgressController@edit', [$id])}}?status=pending"><i class="bx bxs-circle me-1"></i>@lang('lang.mark_pending')</a></li>

     </ul>
     @else
     <button class="btn badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">@lang('lang.completed_on'){{' '. $complete_date .'  ' }}</button>
     <ul class="dropdown-menu" style="">
                 <li><a class="dropdown-item  text-info class_subject_progress_status" data-href="{{action('Curriculum\ClassSubjectProgressController@edit', [$id])}}?status=reading"><i class="bx bxs-circle me-1"></i>@lang('lang.mark_reading')</a></li>

         <li><a class="dropdown-item  text-danger class_subject_progress_status" data-href="{{action('Curriculum\ClassSubjectProgressController@edit', [$id])}}?status=pending"><i class="bx bxs-circle me-1"></i>@lang('lang.mark_pending')</a></li>

     </ul>
 </div>

 @endif
