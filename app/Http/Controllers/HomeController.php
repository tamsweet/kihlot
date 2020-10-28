<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Slider;
use App\SliderFacts;
use App\CategorySlider;
use App\Course;
use App\Meeting;
use App\BBL;
use App\BundleCourse;
use App\Testimonial;
use App\Trusted;
use App\Order;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = Categories::orderBy('position','ASC')->get();
        $sliders = Slider::orderBy('position', 'ASC')->get();
        $facts = SliderFacts::limit(3)->get();
        $categories = CategorySlider::first();
        $cor = Course::all();
        $bundles = BundleCourse::get();
        $meetings = Meeting::where('link_by', NULL)->get();
        $bigblue = BBL::where('is_ended','!=',1)->where('link_by', NULL)->get();
        $testi = Testimonial::all();
        $trusted = Trusted::all();


        return view('home', compact('category', 'sliders', 'facts', 'categories', 'cor', 'bundles', 'meetings', 'bigblue', 'testi', 'trusted'));
    }
}
