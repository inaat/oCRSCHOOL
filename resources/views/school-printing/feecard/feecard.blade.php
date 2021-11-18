<!DOCTYPE html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@lang('lang.fee_card'){{ ucwords(($current_transaction->voucher_no)) }}</title>
<style>
    * {
        margin: 0;
        padding: 0;
    }


    body {
        margin: 0;
        padding: 0px;

        width: 100%;
        background-color: rgba(204, 204, 204);

        font-family: 'Roboto Condensed', sans-serif;

    }

    h2,
    h4,
    p {
        margin: 0;


    }

    .fee-table-area {
        margin-top: 80px;
        border: 1px solid #000;

        width: 70%;
        overflow: hidden;
        overflow-x: hidden;
        overflow-y: hidden;
        float: left;
        border: 1px solid #000;
        page-break-inside: avoid;




    }

    .fee-received {
        margin-top: 80px;
        border: 1px solid #000;
        width: 29%;
        height: 524px;
        float: right;
        page-break-inside: avoid;




    }

    #head {
        width: 50%;
        /* 70% of the parent*/
        background: rgb(4, 101, 49);
        text-align: center;
        color: white;
        padding: 3px;
        margin: 1px auto;
        border-radius: 5px;

    }

    #head1 {
        width: 80%;
        /* 70% of the parent*/
        background: rgb(4, 101, 49);
        text-align: center;
        color: white;
        padding: 3px;
        margin: 1px auto;
        border-radius: 5px;

    }



    .row {
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        padding: 2px;

    }

    .underline {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;

        flex-grow: 1;
        border-bottom: 1px solid black;
        margin-left: 5px;
    }

    .mg-left {
        margin-left: 10px;
    }

    .extra-left {
        margin-left: 80px;
    }

    .column1 {
        float: left;
        width: 75%;
        overflow: hidden;
        /* Should be removed. Only for demonstration */
    }

    .column2 {
        float: left;
        width: 25%;
        overflow: hidden;

        /* Should be removed. Only for demonstration */
    }

    /* Clear floats after the columns */
    .info:after {
        content: "";
        display: table;
        clear: both;
    }

    table {
        width: 100%;

        border-collapse: collapse;
        border-bottom: 2px solid black;
        overflow: hidden;
        overflow-x: hidden;
        overflow-y: hidden;
        table-layout: fixed;


    }

    /* Zebra striping */
    tr:nth-of-type(odd) {}

    td,
    th {
        padding: 5px;
        border: 1px solid black;
        text-align: center;
        font-size: 12px;
    }


    .clear {
        clear: both;

    }

</style>
</head>

<body>

    <div class=" fee-table-area">
        <div class="space" style="width:100%;  height:1px;">
        </div>
        <div id="head">
            <h6>@lang('lang.fee_upto_december_session')({{ $current_transaction->session->title }})</h6>
        </div>
        <div class="info" style="border:1px solid black;">
            <div class="column1">
               <div class='row'>
                    <div class='label'> <strong>@lang('lang.challan_no'):</strong></div>
                    <div class="mg-left"><strong>{{ ucwords($current_transaction->voucher_no) }}</strong>
                    </div>
                    <div class='label extra-left'> <strong>@lang('lang.date'):</strong></div>
                    <div class="">
                        <p>{{ @format_datetime($current_transaction->transaction_date) }}</p>
                        </p>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>@lang('lang.name'):</strong></div>
                    <div class="mg-left">
                        <strong>{{ ucwords($current_transaction->student->first_name . ' ' . $current_transaction->student->last_name) }}</strong>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>@lang('lang.roll_no'):</strong></div>
                    <div class="mg-left"><strong>{{ ucwords($current_transaction->student->roll_no) }}</strong>
                    </div>
                    <div class='label extra-left'> <strong>@lang('lang.class'):</strong></div>
                    <div class="mg-left">
                        <p>{{ $current_transaction->student_class->title . '  ' . $current_transaction->student_class_section->section_name }}
                        </p>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>@lang('lang.father_name'):</strong></div>
                    <div class="mg-left">
                        <strong>{{ ucwords($current_transaction->student->father_name) }}</strong></div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>@lang('lang.address'):</strong></div>
                    <div class="mg-left">{{ ucwords($current_transaction->student->std_permanent_address) }}</div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>@lang('lang.cell'):</strong></div>
                    <div class="mg-left">
                        <p><strong>{{ ucwords($current_transaction->student->mobile_no) }}</strong></p>
                    </div>
                    @if (!empty($current_transaction->student->discount))


                        <div class='label extra-left'> <strong>@lang('lang.discount'):</strong></div>
                        <div class="mg-left"><strong>@if ($current_transaction->student->discount->discount_type == 'fixed'){{ number_format($current_transaction->student->discount->discount_amount, 0) }}@else{{ number_format($current_transaction->student->discount->discount_amount, 0) . '%' }}@endif</strong></div>
                    @endif
                </div>
                
            </div>
            <div class="column2">
                <img width="150" height="140" src="@lang('student.img')" />
            </div>
        </div>
        <div style="height:1px; background:black;">
        </div>
        <table style="">

            <tr>
                <th style="width: 100px"></th>
                @foreach (__('lang.short_months') as $month)
                    <th>{{ $month }}</th>

                @endforeach
            </tr>

            <tr>
                <td><strong>@lang('lang.b/f')</strong></td>
                @foreach ($balance['bf'] as $b)
                    <td><strong>{{ number_format($b, 0) }}</strong></td>

                @endforeach
            </tr>
            <tr>
                <td><strong>@lang('lang.current_fee')</strong></td>
                @foreach ($transaction_formatted as $t)
                    @if ($t != 0)
                        <td><strong>{{ number_format($t, 0) }}</strong></td>
                    @else
                        <td><strong>{{ ' ' }}</strong></td>

                    @endif
                @endforeach
            </tr>
            <tr>
                <td><strong>@lang('lang.total')</strong></td>
                @foreach ($balance['total'] as $t)
                    <td><strong>{{ number_format($t, 0) }}</strong></td>

                @endforeach
            </tr>
            <tr>
                <td><strong>@lang('lang.paid')</strong></td>
                @foreach ($payment_formatted as $p)
                    @if ($p != 0)
                        <td><strong>{{ number_format($p, 0) }}</strong></td>
                    @else
                        <td><strong>{{ ' ' }}</strong></td>

                    @endif
                @endforeach
            </tr>
            <tr>
                <td><strong>@lang('lang.discount')</strong></td>
                @foreach (__('lang.short_months') as $month)
                    <td><strong>{{ ' ' }}</strong></td>

                @endforeach
            </tr>
            <tr>
                <td><strong>@lang('lang.balance')</strong></td>
                @foreach ($balance['balance'] as $b)
                    <td><strong>{{ number_format($b, 0) }}</strong></td>

                @endforeach
            </tr>

        </table>
        <div class="space" style="margin-top:px; width:100%;  height:5px;">
        </div>
        <h6 style="text-align:center">@lang('lang.current_fee')</h6>
        <table>
            <thead class="table-light" width="100%">
                <tr>
                    @foreach ($current_transaction->fee_lines as $feeHead)
                        <th>{{ $feeHead->feeHead->description }}</th>

                    @endforeach
                    <th>@lang('lang.total_current_fee')</th>
                </tr>
                <tr>
                    @foreach ($current_transaction->fee_lines as $feeHead)
                        <td>{{ number_format($feeHead->amount, 0) }}</td>

                    @endforeach
                    <td>{{ number_format($current_transaction->final_total, 0) }}</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="space" style="margin-top:px; width:100%;  height:5px; border-bottom:1px solid black;">
        </div>
        <div class="space" style="margin-top:px; width:100%;  height:5px;">
        </div>
        <div style=" width:50%; height:50; float:left">
            <div class='row'>
                <div class='label'> <strong>@lang('lang.adjustment')</strong></div>
                <div class="underline"><strong></strong></div>

            </div>
            <div class="space" style="margin-top:px; width:100%;  height:10px;">
            </div>
            <div class='row'>
                <div class='label'> <strong>@lang('lang.account_officer')</strong></div>
                <div class="underline"><strong></strong></div>

            </div>
        </div>
        <div style=" width:50%; height:50; float:right">
            <table>
                <thead class="table-light" width="100%">
                    <tr>
                        <th>@lang('lang.net_total')</th>
                        <td>00</td>
                    </tr>
                    <tr>
                        <th>@lang('lang.paid')</th>
                        <td>{{ number_format($current_transaction_paid->total_paid,0) }}</td>
                    </tr>
                    <tr>
                        <th>@lang('lang.balance')</th>
                        <td>00</td>
                    </tr>

                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="fee-received">
        <div class="mg-left">
            <div class="space" style=" width:100%;  height:2px;">
            </div>
            <div id="head1">
                <span style="font-size:10px">@lang('lang.fee_upto_december_session')({{ $current_transaction->session->title }})</span>
            </div>
            <div class="">
                <div class="space" style="margin-top:px; width:100%;  height:5px;">
                </div>
                <div id="row">
                    <h4 class='label mg-left'> <strong>@lang('lang.roll_no')</strong>
                        <span class="mg-left"><strong>{{ ucwords($current_transaction->student->roll_no) }}</strong></span>
                    </h4>

                </div>
                <div class="space" style="margin-top:15px; width:100%;  height:5px;">
                </div>
                <div class='row'>
                    <div class='label'> <strong>@lang('lang.name'):</strong></div>
                    <div class="mg-left">
                        <strong>{{ ucwords($current_transaction->student->first_name . ' ' . $current_transaction->student->last_name) }}</strong>
                    </div>

                </div>

                <div class='row' style='padding-top:10px;'>
                    <div class='label'> <strong>@lang('lang.father_name'):</strong></div>
                    <div class="mg-left">
                        <strong>{{ ucwords($current_transaction->student->father_name) }}</strong></div>

                </div>
                <div class='row' style='padding-top:10px;'>
                    <div class='label'> <strong>@lang('lang.class')</strong></div>
                    <div class="mg-left">
                        <p>{{ $current_transaction->student_class->title . '  ' . $current_transaction->student_class_section->section_name }}
                        </p>
                    </div>

                </div>
                <div class="space" style="width:100%;  height:45px;">
                </div>
                <div style="margin:0px auto;width:70%;  text-align:center;">
                    <table>
                        <thead class="table-light" width="100%">
                            <tr>
                                <th>@lang('lang.net_total')</th>
                                <td>00</td>
                            </tr>
                            <tr>
                                <th>@lang('lang.paid')</th>
                        <td>{{ number_format($current_transaction_paid->total_paid,0) }}</td>
                            </tr>
                            <tr >
                                <th>@lang('lang.balance')</th>
                                <td>00</td>
                            </tr >

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="space " style="width:100%;  height:30px; border-bottom:1px solid black;">
                </div>
                <div style=" width:100%; height:50; float:left">
                    <div class='row'>
                        <div class='label'> <strong>@lang('lang.adjustment'):</strong></div>
                        <div class="underline"><strong></strong></div>

                    </div>
                    <div class="space" style="margin-top:px; width:100%;  height:10px;">
                    </div>
                    <div class='row'>
                        <div class='label'> <strong>@lang('lang.account_officer'):</strong></div>
                        <div class="underline"><strong></strong></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<p style="page-break:always"> <p>

</body>

</html>
