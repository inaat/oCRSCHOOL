<!DOCTYPE html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@lang('hrm.pay_roll')</title>
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
        font-size: 15px;
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
    @php
    $group_name = __('hrm.payroll_for_month', ['date' => $month_name . ' ' . $year]);

    @endphp
    <div class="space" style="width:100%;  height:1px;">
    </div>
    <div id="head">
        <h4>@lang('hrm.teacher&staff_report')({{ strip_tags($group_name) }})</h4>
    </div>
    <div class="space" style="width:100%;  height:1px;">
    </div>
    <table class="table mb-0" width="100%" id="employees_table">
        <thead class="table-light" width="100%">
            <tr style="background:#eee">
                <th>#</th>
                <th>@lang('campus.campus_name')</th>
                <th>@lang('hrm.employeeID')</th>
                <th>@lang('hrm.employee_name')</th>
                <th>@lang('hrm.father_name')</th>
                <th>@lang('hrm.designation')</th>
                <th>@lang('hrm.basic_salary')</th>
                <th>@lang('hrm.allowance')</th>
                <th>@lang('hrm.deduction')</th>
                <th>@lang('hrm.net_salary')</th>
                <th>@lang('hrm.paid')</th>
                <th>@lang('hrm.arrears')</th>
                <th>@lang('hrm.remarks')</th>


            </tr>
        </thead>
        <tbody>
        
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $transaction['campus_name'] }}</td>
                <td>{{ $transaction['employeeID'] }}</td>
                <td style="background:#eee">{{ $transaction['employee_name'] }}</td>
                <td>{{ $transaction['father_name'] }}</td>
                <td>{{ $transaction['designation'] }}</td>
                <td>{{ @num_format($transaction['basic_salary'] )}}</td>
                <td>{{ @num_format($transaction['allowances_amount'] )}}</td>
                <td>{{ @num_format($transaction['deductions_amount'] )}}</td>
                <td>{{ @num_format($transaction['final_total'] )}}</td>
                <td>{{ @num_format($transaction['total_paid'] )}}</td>
                <td style="background:#eee">{{ @num_format($transaction['arrears'] )}}</td>
                <td></td>

            </tr>
            @endforeach
        </tbody>

    </table>

</body>

</html>
