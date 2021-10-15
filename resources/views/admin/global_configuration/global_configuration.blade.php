  @extends("admin_layouts.app")
  @section('wrapper')
      <div class="page-wrapper">
          <div class="page-content">
              <!--breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                  <div class="breadcrumb-title pe-3">Components</div>
                  <div class="ps-3">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb mb-0 p-0">
                              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                              </li>
                              <li class="breadcrumb-item active" aria-current="page">Navs & Tabs</li>
                          </ol>
                      </nav>
                  </div>
                  <div class="ms-auto">
                      <div class="btn-group">
                          <button type="button" class="btn btn-primary">Settings</button>
                          <button type="button"
                              class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                              data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                  href="javascript:;">Action</a>
                              <a class="dropdown-item" href="javascript:;">Another action</a>
                              <a class="dropdown-item" href="javascript:;">Something else here</a>
                              <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                  link</a>
                          </div>
                      </div>
                  </div>
              </div>
              {!! Form::open(['url' => action('SystemSettingController@store'), 'class'=>'needs-validation','method' => 'post', 'novalidate','id' => 'bussiness_edit_form',
           'files' => true ]) !!}
              <!--end breadcrumb-->
              <div class="row row-cols-12 row-cols-md-1 row-cols-lg-12 row-cols-xl-12">
                  <h6 class="mb-0 text-uppercase">Primary Nav Tabs</h6>
                  <hr />
                  <div class="card">
                      <div class="card-body">
                          <ul class="nav nav-tabs nav-primary" role="tablist">
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link active" data-bs-toggle="tab" href="#global_config" role="tab"
                                      aria-selected="true">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title">General Settings</div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#sms_settings" role="tab"
                                      aria-selected="false">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title">Sms Settings</div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#prefixes_setting" role="tab"
                                      aria-selected="false">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title">Prefixes Settings</div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#system_settings" role="tab"
                                      aria-selected="false">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title">System Settings</div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#email_settings" role="tab"
                                      aria-selected="false">
                                      <div class="d-flex align-items-center">
                                          <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                          </div>
                                          <div class="tab-title">Email Settings</div>
                                      </div>
                                  </a>
                              </li>

                          </ul>
                          <div class="tab-content py-">
                              <div class="tab-pane fade show active" id="global_config" role="tabpanel">
                                  @include('admin.global_configuration.partials.general_settings')
                              </div>
                              <div class="tab-pane fade" id="sms_settings" role="tabpanel">
                                  @include('admin.global_configuration.partials.sms_settings')

                              </div>
                              <div class="tab-pane fade" id="prefixes_setting" role="tabpanel">
                                  @include('admin.global_configuration.partials.prefixes')
                              </div>
                              <div class="tab-pane fade" id="system_settings" role="tabpanel">
                                  @include('admin.global_configuration.partials.system_settings')
                              </div>

                              <div class="tab-pane fade" id="email_settings" role="tabpanel">
                                  @include('admin.global_configuration.partials.email_settings')
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">

                      <div class="d-lg-flex align-items-center mb-4 gap-3">
                          <div class="ms-auto">
                              <button class="btn btn-primary radius-30 mt-2 mt-lg-0"
                                  type="submit">@lang('system.update_settings')</button>
                          </div>

                      </div>
                  </div>

              </div>
              {!! Form::close() !!}
          </div>

      </div>
      <!--end row-->
    

     
  @section('javascript')
      <script type="text/javascript">

      </script>
      <script type="text/javascript">
          $(document).ready(function() {

              $(".upload_org_logo").on('change', function() {
                  __readURL(this, '.org_logo');
              });
              $(".upload_org_favicon").on('change', function() {
                  __readURL(this, '.org_favicon');
              });
              {{-- $(".upload_org_logo").on('click', function() {
           $(".upload_org_logo").click();
        }); --}}
              {{-- $(".upload_org_favicon").on('click', function() {
           $(".upload_org_favicon").click();
        }); --}}


          });
      </script>

  @endsection
