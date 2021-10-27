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
        } @page {
                header: page-header;
                footer: page-footer;
                {{-- margin-top:150px;
                margin-right:0px;
                margin-bottom:120px;
                margin-left:0px; --}}

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
            <img src=" {{ $logo }}" width="100%"/>

</div>

        </htmlpageheader>
    
    @yield('content')
   
     

        <htmlpagefooter name="page-footer" class="page-footer">
            <h3 class="signature" align="right" style="padding-top: 100px">
                {{__('Signature')}}
            </h3>
        </htmlpagefooter>
        
</body>

</html>