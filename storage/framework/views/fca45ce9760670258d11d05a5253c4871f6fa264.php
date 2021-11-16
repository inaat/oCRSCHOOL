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

    #head {
        width: 30%;
        /* 70% of the parent*/
        background: rgb(4, 101, 49);
        text-align: center;
        color: white;
        padding: 3px;
        margin: 1px auto;
        border-radius: 5px;

    }

    .photo {
        width: 30%;
        /* 70% of the parent*/
        margin: 1px auto;
        border: 1px solid rgb(4, 101, 49);
        ;
        /* background:rgb(4,101,49); */
        text-align: center;
        /* color: white; */
        padding: 3px;
        border-radius: 5px;
        width: 2in;
        height: 2in;
        text-align: center;
        position: absolute;
        left: 73%;
        top: 50px;
    }

    .text {
        width: 50%;
        /* 70% of the parent*/
        margin: 1px auto;
        /* background:rgb(4,101,49); */
        text-align: center;
        /* color: white; */
        padding: 3px;
        border-radius: 5px;
        margin-top: 50px;
    }

    .form-head {
        display: flex;
    }

    .adm-no {
        position: absolute;
        left: 71%;
        top: 12px;
    }

    .form-no {
        position: absolute;
        left: 2%;
        top: 8px;
    }

    .session-no {
        position: absolute;
        left: 40%;
        top: 155px;
    }

    #student-header {
        width: 70%;
        /* 70% of the parent*/
        margin-top: 30px;
        margin-left: 12px;
        background: rgb(4, 101, 49);
        text-align: center;
        color: white;
        padding: 3px;
        border-radius: 5px;
    }

    .student-info {
        width: 70%;

        margin: 10px;

    }

    .check {
        border: 1px solid black;
        width: 20px;
        height: 20px;
    }

    .row {
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

    .mg-left {
        margin-left: 10px;
    }

    .student-info-full {
        margin: 10px;

    }

    .student-full-header {
        margin: 10px;
        background: rgb(4, 101, 49);
        text-align: center;
        color: white;
        padding: 3px;
        border-radius: 5px;

    }



    table {
        width: 100%;
        border-right-color: #ffffff;
        font-size: 18px;
        /* /* border: 1px solid #343a40; */
        border-collapse: collapse;
    }

    th,
    td {
        /* border: 1px solid #343a40; */
        padding: 16px 24px;
        text-align: left;
    }

    th {
        background-color: #087f5b;
        color: #fff;
        width: 25%;
    }

    tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }


    tbody tr:nth-child(even) {
        background-color: #e9ecef;
    }

</style>
</head>
<body>
    <div class="space" style="margin-top:5px; width:100%;  height:5px;">
    </div>
    <div id="head">
        <h4> APPLICATION FOR ADMISSION</h4>
    </div>
    <div class="form-head">
        <div class="form-no">Form No:___________________</div>
        <!-- <div class="session-no">Session:(2021-2022)</div> -->
        <div class="adm-no">Admission No:___________________</div>
    </div>
    <div class="photo">
        <div class="text">
            Attach 2 Passport Size Photographs
        </div>
    </div>


    <div id="student-header">
        <h6> STUDENT INFORMATION</h6>
    </div>
    <div class="student-info">
        <div class='row'>
            <div class='label'>Name <small>(in capital letters as per Certiﬁcate)</small>:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Father’s Name <small>(in capital letters as per Certiﬁcate)</small></div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Date of Birth<small>(dd/mm/yyyy)</small>:</small></div>______/_______/_______
            <!-- <div class='underline'></div> -->
            <div class='label mg-left'>Gender:</small></div>
            <div class="check mg-left"></div>
            <div class='mg-left'>Male</div>
            <div class="check mg-left"></div>
            <div class='mg-left'>Female</div>
        </div>
        <div class='row'>
            <!-- <div class='label'>Date of Admission</div>
                <div class='underline'></div> -->
            <div class='label'>Class of Admission:</div>
            <div class='underline'></div>
            <div class='label mg-left'>CNIC #:</div>
            <div class='underline'></div>
        </div>
    </div>
    <div class="student-info-full">
        <div class='row'>
            <div class='label'>Place of Birth:</div>
            <div class='underline'></div>
            <div class='label'>Nationality:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Religion:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Blood Group:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Father's Ocupation:</div>
            <div class='underline'></div>
            <div class='label'>Father's CNIC #:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Transport:</small></div>
            <div class="check mg-left"></div>
            <div class='mg-left'>Yes</div>
            <div class="check mg-left"></div>
            <div class='mg-left'>No</div>
        </div>
        <div class='row'>
            <div class='label'>Address:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>City/Town:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Tehsil:</div>
            <div class='underline'></div>
            <div class='label mg-left'>District:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Contact Numbers (Cell/PTCL):</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Guardian’s Contact Number:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Email:</div>
            <div class='underline'></div>

        </div>
        <div class="student-full-header">
            <h6>PARENT/GUARDIAN INFORMATION</h6>
        </div>

        <div class='row'>
            <div class='label'>Parent/Guardian:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Relationship:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Guardian CNIC #:</div>
            <div class='underline'></div>
        </div>
        <div class="student-full-header">
            <h6>ACADEMIC INFORMATION</h6>
        </div>

        <div class='row'>
            <div class='label'>Previous School Name:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Last Grade</div>
            <div class='underline'></div>
        </div>
        <div class="student-full-header">
            <h6>SBLING INFORMATION</h6>
        </div>
        <div class='row'>
            <div class='label'>Name:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Roll #:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Current Class:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Name:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Roll #:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Current Class:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Name:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Roll #:</div>
            <div class='underline'></div>
            <div class='label mg-left'>Current Class:</div>
            <div class='underline'></div>
        </div>
          <div class="student-full-header">
            <h6 style="  text-transform: uppercase;">How did you come to know about Swat Collegiate School</h6>
        </div>
        <div class='row'>
            <div class='label mg-left'>Please check your <input type="checkbox" checked="checked" class="myinput" />
                source of information about Swat Collegiate School.</div>
        </div>
        <div class='row' >
            <div class="check mg-left"></div>

            <div class='label mg-left'> Swat Collegiate Prospectus / Brochures</div>
            <div class="check mg-left"></div>

            <div class='label mg-left'> Swat Collegiate Website</div>
            <div class="check mg-left"></div>

            <div class='label mg-left'> Friends / Relatives</div>
            <div class="check mg-left"></div>

            <div class='label mg-left'>Others</div>
            
        </div>
        <div class="student-full-header">
            <h6>FOR OFFICE USE ONLY</h6>
        </div>

        <div class='row'>
            <div class='label'>Admission #:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Admission Date</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Roll #:</div>
            <div class='underline'></div>
            <div class='label  mg-left'>Session #:</div>
            <div class='underline'></div>
        </div>
        <div class='row'>
            <div class='label'>Remark:</div>
            <div class='underline'></div>
        </div>
      
    </div>

</body>
</html>
<?php /**PATH C:\scsserver\htdocs\oCRSCHOOL\resources\views/pdf/invoice-bill.blade.php ENDPATH**/ ?>