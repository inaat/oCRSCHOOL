<!DOCTYPE html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo app('translator')->get('hrm.teacher&staff_list'); ?></title>
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
       word-wrap:break-word;


    }

    /* Zebra striping */
    tr:nth-of-type(odd) {}

    td,
    th {
        padding: 5px;
        border: 1px solid black;
        text-align: center;
        font-size: 12px;
        word-wrap:break-word;
    }


    .clear {
        clear: both;

    }

</style>
</head>

<body>
    
    <div class="space" style="width:100%;  height:1px;">
    </div>
    <div id="head">
        <h4><?php echo app('translator')->get('hrm.teacher&staff_list'); ?></h4>
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
                <th><?php echo app('translator')->get('lang.email'); ?></th>
                <th><?php echo app('translator')->get('lang.gender'); ?></th>
                <th><?php echo app('translator')->get('lang_v1.mobile'); ?></th>
                <th><?php echo app('translator')->get('lang.cnic_number'); ?></th>
                <th><?php echo app('translator')->get('lang.date_of_birth'); ?></th>
                <th><?php echo app('translator')->get('lang.permanent_address'); ?></th>
                <th><?php echo app('translator')->get('hrm.arrears'); ?></th>


            </tr>
        </thead>
        <tbody>
        
             <?php $__currentLoopData = $HrmEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration, false); ?></td>
                <td><?php echo e($employee->campus_name, false); ?></td>
                <td><?php echo e($employee->employeeID, false); ?></td>
                <td style="background:#eee"><?php echo e($employee->employee_name, false); ?></td>
                <td><?php echo e($employee->father_name, false); ?></td>
                <td><?php echo e($employee->designation, false); ?></td>
                <td><?php echo e(number_format($employee->basic_salary, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>
                <td><?php echo e($employee->email, false); ?></td>
                <td><?php echo e($employee->gender, false); ?></td>
                <td><?php echo e($employee->mobile_no, false); ?></td>
                <td><?php echo e($employee->cnic_no, false); ?></td>
                <td><?php echo e(\Carbon::createFromTimestamp(strtotime($employee->birth_date))->format(session('system_details.date_format')), false); ?></td>
                <td><?php echo e($employee->permanent_address, false); ?></td>
                <td style="background:#eee"><?php echo e(number_format($employee->arrears, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator']), false); ?></td>

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </tbody>

    </table>

</body>

</html>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/Hrm\print/employee_list_print.blade.php ENDPATH**/ ?>