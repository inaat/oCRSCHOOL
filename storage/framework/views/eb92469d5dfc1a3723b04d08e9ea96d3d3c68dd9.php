<!DOCTYPE html>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CLASS WISE TIME TABLE</title>
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
        word-wrap: break-word;


    }

    /* Zebra striping */
    tr:nth-of-type(odd) {}

    td,
    th {
        padding: 5px;
        border: 1px solid black;
        text-align: center;
        font-size: 12px;
        word-wrap: break-word;
    }


    .clear {
        clear: both;

    }
    .vertical-text {
            writing-mode:vertical-rl;
            -webkit-writing-mode:vertical-rl;
            -ms-writing-mode:tb-rl;
}

</style>
</head>

<body>

    <div class="space" style="width:100%;  height:1px;">
    </div>
    <div id="head">
        <h3>CLASS WISE TIME TABLE</h3>
    </div>
    <div class="space" style="width:100%;  height:1px;">
    </div>
    <table class="table mb-0" width="100%" id="employees_table">

        <thead class="table-light" width="100%">

            <tr style="background:#eee">
                <th>#</th>
                <th>Clsases</th>
                <?php
                foreach ($class_time_table_title as $t) {
                echo '<th>'.$t.'</th>';
                }
                ?>

            <tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>
                <td> <?php echo e($loop->iteration, false); ?>

                </td>
                <td><?php echo e($section->classes->title, false); ?> <?php echo e($section->section_name, false); ?></td>
                <?php $__currentLoopData = $section->time_table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time_table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!empty($time_table->subjects)): ?>
                <td> <?php echo e($time_table->subjects->name, false); ?> <br><?php if(!empty($time_table->subjects->employees)): ?> <strong>(<?php echo e(ucwords($time_table->subjects->employees->first_name . ' ' . $time_table->subjects->employees->last_name), false); ?>)<?php endif; ?></strong></td>
                <?php else: ?>

                <td ><span class="vertical-text"><?php echo app('translator')->get('lang.'.$time_table->periods->type); ?></span></td>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>

</html>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/school-printing/time_table/print.blade.php ENDPATH**/ ?>