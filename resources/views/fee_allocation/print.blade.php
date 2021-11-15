 @extends("admin_layouts.app")
 @section('wrapper')
     <div class="page-wrapper">
         <div class="page-content">
             <!--breadcrumb-->
             <div class="card">
                 <div class="card-body">
                     <h5 class="card-title text-primary">@lang('lang.all_fee_transaction')</h5>
                     <hr>
                         <table class="table mb-0" width="100%" id="fee_transaction_table">
                             <thead class="table-light" width="100%">
                                 <tr>
                                     <th></th>
                                     @foreach (__('lang.short_months') as  $month)
                                         <th>{{$month}}</th>
                                         
                                     @endforeach
                                 </tr>
                             </thead>
                              <tbody>
                              <tr>
                               <td>B/F</td>
                       
                              @foreach ($balance['bf'] as  $b)
                                  <td>{{  @num_format($b) }}</td>
                              @endforeach
                              </tr>
                              <tr>
                              <tr>
                               <td>Current Fee</td>
                              @foreach ($transaction_formatted as  $q)
                                  <td>{{  @num_format($q) }}</td>
                              @endforeach
                              </tr>
                              <tr>
                               <td>Total</td>

                              @foreach ($balance['total'] as  $t)
                                  <td>{{  @num_format($t) }}</td>
                              @endforeach
                              </tr>
                            <td>paid</td>

                              @foreach ($payment_formatted as  $p)
                                  <td>{{  @num_format($p) }}</td>
                              @endforeach
                              </tr>
                            <td>Balance</td>

                              @foreach ($balance['balance'] as  $b)
                                  <td>{{  @num_format($b) }}</td>
                              @endforeach
                              </tr>
                           
                              </tbody>
                         </table>
                 </div>
             </div>
         </div>
     </div>

 @endsection


