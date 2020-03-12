<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    public function generatePdf(Request $request)
    {
    	$data = $request->all();

		\Session::put('billing_address',$request->billing_address);
		\Session::put('invoice_id',$request->invoice_id);
		\Session::put('itemtitle',$request->itemtitle);
		\Session::put('quantity',$request->quantity);
		\Session::put('unitprice',$request->unitprice);
		\Session::put('applicabletax',$request->applicabletax);
		\Session::put('amount',$request->amount);
    	\Session::put('filename',$filename = 'Invoice_'.date('YmdHis'));
    	
    	return view('invoice');
	}

	public function getTemplate()
	{
		return view('index');
	}

	public static function moneyFormatIndia($num) {
	    $explrestunits = "" ;
	    if(strlen($num)>3) {
	        $lastthree = substr($num, strlen($num)-3, strlen($num));
	        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
	        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
	        $expunit = str_split($restunits, 2);
	        for($i=0; $i<sizeof($expunit); $i++) {
	            // creates each of the 2's group and adds a comma to the end
	            if($i==0) {
	                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
	            } else {
	                $explrestunits .= $expunit[$i].",";
	            }
	        }
	        $thecash = $explrestunits.$lastthree;
	    } else {
	        $thecash = $num;
	    }
	    return $thecash; // writes the final format where $currency is the currency symbol.
	}
}

