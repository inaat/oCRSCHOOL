  
  <?php $__env->startSection('wrapper'); ?>
      <div class="page-wrapper">
          <div class="page-content">
              <!--breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                  <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('lang.subject_detail'); ?></div>
                  <div class="ps-3">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb mb-0 p-0">
                              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                              </li>
                              <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('lang.subject_detail'); ?></li>
                          </ol>
                      </nav>
                  </div>
                  
              </div>
              
              <!--end breadcrumb-->
              <div class="row row-cols-12 row-cols-md-1 row-cols-lg-12 row-cols-xl-12">
                  <h6 class="mb-0 text-uppercase text-info"> <?php echo app('translator')->get('lang.subject_detail'); ?> - <?php echo e($class_subject->name, false); ?> of class <?php echo e($class_subject->classes->title, false); ?></h6>
                  <hr />
                  <div class="card">
                      <div class="card-body">
                          <ul class="nav nav-tabs nav-primary" role="tablist">
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link " data-bs-toggle="tab" href="#lesson" role="tab"
                                      aria-selected="false">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='fadeIn animated bx bx-book-reader font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title"><?php echo app('translator')->get('lang.lessons'); ?></div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link active" data-bs-toggle="tab" href="#progress" role="tab"
                                      aria-selected="true">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-book-content font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title"><?php echo app('translator')->get('lang.planning_&_progress'); ?></div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#question_bank" role="tab"
                                      aria-selected="false">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-briefcase font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title"><?php echo app('translator')->get('lang.question_bank'); ?></div>
                                      </div>
                                  </a>
                              </li>
                              

                          </ul>
                          <div class="tab-content py-">
                              <div class="tab-pane fade" id="lesson" role="tabpanel">
                                <?php echo $__env->make('Curriculum.lesson.partials.lesson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                              </div>
                              <div class="tab-pane fade show active" id="progress" role="tabpanel">
                                <?php echo $__env->make('Curriculum.progress.partials.progress', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                              </div>
                              <div class="tab-pane fade" id="question_bank" role="tabpanel">
                                <?php echo $__env->make('Curriculum.question_bank.partials.question', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                              </div>
                              <div class="tab-pane fade" id="system_settings" role="tabpanel">
                              </div>

                             
                          </div>
                      </div>
                  </div>
              </div>
              
              
          </div>

      </div>
      <!--end row-->
 <?php $__env->stopSection(); ?>   
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('/js/school.js?v=' . $asset_v), false); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Curriculum\lesson/index.blade.php ENDPATH**/ ?>