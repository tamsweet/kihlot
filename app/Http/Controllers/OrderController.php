<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;
use App\Setting;
use App\Course;
use App\User;
use Auth;
use Redirect;
use PDF;
use App\Currency;
use App\BundleCourse;
use Session;
use Crypt;
use App\RefundCourse;
use App\RefundPolicy;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        $courses = Course::all();
        return view('admin.order.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $created_order = Order::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'instructor_id' => $request->user_id,
            'payment_method' => 'Admin Enroll',
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        Session::flash('success', trans('flash.EnrolledSuccessfully'));
        return redirect('order');
    }

    public function destroy($id)
    {
        DB::table('orders')->where('id',$id)->delete();
        DB::table('pending_payouts')->where('order_id',$id)->delete();
        return back();
    }

    public function vieworder($id)
    {
        $setting = Setting::first();
        $show = Order::where('id', $id)->first();
        return view('admin.order.view', compact('show', 'setting'));
    }

    public function purchasehistory()
    {
        $course = Course::get();
        $orders = Order::where('user_id', Auth::user()->id)->get();

        if(Auth::check())
        {
            return view('front.purchase_history.purchase',compact('orders', 'course'));
        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin')); 
    }

    public function invoice($id)
    {
        $course = Course::all();
        $Bundle = BundleCourse::all();
        $orders = Order::where('id', $id)->first();

        $bundle_order = BundleCourse::where('id', $orders->bundle_id)->first();

        if(Auth::check())
        {
            return view('front.purchase_history.invoice',compact('orders', 'course', 'Bundle', 'bundle_order')); 
        }

        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin')); 
    }

    public function pdfdownload($id){
        $course = Course::all();
        $orders = Order::where('id', $id)->first();

        $bundle_order = BundleCourse::where('id', $orders->bundle_id)->first();

        $pdf = PDF::loadView('front.purchase_history.download', compact('orders','course', 'bundle_order'))->setPaper('a4', 'landscape');
        return $pdf->download('invoice.pdf');
        // return $pdf->stream();

    }


    public function refundview($id)
    {

        $ids = Crypt::decrypt($id);
        $order = Order::where('id', $ids)->first();

        $cor = $order->course_id;

        $course = Course::where('id', $cor)->first();

        $policy = RefundPolicy::where('id', $course->refund_policy_id)->first();


        if(Auth::check())
        {
            return view('front.purchase_history.refund',compact('order', 'policy')); 
        }

        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin')); 
    }

    public function refundrequest(Request $request, $id)
    {

        $ids = Crypt::decrypt($id);
        $order = Order::where('id', $ids)->first();

        $currency = Currency::first();

        $created_refund = RefundCourse::create([
            'user_id' => Auth::user()->id,
            'course_id' => $order->course_id,
            'order_id' => $order->id,
            'instructor_id' => $order->instructor_id,
            'payment_method' => $order->payment_method,
            'total_amount' => $order->total_amount,
            'status' => 0,
            'reason' => $request->reason,
            'detail' => $request->detail,
            'currency' => $order['currency'],
            'currency_icon' => $order->currency_icon,
            'bank_id' => NULL,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        $created_refund->ref_id = 'REF'.$created_refund->id.$created_refund->order_id;
        $created_refund->save();

        return back()->with('success', trans('flash.RequestSuccessfully'));
        
    }

    
}
