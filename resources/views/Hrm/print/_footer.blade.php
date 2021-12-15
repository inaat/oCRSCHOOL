<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
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
    </style>
</head>
<body>
    <div class='row'>
        <div class='label'> <strong>@lang('hrm.prepared_by'):</strong></div>
        <div class="underline"><strong></strong></div>
        <div class='label extra-left'> <strong>@lang('hrm.certified_by'):</strong></div>
        <div class="underline"><strong></strong></div>
        <div class='label extra-left'> <strong>@lang('hrm.approved_by'):</strong></div>
        <div class="underline"><strong></strong></div>

    </div>
     <footer style=" text-align: center;">
        <h6>Develope By Explainer Khan Group</h6>
    </footer>
</body>
</html>