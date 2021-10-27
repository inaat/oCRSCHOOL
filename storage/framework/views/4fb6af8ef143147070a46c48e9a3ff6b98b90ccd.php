<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
    <style>
      

        * {
            margin: 0;
            padding: 0;
        } @page  {
                header: page-header;
                footer: page-footer;
                

            }
    

        .signature{
            padding-bottom: 30px;
        }
        body {
            margin: 0;
            padding: 0;

            width: 100%;

            font-family: 'Roboto Condensed', sans-serif;

        }
         h6,
        h4,
        p {
            margin: 0;


        }
              .logo {
            margin-left: 10px;
            margin-right: 10px;
            height: 110px;
            border-bottom: 1px solid black;

        }
      
    </style>

</head>

<body>
        <htmlpageheader name="page-header">
            <div class="logo">
            <img src=" <?php echo e($logo, false); ?>" width="100%"/>

</div>

        </htmlpageheader>
    
    <?php echo $__env->yieldContent('content'); ?>
   
     

        <htmlpagefooter name="page-footer" class="page-footer">
            <h3 class="signature" align="right" style="padding-top: 100px">
                <?php echo e(__('Signature'), false); ?>

            </h3>
        </htmlpagefooter>
        
</body>

</html><?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/layouts/pdf.blade.php ENDPATH**/ ?>