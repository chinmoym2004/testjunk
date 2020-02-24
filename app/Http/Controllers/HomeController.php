<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    public function generatePdf(Request $request)
    {
    	$data = $request->all();
    	$pdf = PDF::loadView('invoice',$data);
    	$filename = 'Invoice_'.date('YmdHis');
		return $pdf->download($filename.'.pdf');
	}

	public function getTemplate()
	{
		return view('index');
	}	
}
