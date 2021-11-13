  
  <?php $__env->startSection('wrapper'); ?>
  <div class="page-wrapper">
      <div class="page-content">
          <!--breadcrumb-->
          <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3"><?php echo app('translator')->get('account.manage_your_account'); ?></div>
              <div class="ps-3">
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0 p-0">
                          <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                          </li>
                          <li class="breadcrumb-item active" aria-current="page"><?php echo app('translator')->get('account.accounts'); ?></li>
                      </ol>
                  </nav>
              </div>
          </div>

          <!--end breadcrumb-->
          <div class="row row-cols-12 row-cols-md-1 row-cols-lg-12 row-cols-xl-12">
              <hr />
              <div class="card">
                  <div class="card-body">
                      <ul class="nav nav-tabs nav-primary" role="tablist">
                          <li class="nav-item" role="presentation">
                              <a class="nav-link active" data-bs-toggle="tab" href="#other_accounts" role="tab" aria-selected="true">
                                  <div class="d-flex align-items-center">
                                      <div class="tab-icon">
                                          <i class="fa fa-book font-18 me-1"></i>

                                      </div>
                                      <div class="tab-title"><?php echo app('translator')->get('account.accounts'); ?></div>
                                  </div>
                              </a>
                          </li>
                          <li class="nav-item" role="presentation">
                              <a class="nav-link" data-bs-toggle="tab" href="#account-types" role="tab" aria-selected="true">
                                  <div class="d-flex align-items-center">
                                      <div class="tab-icon"><i class='fa fa-list font-18 me-1'></i>
                                      </div>
                                      <div class="tab-title"><?php echo app('translator')->get('lang_v1.account_types'); ?> </div>
                                  </div>
                              </a>
                          </li>


                      </ul>
                      <div class="tab-content py-3">
                          <div class="tab-pane fade show active" id="other_accounts" role="tabpanel">

                              <div class="row">
                                  <div class="col-md-4">
                                      <?php echo Form::select('account_status', ['active' => __('business.is_active'), 'closed' => __('account.closed')], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'account_status']); ?>

                                  </div>
                                  <div class="col-md-8">

                                      <div class="d-lg-flex align-items-center mb-4 gap-3">

                                          <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="<?php echo e(action('AccountController@create'), false); ?>" data-container=".account_model">
                                                  <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('account.add_new_account'); ?></button>
                                          </div>

                                      </div>

                                  </div>
                              </div>
                              <div class="col-sm-12">
                                  <br>
                                  <div class="table-responsive">
                                      <table class="table mb-0 " id="other_account_table">
                                          <thead >
                                              <tr>
                                                  <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                                                  <th><?php echo app('translator')->get( 'lang_v1.name' ); ?></th>
                                                  <th><?php echo app('translator')->get( 'lang_v1.account_type' ); ?></th>
                                                  <th><?php echo app('translator')->get( 'lang_v1.account_sub_type' ); ?></th>
                                                  <th><?php echo app('translator')->get('account.account_number'); ?></th>
                                                  <th><?php echo app('translator')->get( 'account.note' ); ?></th>
                                                  <th><?php echo app('translator')->get('lang_v1.balance'); ?></th>
                                                  <th><?php echo app('translator')->get('lang_v1.added_by'); ?></th>
                                              </tr>
                                          </thead>
                                      </table>
                                  </div>
                              </div>
                          </div>

                          <div class="tab-pane fade show" id="account-types" role="tabpanel">
                              <div class="row">
                                  <div class="d-lg-flex align-items-center mb-4 gap-3">
                                      <div class="ms-auto"><button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0 btn-modal" data-href="<?php echo e(action('AccountTypeController@create'), false); ?>" data-container="#account_type_modal">
                                              <i class="bx bxs-plus-square"></i><?php echo app('translator')->get('account.add_new_account_type'); ?></button>
                                      </div>

                                  </div>
                              </div>

                              <div class="row">

                                  <div class="col-sm-12">

                                      <br>
                                      <div class="table-responsive">
                                          <table class="table mb-0" id="account_types_table">
                                              <thead>
                                                  <tr>
                                                      <th><?php echo app('translator')->get( 'lang_v1.name' ); ?></th>
                                                      <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <?php $__currentLoopData = $account_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <tr class="account_type_<?php echo e($account_type->id, false); ?>">
                                                      <th><?php echo e($account_type->name, false); ?></th>
                                                      <td>

                                                          <?php echo Form::open(['url' => action('AccountTypeController@destroy', $account_type->id), 'method' => 'delete']); ?>

                                                          <button type="button" class="btn btn-primary btn-modal btn-xs" data-href="<?php echo e(action('AccountTypeController@edit', $account_type->id), false); ?>" data-container="#account_type_modal">
                                                              <i class="fa fa-edit"></i> <?php echo app('translator')->get( 'messages.edit'
                                                              ); ?></button>

                                                          <button type="button" class="btn btn-danger btn-xs delete_account_type">
                                                              <i class="fa fa-trash"></i> <?php echo app('translator')->get(
                                                              'messages.delete' ); ?></button>
                                                          <?php echo Form::close(); ?>

                                                      </td>
                                                  </tr>
                                                  <?php $__currentLoopData = $account_type->sub_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <tr>
                                                      <td>&nbsp;&nbsp;-- <?php echo e($sub_type->name, false); ?></td>
                                                      <td>


                                                          <?php echo Form::open(['url' => action('AccountTypeController@destroy', $sub_type->id), 'method' => 'delete']); ?>

                                                          <button type="button" class="btn btn-primary btn-modal btn-xs" data-href="<?php echo e(action('AccountTypeController@edit', $sub_type->id), false); ?>" data-container="#account_type_modal">
                                                              <i class="fa fa-edit"></i> <?php echo app('translator')->get(
                                                              'messages.edit' ); ?></button>
                                                          <button type="button" class="btn btn-danger btn-xs delete_account_type">
                                                              <i class="fa fa-trash"></i> <?php echo app('translator')->get(
                                                              'messages.delete' ); ?></button>
                                                          <?php echo Form::close(); ?>

                                                      </td>
                                                  </tr>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
  </div>

  <!--end row-->

  <div class="modal fade account_model" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="account_type_modal">
  </div>
  <?php $__env->stopSection(); ?>

  <?php $__env->startSection('javascript'); ?>
  <script>
      $(document).ready(function() {


          $(document).on('click', 'button.close_account', function() {
              swal({
                  title: LANG.sure
                  , icon: "warning"
                  , buttons: true
                  , dangerMode: true
              , }).then((willDelete) => {
                  if (willDelete) {
                      var url = $(this).data('url');

                      $.ajax({
                          method: "get"
                          , url: url
                          , dataType: "json"
                          , success: function(result) {
                              if (result.success == true) {
                                  toastr.success(result.msg);
                                  capital_account_table.ajax.reload();
                                  other_account_table.ajax.reload();
                              } else {
                                  toastr.error(result.msg);
                              }

                          }
                      });
                  }
              });
          });

          $(document).on('submit', 'form#edit_payment_account_form', function(e) {
              e.preventDefault();
              var data = $(this).serialize();
              $.ajax({
                  method: "POST"
                  , url: $(this).attr("action")
                  , dataType: "json"
                  , data: data
                  , success: function(result) {
                      if (result.success == true) {
                          $('div.account_model').modal('hide');
                          toastr.success(result.msg);
                          capital_account_table.ajax.reload();
                          other_account_table.ajax.reload();
                      } else {
                          toastr.error(result.msg);
                      }
                  }
              });
          });

          $(document).on('submit', 'form#payment_account_form', function(e) {
              e.preventDefault();
              var data = $(this).serialize();
              $.ajax({
                  method: "post"
                  , url: $(this).attr("action")
                  , dataType: "json"
                  , data: data
                  , success: function(result) {
                      if (result.success == true) {
                          $('div.account_model').modal('hide');
                          toastr.success(result.msg);
                          capital_account_table.ajax.reload();
                          other_account_table.ajax.reload();
                      } else {
                          toastr.error(result.msg);
                      }
                  }
              });
          });

          // capital_account_table
          capital_account_table = $('#capital_account_table').DataTable({
              processing: true
              , serverSide: true
              , ajax: '/account/account?account_type=capital'
              , columnDefs: [{
                  "targets": 5
                  , "orderable": false
                  , "searchable": false
              }]
              , columns: [{
                  data: 'name'
                  , name: 'name'
              }, {
                  data: 'account_number'
                  , name: 'account_number'
              }, {
                  data: 'note'
                  , name: 'note'
              }, {
                  data: 'balance'
                  , name: 'balance'
                  , searchable: false
              }, {
                  data: 'action'
                  , name: 'action'
              }]
              , "fnDrawCallback": function(oSettings) {
                  __currency_convert_recursively($('#capital_account_table'));
              }
          });
          // capital_account_table
          other_account_table = $('#other_account_table').DataTable({
              processing: true
              , serverSide: true
              , ajax: {
                  url: '/account/account?account_type=other'
                  , data: function(d) {
                      d.account_status = $('#account_status').val();
                  }
              }
              , columnDefs: [{
                  "targets": 7
                  , "orderable": false
                  , "searchable": false
              }]
              , columns: [{
                  data: 'action'
                  , name: 'action'
              }, {
                  data: 'name'
                  , name: 'accounts.name'
              }, {
                  data: 'parent_account_type_name'
                  , name: 'pat.name'
              }, {
                  data: 'account_type_name'
                  , name: 'ats.name'
              }, {
                  data: 'account_number'
                  , name: 'accounts.account_number'
              }, {
                  data: 'note'
                  , name: 'accounts.note'
              }, {
                  data: 'balance'
                  , name: 'balance'
                  , searchable: false
              }, {
                  data: 'added_by'
                  , name: 'u.first_name'
              }]
              , "fnDrawCallback": function(oSettings) {
                  __currency_convert_recursively($('#other_account_table'));
              }
          });

      });

      $('#account_status').change(function() {
          other_account_table.ajax.reload();
      });

      $(document).on('submit', 'form#deposit_form', function(e) {
          e.preventDefault();
          var data = $(this).serialize();

          $.ajax({
              method: "POST"
              , url: $(this).attr("action")
              , dataType: "json"
              , data: data
              , success: function(result) {
                  if (result.success == true) {
                      $('div.view_modal').modal('hide');
                      toastr.success(result.msg);
                      capital_account_table.ajax.reload();
                      other_account_table.ajax.reload();
                  } else {
                      toastr.error(result.msg);
                  }
              }
          });
      });

      $('.account_model').on('shown.bs.modal', function(e) {
          $('.account_model .select2').select2({
              theme: 'bootstrap4'
              , width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',

              dropdownParent: $(this)
          })
      });

      $(document).on('click', 'button.delete_account_type', function() {
          swal({
              title: LANG.sure
              , icon: "warning"
              , buttons: true
              , dangerMode: true
          , }).then((willDelete) => {
              if (willDelete) {
                  $(this).closest('form').submit();
              }
          });
      })

      $(document).on('click', 'button.activate_account', function() {
          swal({
              title: LANG.sure
              , icon: "warning"
              , buttons: true
              , dangerMode: true
          , }).then((willActivate) => {
              if (willActivate) {
                  var url = $(this).data('url');
                  $.ajax({
                      method: "get"
                      , url: url
                      , dataType: "json"
                      , success: function(result) {
                          if (result.success == true) {
                              toastr.success(result.msg);
                              capital_account_table.ajax.reload();
                              other_account_table.ajax.reload();
                          } else {
                              toastr.error(result.msg);
                          }

                      }
                  });
              }
          });
      });

  </script>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/account/index.blade.php ENDPATH**/ ?>