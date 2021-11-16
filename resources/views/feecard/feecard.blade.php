<!DOCTYPE html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<style>
    * {
        margin: 0;
        padding: 0;
    }


    body {
        margin: 0;
        padding: 0;

        width: 100%;
        background-color: rgba(204, 204, 204);

        font-family: 'Roboto Condensed', sans-serif;

    }

    h2,
    h4,
    p {
        margin: 0;


    }

    .div {
        float: left;

    }

    .fee-table-area {
        margin-left: 10px;
        width: 70%;
        border-left: 2px solid black;


    }

    .fee-received {
        width: 27%;
        border-bottom: 2px solid black;
        border-left: 2px solid black;
        border-right: 2px solid black;



    }

    #head {
        width: 300px;
        /* 70% of the parent*/
        background: rgb(4, 101, 49);
        text-align: center;
        color: white;
        padding: 3px;
        margin: 1px auto;
        border-radius: 5px;

    }

    #roll_no {
        width: 70%;
        /* 70% of the parent*/
        text-align: center;
        padding: 1px;
        margin: 1px auto;
        border-radius: 5px;
        border: 1px solid black;

    }

    .row {
        display: -webkit-box;
        display: -webkit-flex;
        display: flex;
        padding: 5px;

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
        width: 510px;
        overflow: hidden;
        /* Should be removed. Only for demonstration */
    }

    .column2 {
        float: left;
        width: 170px;
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

</style>
</head>

<body>
    <div class="div fee-table-area">
        <div id="head">
            <h6>Fee Upto December Session(2020 - 2021)</h6>
        </div>
        <div class="info" style="border:1px solid black;">
            <div class="column1">
                <div class='row'>
                    <div class='label'> <strong>Name:</strong></div>
                    <div class="mg-left"><strong>FAIZ ULLAH KHAN</strong></div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Roll No:</strong></div>
                    <div class="mg-left"><strong>F20-2505</strong></div>
                    <div class='label extra-left'> <strong>Class:</strong></div>
                    <div class="mg-left">
                        <p>Ist - Green</p>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Father's Name:</strong></div>
                    <div class="mg-left"><strong>NABI SALAR</strong></div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Address:</strong></div>
                    <div class="mg-left"><strong>Shalpin Swat</strong></div>
                </div>
                <div class='row'>
                    <div class='label'> <strong>Cell:</strong></div>
                    <div class="mg-left">
                        <p>03428927305</p>
                    </div>
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
                <td><strong>B/F</strong></td>
                @foreach ($balance['bf'] as $b)
                    <td><strong>{{ number_format($b, 0) }}</strong></td>

                @endforeach
            </tr>
            <tr>
                <td><strong>Current Fee</strong></td>
                @foreach ($transaction_formatted as $t)
                    @if($t!=0)
                    <td><strong>{{ number_format($t, 0) }}</strong></td>
                    @else
                    <td><strong>{{ ' ' }}</strong></td>

                    @endif
                @endforeach
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                @foreach ($balance['total'] as $t)
                    <td><strong>{{ number_format($t, 0) }}</strong></td>

                @endforeach
            </tr>
            <tr>
                <td><strong>Paid</strong></td>
                @foreach ($payment_formatted as $p)
    @if($p!=0)
                    <td><strong>{{ number_format($p, 0) }}</strong></td>
                    @else
                    <td><strong>{{ ' ' }}</strong></td>

                    @endif
                @endforeach
            </tr>
            <tr>
                <td><strong>Discount</strong></td>
                @foreach (__('lang.short_months') as $month)
                    <td><strong>{{ ' ' }}</strong></td>

                @endforeach
            </tr>
            <tr>
                <td><strong>Balance</strong></td>
                @foreach ($balance['balance'] as $b)
                    <td><strong>{{ number_format($b, 0) }}</strong></td>

                @endforeach
            </tr>

        </table>
        <div class="space" style="margin-top:px; width:100%;  height:5px;">
        </div>
        <table>
            <thead class="table-light" width="100%">
                <tr>
                    @foreach ($feeHeads as $feeHead)
                        <th>{{ $feeHead->description }}</th>

                    @endforeach
                    <th>Total Current</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="div fee-received">
        <div class="mg-left">
            <div class="space" style="margin-top:px; width:100%;  height:5px;">
            </div>
            <div id="roll_no">

                <h4 class='label'> <strong>Roll No:</strong>
                    <span class="mg-left"><strong>F20-2505</strong></span>
                </h4>

            </div>
            <div class="space" style="margin-top:15px; width:100%;  height:5px;">
            </div>
            <div class='row'>
                <div class='label'> <strong>Name:</strong></div>
                <div class="mg-left"><strong>FAIZ ULLAH KHAN</strong></div>

            </div>

            <div class='row'>
                <div class='label'> <strong>Father's Name:</strong></div>
                <div class="mg-left"><strong>NABI SALAR</strong></div>

            </div>
            <div class='row'>
                <div class='label'> <strong>Class:</strong></div>
                <div class="mg-left">
                    <p>Ist - Green</p>
                </div>

            </div>
        </div>

    </div>



</body>

</html>
