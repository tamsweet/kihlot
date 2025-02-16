<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PendingPayout;
use App\User;
use Validator;

class AdminPayoutController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'instructor')->get();
        return view('admin.revenue.index', compact('users'));

    }

    public function pending($id)
    {
        $payout = PendingPayout::where('user_id', $id)->where('status', '0')->get();
        return view('admin.revenue.pending', compact('payout', 'id'));
    }

    public function paid($id)
    {
        $payout = PendingPayout::where('user_id', $id)->where('status', '1')->get();
        return view('admin.revenue.paid', compact('payout', 'id'));
    }


    public function bulk_payout(Request $request, $id)
    {

        $user = User::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('delete', trans('flash.Pleaseselectpayout'));
        }

        $payout = PendingPayout::all();

        $allchecked = $request->checked;


        $total = 0;

        foreach ($request->checked as $checked) {

            $payout = PendingPayout::findOrFail($checked);

            $total = $total + $payout->instructor_revenue;

        }

        return view('admin.revenue.payment', compact('total', 'user', 'allchecked', 'payout'));
    }
}
