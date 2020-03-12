<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create Invoice manually</title>
    <?php 

        $billing_address=\Session::get('billing_address',null);
        $invoice_id=\Session::get('invoice_id',null);
        $itemtitle=\Session::get('itemtitle',null);
        $quantity=\Session::get('quantity',null);
        $unitprice=\Session::get('unitprice',null);
        $applicabletax=\Session::get('applicabletax',null);
        $amount=\Session::get('amount',null);
        $invoicefilename = \Session::get('filename',null);

    ?>
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
</head>

<body>
    <form method="POST" action="{{url('/generate-pdf')}}" class="form">
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="top">
                        <td colspan="6">
                            <img src="{{asset('headerbg.png')}}" style="width:100%;height: 140px;">
                        </td>
                    </tr>
                    
                    <tr class="information">
                        <td colspan="6">
                            <table>
                                <tr>
                                    <td class="text-left" style="width:50%">
                                        <textarea cols="" name="billing_address" id="editor" rows="10">{{$billing_address ?? ''}}</textarea>
                                    </td>
                                    
                                    <td class="text-right">
                                        <br/>
                                        <br/>
                                        Invoice #: <input type="text" name="invoice_id" value="{{$invoice_id ?? date('Ymd').'-10003'}}"/><br>
                                        {{date('d F,Y')}}<br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                   
                    
                    <tr class="heading">
                        <td>Particular</td>
                        <td>Quantity</td>
                        <td>Per Unit</td>
                        <td>GST Rate</td>
                        <td class="amount">Amount</td>
                        <td></td>
                    </tr>
                <thead>
                <tbody id="ItemTable">
                    
                    @if(isset($itemtitle))
                        @foreach($itemtitle as $key=>$item)
                        <tr class="item">
                            
                            <td style="text-align: left;width: 45%;">
                                <input type="text" name="itemtitle[]" value="{{$itemtitle[$key] ?? ''}}"/>
                            </td>
                            
                            <td>
                                <input type="text" name="quantity[]" value="{{$quantity[$key] ?? ''}}"/>
                            </td>

                            <td>
                                <input type="text" name="unitprice[]" value="{{$unitprice[$key] ?? ''}}"/>
                            </td>
                            
                            <td>
                                <input type="text" name="applicabletax[]" value="{{$applicabletax[$key] ?? ''}}"/>
                            </td>
                            <td>
                                <input type="text" name="amount[]" value="{{$amount[$key] ?? ''}}"/>
                            </td>
                            <td>
                                <button class="removeitem">X</button>
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                
                <tfoot>
                    <tr class="total">
                        <td colspan="5" class="text-right"> Sub-total :</td>
                        
                        <td class="text-left">
                           Total
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
                           Net Amount
                        </td>
                    </tr>
                </tfoot>
            </table>
            <button id="addItemInList" class="btn btn-primary float-right">Add Item</button>
            <button type="submit" class="btn btn-primary float-right">Preview & Download</button>
        </div>
        <div class="footer">
            <p style="text-decoration: underline;">Authorized Signatory</p><br/><br/>
            <img src="{{asset('footertbg.png')}}" style="width:100%;height: 20px;">
        </div>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<script type="text/javascript">
    $(document).on("click","#addItemInList",function(event){
        event.preventDefault();
        $("#ItemTable").append('<tr class="item"><td><input type="text" name="itemtitle[]"/></td><td><input type="text" name="quantity[]"/></td><td><input type="text" name="unitprice[]" /></td><td><input type="text" name="applicabletax[]" /></td><td><input type="text" name="amount[]"/></td><td><button class="removeitem">X</button></td></tr>');
    });


    $(document).on("click",".removeitem",function(event){
        event.preventDefault();
        $(this).closest("tr").remove();
    })
</script>
</html>