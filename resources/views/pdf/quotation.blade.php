<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
</style>

<br />
<table width="100%">
    <tr>
        <td width="30%">&nbsp;</td>
        <td width="50%">&nbsp;</td>
        <td width="30%" style="text-align: right; text-decoration: underline">
            {{date('M d, Y', strtotime($created_at))}}
        </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="30%">
            <strong>To</strong> <br>
            <strong class="text-uppercase">{{$recipient}}</strong>
            <p>{{$recipient_address}}</p>
        </td>
        <td width="50%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
    </tr>
</table>

<br />
<br />
<table width="100%">
    <tr>
        <td width="30%">
            <p>Sub: <strong style="text-decoration: underline">{{$subject}}</strong></p>
        </td>
        <td width="50%">&nbsp;</td>
        <td width="30%">&nbsp;</td>
    </tr>
</table>
<br />
<br />
<br />
<br />
<table width="100%" border="1" style="text-align: center;  border-collapse: collapse;">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Description of Items</th>
            <th>Origin</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        @if (count($items) > 0)
            @foreach ($items as $k => $item)
                <tr>
                    <td>{{++$k}}</td>
                    <td style="text-align: left; padding-left: 20px">
                        <p>{{$item['item_name']}}</p>
                        <span>
                            <strong>Brand: </strong> DPA-1
                            |<strong>Model: </strong> 105422
                        </span>

                    </td>
                    <td>{{$item['origin']}}</td>
                    <td>{{$item['quantity']}}</td>
                    <td>{{$item['unit_price']}}</td>
                    <td>{{$item['total_price']}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">No item to show</td>
            </tr>
        @endif
    </tbody>
</table>
<br>
<p style="text-align: center; text-transform: uppercase"> <strong>In Word:</strong> {{$amount_in_total_words}}</p>
<br />
<br />
<br />
<br />
<br />
@if ($notes)
<table style="width: 100%">
    <tr>
        <td>
            <strong>N.B: {{$notes}}</strong>
        </td>
    </tr>
</table>
@endif

<br />
<br />
<br />
<br />
<table class="signature-table">
    <tbody>
        <tr>
            <td width="25%">
                <p>Thanks & Regards,</p>
                <p>Yours faithfully,</p>
                <br>
                <br>
                <br>
                <strong style="border-top: 1px solid #000; margin-left:auto; text-align:right">Managing Director</strong>
            </td>
            <td width="40%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
        </tr>
    </tbody>
</table>