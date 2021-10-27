<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Footer</title>
    <style>
    *{
         margin-top:50px;
    }
             
.row{

    display: -webkit-box;
  display: -webkit-flex;
  display: flex;
      padding: 10px;

}
.underline {
      -webkit-box-flex: 1;
  -webkit-flex: 1;
  flex: 1;
  
      flex-grow: 1;
    border-bottom: 1px solid black;
    margin-left: 5px;
}
.mg-left{
    margin-left: 10px;
}
    </style>
</head>
<body>

            <div class='row'>
                <div class='label'>Student Signature:</div>
                <div class='underline'></div>
                <div class='label  mg-left'>Father's /Guardian Signature:</div>
                <div class='underline'></div>
                <div class='label  mg-left'>Principal Signature:</div>
                <div class='underline'></div>
            </div>    
</body>
</html>