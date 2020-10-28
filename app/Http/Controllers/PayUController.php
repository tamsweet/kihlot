<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Course;
use App\Currency;
use App\InstructorSetting;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Order;
use App\PendingPayout;
use App\User;
use App\Wishlist;
use Auth;
use Carbon\Carbon;
use Crypt;
use Illuminate\Http\Request;
use Mail;
use Notification;
use Redirect;
use Session;
use Tzsk\Payu\Facade\Payment;

class PayUController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Payu Add on For eclass v2.2 and above
    |--------------------------------------------------------------------------
    |
    | © 2020 - AddOn Developer @nkit
    | PayU Package By : Kazi Mainuddin Ahmed
    | - Mediacity
     */

    public function pay(Request $request)
    {

        $pay = Crypt::decrypt($request->amount);
        Session::put('payment', $pay);

        $currency = Currency::first();

        //       if($currency->currency != 'INR'){
        //     return redirect('/')->with('delete','Payu Only Support INR Payment !');
        // }

        $attributes = [
            'txnid' => 'TXN_' . uniqid(), # Transaction ID.
            'amount' => $pay, # Amount to be charged.
            'productinfo' => "Payment for digital content",
            'firstname' => Auth::user()->fname, # Payee Name.
            'email' => $request->email, # Payee Email Address.
            'phone' => $request->phone, # Payee Phone Number.
        ];

        return Payment::make($attributes, function ($then) {

            $then->redirectRoute('payu.success');

        });

    }

    public function success(Request $request)
    {

        $payment = Payment::capture();

        if ($payment->isCaptured()) {

            $currency = Currency::first();

            $carts = Cart::where('user_id', Auth::User()->id)->get();

            foreach ($carts as $cart) {
                if ($cart->offer_price != 0) {
                    $pay_amount = $cart->offer_price;
                } else {
                    $pay_amount = $cart->price;
                }

                if ($cart->disamount != 0 || $cart->disamount != null) {
                    $cpn_discount = $cart->disamount;
                } else {
                    $cpn_discount = '';
                }

                $lastOrder = Order::orderBy('created_at', 'desc')->first();

                if (!$lastOrder) {
                    // We get here if there is no order at all
                    // If there is no number set it to 0, which will be 1 at the end.
                    $number = 0;
                } else {
                    $number = substr($lastOrder->order_id, 3);
                }

                if ($cart->type == 1) {
                    $bundle_id = $cart->bundle_id;
                    $bundle_course_id = $cart->bundle->course_id;
                    $course_id = null;
                    $duration = null;
                    $instructor_payout = null;
                    $todayDate = null;
                    $expireDate = null;
                    $instructor_id = $cart->bundle->user_id;
                } else {

                    if ($cart->courses->duration_type == "m") {

                        if ($cart->courses->duration != null && $cart->courses->duration != '') {
                            $days = $cart->courses->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = null;
                            $expireDate = null;
                        }
                    } else {

                        if ($cart->courses->duration != null && $cart->courses->duration != '') {
                            $days = $cart->courses->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        } else {
                            $todayDate = null;
                            $expireDate = null;
                        }

                    }

                    $setting = InstructorSetting::first();

                    if ($cart->courses->instructor_revenue != null) {
                        $x_amount = $pay_amount * $cart->courses->instructor_revenue;
                        $instructor_payout = $x_amount / 100;
                    } else {

                        if (isset($setting)) {
                            if ($cart->courses->user->role == "instructor") {
                                $x_amount = $pay_amount * $setting->instructor_revenue;
                                $instructor_payout = $x_amount / 100;
                            } else {
                                $instructor_payout = 0;
                            }

                        } else {
                            $instructor_payout = 0;
                        }
                    }

                    $bundle_id = null;
                    $course_id = $cart->course_id;
                    $bundle_course_id = null;
                    $duration = $cart->courses->duration;
                    $instructor_id = $cart->courses->user_id;
                }

                $created_order = Order::create([
                    'course_id' => $course_id,
                    'user_id' => Auth::User()->id,
                    'instructor_id' => $instructor_id,
                    'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                    'transaction_id' => $payment->txnid,
                    'payment_method' => strtoupper(env('PAYU_DEFAULT')),
                    'total_amount' => $pay_amount,
                    'coupon_discount' => $cpn_discount,
                    'currency' => $currency->currency,
                    'currency_icon' => $currency->icon,
                    'duration' => $duration,
                    'enroll_start' => $todayDate,
                    'enroll_expire' => $expireDate,
                    'bundle_id' => $bundle_id,
                    'bundle_course_id' => $bundle_course_id,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ]
                );

                Wishlist::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->delete();

                Cart::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->delete();

                if ($instructor_payout != 0) {
                    if ($created_order) {

                        if ($cart->type == 0) {

                            if ($cart->courses->user->role == "instructor") {

                                $created_payout = PendingPayout::create([
                                    'user_id' => $cart->courses->user_id,
                                    'course_id' => $cart->course_id,
                                    'order_id' => $created_order->id,
                                    'transaction_id' => $payment->txnid,
                                    'total_amount' => $pay_amount,
                                    'currency' => $currency->currency,
                                    'currency_icon' => $currency->icon,
                                    'instructor_revenue' => $instructor_payout,
                                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                ]
                                );
                            }
                        }

                    }
                }

                if ($created_order) {
                    try {

                        /*sending email*/
                        $x = 'You are successfully enrolled in a course';
                        $order = $created_order;
                        Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));

                    } catch (\Swift_TransportException $e) {
                        Session::flash('deleted', trans('flash.PaymentMailError'));
                        return redirect('/');
                    }
                }

                if ($cart->type == 0) {

                    if ($created_order) {
                        // Notification when user enroll
                        $cor = Course::where('id', $cart->course_id)->first();

                        $course = [
                            'title' => $cor->title,
                            'image' => $cor->preview_image,
                        ];

                        $enroll = Order::where('course_id', $cart->course_id)->get();

                        if (!$enroll->isEmpty()) {
                            foreach ($enroll as $enrol) {
                                $user = User::where('id', $enrol->user_id)->get();
                                Notification::send($user, new UserEnroll($course));
                            }
                        }
                    }
                }
            }

            \Session::flash('success', trans('flash.PaymentSuccess'));
            return redirect('/');

        }

        \Session::flash('delete', trans('flash.PaymentFailed'));
        return redirect('/');

    }
}
