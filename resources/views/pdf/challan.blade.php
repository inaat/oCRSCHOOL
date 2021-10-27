<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    .doc-type{
        background: #6d5e5e;
        margin: 0 auto;
        text-align: center;
        padding: 5px 0;
        width: 200px;
    }
    .doc-type h2{
        color: #fff;
    }
    table.data-table, table.invoice-info, table.summer-table, table.summery-table-left, table.signature-table {
        width: 100%;
    }
    table.data-table tr td, table.data-table tr th, table.summery-table-left tr td{
        border: 1px solid #463838;
        border-spacing: none;
        padding: 3px;
    }
    table.data-table, table.summery-table-left{
        border-collapse: collapse;
    }
    table.data-table tr td{
        text-align: center;
    }
    table.sum-total{
        width: 100%;
        margin-left: auto;
        border-collapse: collapse;
    }
    table.sum-total tr:last-child{
        border-top: 3px solid #000;
    }
    table.sum-total tr:last-child td{
        border-top: 3px solid #000;
    }
    table.sum-total tr td:last-child{
        text-align: right;
    }
</style>

<div class="doc-type">
    <h2>CHALLAN</h2>
</div>

<br />
<table class="invoice-info">
    <tr>
        <td width="30%">
            <p><strong>Invoice Number:</strong> {{$order_number}}</p>
            <p><strong>Customer Name:</strong> {{$customer['customer_name']}}</p>
            <p><strong>Phone No:</strong> {{$customer['customer_phone']}}</p>
            <p><strong>E-mail:</strong> {{$customer['customer_email']}}</p>
            <p><strong>Address:</strong>{{$customer['customer_address']}} </p>
        </td>
        <td width="50%">&nbsp;</td>
        <td width="30%">
            <table style="margin-left: auto; text-align: right; width: 100%">
                <tr>
                    <th>Date:</th>
                    <td>{{date('d/m/Y', strtotime($created_at))}}</td>
                </tr>
                <tr>
                    <th>Time:</th>
                    <td>{{date('h:i a', strtotime($created_at))}}</td>
                </tr>
                <tr>
                    <th>Sold By:</th>
                    <td>{{$user['name']}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />
<br />

<table class="data-table">
    <thead>
        <tr>
            <th>SL</th>
            <th>Item Name</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @php
            $subtotal = 0;
        @endphp
        @if (count($order_detail) > 0)
            @foreach ($order_detail as $key=> $detail)
            @php
                $subtotal +=  $detail['product_unit_price'] * $detail['product_quantity'];
            @endphp
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$detail['product_name']}}</td>
                    <td>
                        {{$detail['quantity_unit_id']!=null? $detail['quantity_unit_value'].' '.$detail['unit']['name']: $detail['product_quantity'] }}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<table class="signature-table">
    <tbody>
        <tr>
            <td width="25%">
                    <strong style="border-top: 3px solid #000">Customer Signature</strong>
            </td>
            <td width="40%"></td>
            <td width="25%" style="text-align: right">
                <strong style="border-top: 3px solid #000; margin-left:auto; text-align:right">Authority Signature</strong>
            </td>
        </tr>
    </tbody>
</table>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
@if ($challan_note)
    <table style="width: 100%">
        <tr>
            <td style="text-align: center;">
                <p style="text-justify: inter-word;"><strong>N.B: </strong>{{$challan_note}}</p>
            </td>
        </tr>
    </table>
@endif