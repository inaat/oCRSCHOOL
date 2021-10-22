  @extends("admin_layouts.app")
  @section('wrapper')
      <div class="page-wrapper">
          <div class="page-content">
              <!--breadcrumb-->
              <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                  <div class="breadcrumb-title pe-3">@lang('account.manage_your_account')</div>
                  <div class="ps-3">
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb mb-0 p-0">
                              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                              </li>
                              <li class="breadcrumb-item active" aria-current="page">@lang('account.accounts')</li>
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
                                              <th>@lang('account.account_name'): </th>
                                              <td>{{ $account->name }}</td>
                                          </tr>
                                          <tr>
                                              <th>@lang('lang_v1.account_type'):</th>
                                              <td>@if (!empty($account->account_type->parent_account)) {{ $account->account_type->parent_account->name }} - @endif {{ $account->account_type->name ?? '' }}</td>
                                          </tr>
                                          <tr>
                                              <th>@lang('account.account_number'):</th>
                                              <td>{{ $account->account_number }}</td>
                                          </tr>
                                          <tr>
                                              <th>@lang('lang_v1.balance'):</th>
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
                                          @lang('account.filters'):</h5>
                                  </div>
                                  <div class="row">

                                      <div class="col-sm-6">
                                          {!! Form::label('transaction_date_range', __('account.date_range') . ':') !!}

                                          <div class="input-group flex-nowrap"> <span class="input-group-text"
                                                  id="addon-wrapping"><i class="fa fa-calendar"></i></span>

                                              {!! Form::text('transaction_date_range', null, ['class' => 'form-control', 'readonly', 'placeholder' => __('account.date_range')]) !!}

                                          </div>
                                      </div>
                                      <div class="col-sm-6">
                                          {!! Form::label('transaction_type', __('account.transaction_type') . ':') !!}

                                          <div class="input-group flex-nowrap"> <span class="input-group-text"
                                                  id="addon-wrapping"><i class="bx bx-transfer"></i></span>
                                              {!! Form::select('transaction_type', ['' => __('messages.all'), 'debit' => __('account.debit'), 'credit' => __('account.credit')], '', ['class' => 'form-control']) !!}

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
                                          <th>@lang( 'messages.date' )</th>
                                          <th>@lang( 'lang_v1.description' )</th>
                                          <th>@lang( 'account.note' )</th>
                                          <th>@lang( 'lang_v1.added_by' )</th>
                                          <th>@lang('account.debit')</th>
                                          <th>@lang('account.credit')</th>
                                          <th>@lang( 'lang_v1.balance' )</th>
                                          <th>@lang( 'messages.action' )</th>
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
  @endsection
  @section('javascript')
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
                      url: '{{ action('AccountController@show', [$account->id]) }}',
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
                  url: '{{ action('AccountController@getAccountBalance', [$account->id]) }}',
                  dataType: "json",
                  success: function(data) {
                      $('span#account_balance').text(__currency_trans_from_en(data.balance, true));
                  }
              });
          }
      </script>
  @endsection
