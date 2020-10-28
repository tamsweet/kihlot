<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompletedPayout;
use Auth;
use PDF;

class CompletedPayoutController extends Controller
{
    public function show()
    {
        if(Auth::user()->role == 'admin' )
        {
        	$payout = CompletedPayout::get();
        }
        else
        {
            $payout = CompletedPayout::where('user_id', Auth::User()->id)->get();
        }
    	return view('admin.revenue.completed', compact('payout'));
    }

    public function view($id)
    {
    	$payout = CompletedPayout::where('id', $id)->first();
    	return view('admin.revenue.view', compact('payout'));
    }

    public function pdfdownload($id){

        $payout = CompletedPayout::where('id', $id)->first();

        $pdf = PDF::loadView('admin.revenue.download', compact('payout'))->setPaper('a4', 'landscape');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream();

    }
}
