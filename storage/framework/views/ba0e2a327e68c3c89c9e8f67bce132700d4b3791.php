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




    }

    .fee-received {
        margin-top: 80px;
        border: 1px solid #000;
        width: 29%;
        height: 524px;
        float: right;




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
            <h6>Fee Upto December Session(<?php echo e($current_transaction->session->title, false); ?>)</h6>
        </div>
        <div class="info" style="border:1px solid black;">
            <div class="column1">
               <div class='row'>
                    <div class='label'> <strong>Challan No:</strong></div>
                    <div class="mg-left"><strong><?php echo e(ucwords($current_transaction->voucher_no), false); ?></strong>
                    </div>
                    <div class='label extra-left'> <strong>Date:</strong></div>
                    <div class="">
                        <p><?php echo e(\Carbon::createFromTimestamp(strtotime($current_transaction->transaction_date))->format(session('system_details.date_format') . ' ' . 'h:i A'), false); ?></p>
                        </p>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Name:</strong></div>
                    <div class="mg-left">
                        <strong><?php echo e(ucwords($current_transaction->student->first_name . ' ' . $current_transaction->student->last_name), false); ?></strong>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Roll No:</strong></div>
                    <div class="mg-left"><strong><?php echo e(ucwords($current_transaction->student->roll_no), false); ?></strong>
                    </div>
                    <div class='label extra-left'> <strong>Class:</strong></div>
                    <div class="mg-left">
                        <p><?php echo e($current_transaction->student_class->title . '  ' . $current_transaction->student_class_section->section_name, false); ?>

                        </p>
                    </div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Father's Name:</strong></div>
                    <div class="mg-left">
                        <strong><?php echo e(ucwords($current_transaction->student->father_name), false); ?></strong></div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Address:</strong></div>
                    <div class="mg-left"><?php echo e(ucwords($current_transaction->student->std_permanent_address), false); ?></div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Cell:</strong></div>
                    <div class="mg-left">
                        <p><strong><?php echo e(ucwords($current_transaction->student->mobile_no), false); ?></strong></p>
                    </div>
                    <?php if(!empty($current_transaction->student->discount)): ?>


                        <div class='label extra-left'> <strong>Discount:</strong></div>
                        <div class="mg-left"><strong><?php if($current_transaction->student->discount->discount_type == 'fixed'): ?><?php echo e(number_format($current_transaction->student->discount->discount_amount, 0), false); ?><?php else: ?><?php echo e(number_format($current_transaction->student->discount->discount_amount, 0) . '%', false); ?><?php endif; ?></strong></div>
                    <?php endif; ?>
                </div>
                
            </div>
            <div class="column2">
                <img width="150" height="140" src="<?php echo app('translator')->get('student.img'); ?>" />
            </div>
        </div>
        <div style="height:1px; background:black;">
        </div>
        <table style="">

            <tr>
                <th style="width: 100px"></th>
                <?php $__currentLoopData = __('lang.short_months'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($month, false); ?></th>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>

            <tr>
                <td><strong>B/F</strong></td>
                <?php $__currentLoopData = $balance['bf']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td><strong><?php echo e(number_format($b, 0), false); ?></strong></td>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <td><strong>Current Fee</strong></td>
                <?php $__currentLoopData = $transaction_formatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($t != 0): ?>
                        <td><strong><?php echo e(number_format($t, 0), false); ?></strong></td>
                    <?php else: ?>
                        <td><strong><?php echo e(' ', false); ?></strong></td>

                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <?php $__currentLoopData = $balance['total']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td><strong><?php echo e(number_format($t, 0), false); ?></strong></td>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <td><strong>Paid</strong></td>
                <?php $__currentLoopData = $payment_formatted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($p != 0): ?>
                        <td><strong><?php echo e(number_format($p, 0), false); ?></strong></td>
                    <?php else: ?>
                        <td><strong><?php echo e(' ', false); ?></strong></td>

                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <td><strong>Discount</strong></td>
                <?php $__currentLoopData = __('lang.short_months'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td><strong><?php echo e(' ', false); ?></strong></td>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <tr>
                <td><strong>Balance</strong></td>
                <?php $__currentLoopData = $balance['balance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td><strong><?php echo e(number_format($b, 0), false); ?></strong></td>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>

        </table>
        <div class="space" style="margin-top:px; width:100%;  height:5px;">
        </div>
        <h6 style="text-align:center">Current Fee</h6>
        <table>
            <thead class="table-light" width="100%">
                <tr>
                    <?php $__currentLoopData = $current_transaction->fee_lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feeHead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($feeHead->feeHead->description, false); ?></th>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <th>Total Current</th>
                </tr>
                <tr>
                    <?php $__currentLoopData = $current_transaction->fee_lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feeHead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e(number_format($feeHead->amount, 0), false); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <td><?php echo e(number_format($current_transaction->final_total, 0), false); ?></td>
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
                <div class='label'> <strong>Adj:</strong></div>
                <div class="underline"><strong></strong></div>

            </div>
            <div class="space" style="margin-top:px; width:100%;  height:10px;">
            </div>
            <div class='row'>
                <div class='label extra-left'> <strong>Account Officer:</strong></div>
                <div class="underline"><strong></strong></div>

            </div>
        </div>
        <div style=" width:50%; height:50; float:right">
            <table>
                <thead class="table-light" width="100%">
                    <tr>
                        <th>Net Total</th>
                        <td>00</td>
                    </tr>
                    <tr>
                        <th>Paid</th>
                        <td><?php echo e(number_format($current_transaction_paid->total_paid,0), false); ?></td>
                    </tr>
                    <tr>
                        <th>Balance</th>
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
                <span style="font-size:10px">Fee Upto December
                    Session(<?php echo e($current_transaction->session->title, false); ?>)</span>
            </div>
            <div class="">
                <div class="space" style="margin-top:px; width:100%;  height:5px;">
                </div>
                <div id="row">

                    <h4 class='label mg-left'> <strong>Roll No:</strong>
                        <span class="mg-left"><strong>F20-2505</strong></span>
                    </h4>

                </div>
                <div class="space" style="margin-top:15px; width:100%;  height:5px;">
                </div>
                <div class='row'>
                    <div class='label'> <strong>Name:</strong></div>
                    <div class="mg-left">
                        <strong><?php echo e(ucwords($current_transaction->student->first_name . ' ' . $current_transaction->student->last_name), false); ?></strong>
                    </div>

                </div>

                <div class='row'>
                    <div class='label'> <strong>Father's Name:</strong></div>
                    <div class="mg-left">
                        <strong><?php echo e(ucwords($current_transaction->student->father_name), false); ?></strong></div>

                </div>
                <div class='row'>
                    <div class='label'> <strong>Class:</strong></div>
                    <div class="mg-left">
                        <p><?php echo e($current_transaction->student_class->title . '  ' . $current_transaction->student_class_section->section_name, false); ?>

                        </p>
                    </div>

                </div>
                <div class="space" style="width:100%;  height:45px;">
                </div>
                <div style="margin:1px auto;width:70%;  text-align:center;">
                    <table>
                        <thead class="table-light" width="100%">
                            <tr>
                                <th>Net Total</th>
                                <td>00</td>
                            </tr>
                            <tr>
                                <th>Paid</th>
                        <td><?php echo e(number_format($current_transaction_paid->total_paid,0), false); ?></td>
                            </tr>
                            <tr>
                                <th>Balance</th>
                                <td>00</td>
                            </tr>

                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="space" style="margin-top:px; width:100%;  height:30px;">
                </div>
                <div style=" width:100%; height:50; float:left">
                    <div class='row'>
                        <div class='label'> <strong>Adj:</strong></div>
                        <div class="underline"><strong></strong></div>

                    </div>
                    <div class="space" style="margin-top:px; width:100%;  height:10px;">
                    </div>
                    <div class='row'>
                        <div class='label'> <strong>Account Officer:</strong></div>
                        <div class="underline"><strong></strong></div>

                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/feecard/feecard.blade.php ENDPATH**/ ?>