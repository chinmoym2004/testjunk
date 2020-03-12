<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <?php 

        $billing_address=\Session::get('billing_address');
        $invoice_id=\Session::get('invoice_id');
        $itemtitle=\Session::get('itemtitle');
        $quantity=\Session::get('quantity');
        $unitprice=\Session::get('unitprice');
        $applicabletax=\Session::get('applicabletax');
        $amount=\Session::get('amount');
        $invoicefilename = \Session::get('filename');

    ?>

    <title>{{$invoicefilename}}</title>
    
    <style>
        body{
            padding:30px;
            width:794px;
            margin: auto
        }
    .invoice-box {
        
        height:1000px;
        font-size: 14px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .footer{
        height:123px;
    }
    
    .invoice-box table {
        line-height: inherit;
        text-align: left;
        width: 100%;
    }
    
    .invoice-box table td {
        //padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 30px;
        line-height: 30px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        text-align: left;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    /*@media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }*/
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    .text-right{
        text-align: right;
    }
    .text-left{
        text-align: left;
    }
    </style>
    <script>
        function printDiv(divName) {
             var printContents = document.getElementById(divName).innerHTML;
             var originalContents = document.body.innerHTML;

             document.body.innerHTML = printContents;

             window.print();

             document.body.innerHTML = originalContents;
        }
    </script>
</head>

<body>
    <div id="printableArea">
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="6">
                        <img src="{{asset('headerbg.png')}}" style="width:100%;height: 140px;">
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="6">
                        <table>
                            <tr>
                                <td class="text-left">
                                    <br/>
                                    <br/>
                                    <?php echo $billing_address; ?>
                                </td>
                                
                                <td class="text-right">
                                    <br/>
                                    <br/>
                                    Invoice #: {{$invoice_id}}<br>
                                    {{date('d F,Y')}}<br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <!-- <tr class="heading">
                    <td>
                        Payment Method
                    </td>
                    
                    <td>
                        Check #
                    </td>
                </tr>
                
                <tr class="details">
                    <td>
                        Check
                    </td>
                    
                    <td>
                        1000
                    </td>
                </tr> -->
                
                <tr class="heading">
                    <td>Sl. No.</td>
                    <td>Particular</td>
                    <td>Quantity</td>
                    <td>Per Unit</td>
                    <td>GST Rate</td>
                    <td class="amount">Amount</td>
                </tr>
                @php 
                $i=1;
                $total = 0;
                setlocale(LC_MONETARY, 'en_IN');
                @endphp
                @if(\Session::has('itemtitle'))
                    @foreach(\Session::get('itemtitle') as $key=>$item)
                    <tr class="item">
                        <td>{{$i++}}</td>
                        <td style="text-align: left;width: 45%;">{{$itemtitle[$key]}}</td>
                        <td>{{$quantity[$key]}}</td>
                        <td>${{$unitprice[$key]}}</td>
                        <td>{{$applicabletax[$key]}}</td>
                        <td class="text-right">${{$amount[$key]}}</td>
                        @php 
                        $tmp = str_replace(",","",$amount[$key]);
                        $total+=$tmp; 
                        @endphp
                    </tr>
                    @endforeach
                @endif
                <tr>
                    <td colspan="6" ></td>
                </tr>
                
                <tr class="total">
                    <td colspan="5" class="text-right"> Sub-total :</td>
                    
                    <td class="text-left">
                       ${{\App\Http\Controllers\HomeController::moneyFormatIndia($total)}}
                    </td>
                </tr>
                <tr class="total">
                    <td colspan="5" class="text-right">GST :</td>
                    
                    <td class="text-left">
                       0%
                    </td>
                </tr>
                <tr class="total">
                    <td colspan="5" class="text-right"> Net Amount :</td>
                    
                    <td class="text-left">
                       ${{\App\Http\Controllers\HomeController::moneyFormatIndia($total)}}
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p style="text-decoration: underline;">Authorized Signatory</p><br/><br/>
            <img src="{{asset('footertbg.png')}}" style="width:100%;height: 20px;">
        </div>
    </div>
    <input type="button" onclick="printDiv('printableArea')" value="Print Invoice" />
    <a href="{{url('/')}}">Update Invoice</a>
</body>
</html>