  
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
              <hr />
              <div class="card">
                  <div class="card-body">
                      <div class="row">
                          <div class="col-sm-4">
                              <div class="box box-solid">
                                  <div class="box-body">
                                      <table class="table">
                                          <tr>
                                              <th><?php echo app('translator')->get('account.account_name'); ?>: </th>
                                              <td><?php echo e($account->name, false); ?></td>
                                          </tr>
                                          <tr>
                                              <th><?php echo app('translator')->get('lang_v1.account_type'); ?>:</th>
                                              <td><?php if(!empty($account->account_type->parent_account)): ?> <?php echo e($account->account_type->parent_account->name, false); ?> - <?php endif; ?> <?php echo e($account->account_type->name ?? '', false); ?></td>
                                          </tr>
                                          <tr>
                                              <th><?php echo app('translator')->get('account.account_number'); ?>:</th>
                                              <td><?php echo e($account->account_number, false); ?></td>
                                          </tr>
                                          <tr>
                                              <th><?php echo app('translator')->get('lang_v1.balance'); ?>:</th>
                                              <td><span id="account_balance"></span></td>
                                          </tr>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-8">
                              <div class="box box-solid">
                                  <div class="box-header">
                                      <h5 class="box-title"> <i class="bx bx-filter" aria-hidden="true"></i>
                                          <?php echo app('translator')->get('account.filters'); ?>:</h5>
                                  </div>
                                  <div class="row">

                                      <div class="col-sm-6">
                                          <?php echo Form::label('transaction_date_range', __('account.date_range') . ':'); ?>


                                          <div class="input-group flex-nowrap"> <span class="input-group-text"
                                                  id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                              <?php echo Form::text('transaction_date_range', null, ['class' => 'form-control', 'readonly', 'placeholder' => __('account.date_range')]); ?>


                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          <?php echo Form::label('transaction_type', __('account.transaction_type') . ':'); ?>


                                          <div class="input-group flex-nowrap"> <span class="input-group-text"
                                                  id="addon-wrapping"><i class="bx bx-transfer"></i></span>
                                              <?php echo Form::select('transaction_type', ['' => __('messages.all'), 'debit' => __('account.debit'), 'credit' => __('account.credit')], '', ['class' => 'form-control']); ?>


                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="card">
                  <div class="card-body">
                     <div class="table-responsive">
                              <table class="table mb-0" id="account_book">
                                  <thead >
                                      <tr>
                                          <th><?php echo app('translator')->get( 'messages.date' ); ?></th>
                                          <th><?php echo app('translator')->get( 'lang_v1.description' ); ?></th>
                                          <th><?php echo app('translator')->get( 'account.note' ); ?></th>
                                          <th><?php echo app('translator')->get( 'lang_v1.added_by' ); ?></th>
                                          <th><?php echo app('translator')->get('account.debit'); ?></th>
                                          <th><?php echo app('translator')->get('account.credit'); ?></th>
                                          <th><?php echo app('translator')->get( 'lang_v1.balance' ); ?></th>
                                          <th><?php echo app('translator')->get( 'messages.action' ); ?></th>
                                      </tr>
                                  </thead>
                              </table>
                          </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="modal fade account_model" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
      </div>
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('javascript'); ?>
      <script>
          $(document).ready(function() {
              update_account_balance();

              dateRangeSettings.startDate = moment().subtract(6, 'days');
              dateRangeSettings.endDate = moment();
              $('#transaction_date_range').daterangepicker(
                  dateRangeSettings,
                  function(start, end) {
                      $('#transaction_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                          moment_date_format));

                      account_book.ajax.reload();
                  }
              );

              // Account Book
              account_book = $('#account_book').DataTable({
                  processing: true,
                  serverSide: true,
                  ajax: {
                      url: '<?php echo e(action('AccountController@show', [$account->id]), false); ?>',
                      data: function(d) {
                          var start = '';
                          var end = '';
                          if ($('#transaction_date_range').val()) {
                              start = $('input#transaction_date_range').data('daterangepicker').startDate
                                  .format('YYYY-MM-DD');
                              end = $('input#transaction_date_range').data('daterangepicker').endDate
                                  .format('YYYY-MM-DD');
                          }
                          var transaction_type = $('select#transaction_type').val();
                          d.start_date = start;
                          d.end_date = end;
                          d.type = transaction_type;
                      }
                  },
                  "ordering": false,
                  "searching": false,
                  columns: [{
                      data: 'operation_date',
                      name: 'operation_date'
                  }, {
                      data: 'sub_type',
                      name: 'sub_type'
                  }, {
                      data: 'note',
                      name: 'note'
                  }, {
                      data: 'added_by',
                      name: 'added_by'
                  }, {
                      data: 'debit',
                      name: 'amount'
                  }, {
                      data: 'credit',
                      name: 'amount'
                  }, {
                      data: 'balance',
                      name: 'balance'
                  }, {
                      data: 'action',
                      name: 'action'
                  }],
                  "fnDrawCallback": function(oSettings) {
                      __currency_convert_recursively($('#account_book'));
                  }
              });

              $('#transaction_type').change(function() {
                  account_book.ajax.reload();
              });
              $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
                  $('#transaction_date_range').val('');
                  account_book.ajax.reload();
              });

          });

          $(document).on('click', '.delete_account_transaction', function(e) {
              e.preventDefault();
              swal({
                  title: LANG.sure,
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
              }).then((willDelete) => {
                  if (willDelete) {
                      var href = $(this).data('href');
                      $.ajax({
                          url: href,
                          dataType: "json",
                          success: function(result) {
                              if (result.success === true) {
                                  toastr.success(result.msg);
                                  account_book.ajax.reload();
                                  update_account_balance();
                              } else {
                                  toastr.error(result.msg);
                              }
                          }
                      });
                  }
              });
          });

          function update_account_balance(argument) {
              $('span#account_balance').html('<i class="fas fa-sync fa-spin"></i>');
              $.ajax({
                  url: '<?php echo e(action('AccountController@getAccountBalance', [$account->id]), false); ?>',
                  dataType: "json",
                  success: function(data) {
                      $('span#account_balance').text(__currency_trans_from_en(data.balance, true));
                  }
              });
          }
      </script>
  <?php $__env->stopSection(); ?>

<?php echo $__env->make("admin_layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/account/show.blade.php ENDPATH**/ ?>