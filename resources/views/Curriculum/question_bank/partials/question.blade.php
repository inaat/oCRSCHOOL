 <div class="card">
     <div class="card-body">
         <h5 class="card-title text-primary">@lang('lang.question_bank')</h5>
         <p class="text-info">You may create a plan to complete the subject content for the current session. Later, you can track the subject progress. It is very helpful for teachers, students and parents to follow the plan.
         </p>

         <div class=" d-lg-flex align-items-center mb-4 gap-3">
             <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="{{ action('Curriculum\ClassSubjectQuestionBankController@create',[$class_subject->id]) }}" data-container=".question_bank_modal">
                     <i class="bx bxs-plus-square"></i>@lang('lang.add_new_question')</button></div>
             {{-- <button type="button" class="btn btn-outline-primary width-100  " >MCQ</button>
             <button type="button" class="btn btn-outline-primary width-100" >true&fasle</button>
             <button type="button" class="btn btn-outline-primary width-100" >Short question</button>
             <button type="button" class="btn btn-outline-primary width-100" >Long Question</button>
              --}}
         </div>


         <?xml version="1.0" encoding="UTF-8" standalone="no"?>
         <!-- Created with Inkscape (http://www.inkscape.org/) -->
         

         <div class="table-responsive mt-3">
             <hr>
             <table class="table mb-0" width="100%" id="question_bank_table">

                 <thead class="table-light" width="100%">
                     <tr>
                         <th>@lang('lang.action')</th>
                         <th>@lang('lang.lesson_title')</th>
                         <th>@lang('lang.chapter_number')</th>
                         <th>@lang('lang.question')</th>
                         <th>@lang('lang.marks')</th>
                         <th>@lang('lang.type')</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
 </div>

 <div class="modal fade question_bank_modal select" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
