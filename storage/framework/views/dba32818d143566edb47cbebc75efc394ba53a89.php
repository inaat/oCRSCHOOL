<!DOCTYPE html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo app('translator')->get('hrm.pay_roll'); ?></title>
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
    <?php
    $group_name = __('hrm.payroll_for_month', ['date' => $month_name . ' ' . $year]);

    ?>
    <div class="space" style="width:100%;  height:1px;">
    </div>
    <div id="head">
        <h4><?php echo app('translator')->get('hrm.teacher&staff_report'); ?>(<?php echo e(strip_tags($group_name), false); ?>)</h4>
    </div>
    <div class="space" style="width:100%;  height:1px;">
    </div>
    <table class="table mb-0" width="100%" id="employees_table">
        <thead class="table-light" width="100%">
            <tr style="background:#eee">
                <th>#</th>
                <th><?php echo app('translator')->get('campus.campus_name'); ?></th>
                <th><?php echo app('translator')->get('hrm.employeeID'); ?></th>
                <th><?php echo app('translator')->get('hrm.employee_name'); ?></th>
                <th><?php echo app('translator')->get('hrm.father_name'); ?></th>
                <th><?php echo app('translator')->get('hrm.designation'); ?></th>
                <th><?php echo app('translator')->get('hrm.basic_salary'); ?></th>
                <th><?php echo app('translator')->get('hrm.allowance'); ?></th>
                <th><?php echo app('translator')->get('hrm.deduction'); ?></th>
                <th><?php echo app('translator')->get('hrm.net_salary'); ?></th>
                <th><?php echo app('translator')->get('hrm.paid'); ?></th>
                <th><?php echo app('translator')->get('hrm.arrears'); ?></th>
                <th><?php echo app('translator')->get('hrm.remarks'); ?></th>


            </tr>
        </thead>
        <tbody>
        
            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration, false); ?></td>
                <td><?php echo e($transaction['campus_name'], false); ?></td>
                <td><?php echo e($transaction['employeeID'], false); ?></td>
                <td style="background:#eee"><?php echo e($transaction['employee_name'], false); ?></td>
                <td><?php echo e($transaction['father_name'], false); ?></td>
                <td><?php echo e($transaction['designation'], false); ?></td>
                <td><?php echo e(number_format($transaction['basic_salary'], config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td><?php echo e(number_format($transaction['allowances_amount'], config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td><?php echo e(number_format($transaction['deductions_amount'], config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td><?php echo e(number_format($transaction['final_total'], config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td><?php echo e(number_format($transaction['total_paid'], config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td style="background:#eee"><?php echo e(number_format($transaction['arrears'], config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td></td>

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>

    </table>

</body>

</html>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\print/employee_print.blade.php ENDPATH**/ ?>