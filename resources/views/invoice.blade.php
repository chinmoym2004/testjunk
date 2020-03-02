<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        //padding: 30px;
        //border: 1px solid #eee;
        //box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 14px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
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
    
    @media only screen and (max-width: 600px) {
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
    }
    
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
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="6">
                    <img src="{{public_path('headerbg.png')}}" style="width:700px;height: 120px;">
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="6">
                    <table>
                        <tr>
                            <td class="text-left">
                                <br/>
                                <br/>
                                <b>SPRINT TELEFILMS PVT LTD</b><br/>
                                8-2-269/19/S/1,<br/>
                                FIRST FLOOR.<br/>
                                LANE BESIDE-LV PRASAD EYE HOSPITAL<br/>
                                ROAD NO-2<br/>
                                BANJARAHILLS<br/>
                                HYDERABAD- 500034<br/>
                                GST NUMBER : 36AANCS6179CIZO<br/>
                                Contact Person : Mr. Tirumal Reddy (Director)
                            </td>
                            
                            <td class="text-right">
                                <br/>
                                <br/>
                                Invoice #: {{date('Ymd')}}-10001<br>
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
            @endphp
            @if(isset($itemtitle))
            @foreach($itemtitle as $key=>$item)
            <tr class="item">
                <td>{{$i++}}</td>
                <td style="text-align: left;">{{$itemtitle[$key]}}</td>
                <td>{{$quantity[$key]}}</td>
                <td>{{$unitprice[$key]}}</td>
                <td>{{$applicabletax[$key]}}</td>
                <td class="text-left">{{$amount[$key]}}</td>
                @php 
                $total+=$amount[$key]; 
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
                   {{$total}}
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
                   {{$total}}
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-decoration: underline;">
                    Authorized Signatory
                </td>
            </tr>
        </table>
    </div>
</body>
</html>