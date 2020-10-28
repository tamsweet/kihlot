<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Categories;
use App\SubCategory;
use App\ChildCategory;
use App\Slider;
use App\CategorySlider;
use Illuminate\Support\Carbon;
use App\Course;
use App\Order;
use App\Wishlist;
use DB;
use App\BundleCourse;
use App\Testimonial;
use App\Trusted;
use App\FaqStudent;
use App\FaqInstructor;
use App\Blog;
use Validator;
use Hash;
use App\Cart;
use App\Setting;
use App\Page;
use App\Adsense;
use App\SliderFacts;
use App\ReviewRating;
use App\CourseChapter;
use App\CourseClass;
use App\Coupon;
use App\About;
use App\Contact;
use App\Instructor;
use App\CourseProgress;
use App\Terms;
use App\Career;
use App\Meeting;
use App\BBL;
use App\Currency;
use App\CourseReport;


class MainController extends Controller
{

	public function home(Request $request){

		$validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        $settings = Setting::findOrFail(1);
        $adsense = Adsense::first()->toArray();
        $currency = Currency::first()->toArray();

        $slider = Slider::all()->toArray();
        $sliderfacts = SliderFacts::all()->toArray();
        $trusted = Trusted::where('status', 1)->get();

        $testimonial = Testimonial::where('status', 1)->get();

        $category = Categories::where('status', 1)->orderBy('position', 'asc')->get();

        $subcategory = SubCategory::where('status', 1)->get();
        $childcategory = ChildCategory::where('status', 1)->get();

        $featured_cate = Categories::where('status', 1)->where('featured', 1)->get();

	    return response()->json(array('settings'=>$settings, 'adsense' => $adsense, 'currency' => $currency, 'slider'=>$slider, 'sliderfacts'=>$sliderfacts, 'trusted'=>$trusted, 'testimonial'=>$testimonial, 'category'=>$category, 'subcategory'=>$subcategory, 'childcategory'=>$childcategory, 'featured_cate'=>$featured_cate ), 200); 
	}

    

  	public function main(){
    	return response()->json(array('ok'), 200);
  	}

  	public function course(Request $request){

  		$validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

	    $course = Course::where('status', 1)->with('include')->with('whatlearns')->with('review')->get();

	    return response()->json(array('course'=>$course), 200);       
	}

    public function recentcourse(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $course = Course::where('status', 1)->orderBy('id','DESC')->with('include')->with('whatlearns')->get();
        return response()->json(array('course'=>$course), 200);       
    }

	public function featuredcourse(Request $request){

		$validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

	    $featured = Course::where('status', 1)->where('featured', 1)->with('include')->with('whatlearns')->with('review')->get();
	    return response()->json(array('featured'=>$featured), 200);       
	}

	

	public function bundle(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

		$bundle = BundleCourse::where('status', 1)->get();
	    return response()->json(array('bundle'=>$bundle), 200);
	}
    

    public function studentfaq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $faq = FaqStudent::where('status', 1)->get();
        return response()->json(array('faq'=>$faq), 200);
    }

    public function instructorfaq(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $faq = FaqInstructor::where('status', 1)->get();
        return response()->json(array('faq'=>$faq), 200);
    }

    public function blog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $blog = Blog::where('status', 1)->get();
        return response()->json(array('blog'=>$blog), 200);
    }

    public function blogdetail(Request $request)
    {
        $this->validate($request, [
            'blog_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $blog = Blog::where('id', $request->blog_id)->where('status', 1)->get();

        return response()->json(array('blog'=>$blog), 200);
    }

    public function recentblog(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $blog = Blog::where('status', 1)->orderBy('id','DESC')->get();

        return response()->json(array('blog'=>$blog), 200);
    }

	
    public function showwishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        
        $user = Auth::user();
        
        $wishlist = Wishlist::where('user_id',$user->id)->with('courses')->get();
        
        return response()->json(array('wishlist' =>$wishlist), 200);

        

    }

    public function addtowishlist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $orders = Order::where('user_id', $auth->id)->where('course_id', $request->course_id)->first();


        $wishlist = Wishlist::where('course_id', $request->course_id)->where('user_id', $auth->id)->first();

        if(isset($orders)){

            return response()->json('You Already purchased this course !', 401);
        }
        else{


            if(!empty($wishlist)){
                
                return response()->json('Course is already in wishlist !', 401);
            }
            else{

                $wishlist = Wishlist::create([

                    'course_id' => $request->course_id,
                    'user_id'   => $auth->id,
                ]);

                return response()->json('Course is added to your wishlist !', 200);
            }
            
        }
        
        
    }

    public function removewishlist(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $wishlist = Wishlist::where('course_id', $request->course_id)->where('user_id', $auth->id)->delete();
        
        if($wishlist == 1){
          return response()->json(array('1'), 200); 
        }
        else{
          return response()->json(array('error'), 401);       
        }
    }

    

    public function userprofile(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user(); 
        return response()->json(array('user' =>$user), 200); 
    } 

    

    public function updateprofile(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $request->validate([
          'email' => 'required',
          'current_password' => 'required',
        ]);
        $input = $request->all();

        if (Hash::check($request->current_password, $auth->password)){
          if ($file = $request->file('user_img')) {
            if ($auth->user_img != null) {      
              $image_file = @file_get_contents(public_path().'/images/user_img/'.$auth->user_img);
              if($image_file){            
                unlink(public_path().'/images/user_img/'.$auth->user_img);
              }
            }
            $name = time().$file->getClientOriginalName();
            $file->move('images/user_img', $name);
            $input['user_img'] = $name;
          }
          $auth->update([        
            'fname' => isset($input['fname']) ? $input['fname'] : $auth->fname,
            'lname' => isset($input['lname']) ? $input['lname'] : $auth->lname,
            'email' => $input['email'],
            'password' => isset($input['password']) ? bcrypt($input['password']) : $auth->password,
            'mobile' => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
            'dob' => isset($input['dob']) ? $input['dob'] : $auth->dob,
            'user_img' =>  isset($input['user_img']) ? $input['user_img'] : $auth->user_img,
            'address' =>  isset($input['address']) ? $input['address'] : $auth->address,
            'detail' =>  isset($input['detail']) ? $input['detail'] : $auth->detail,
          ]);
          
          $auth->save();
          return response()->json(array('auth' =>$auth), 200);
        } 
        else {
          return response()->json('error: password doesnt match', 400);
        }

        
    } 

    public function mycourses(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $enroll = Order::where('user_id', $user->id)->where('status', 1)->get();

        $enroll_details = array();
        
        foreach ($enroll as $enrol) {
            $course = Course::where('id', $enrol->course_id)->with('whatlearns')->with('include')->with('progress')->first();

            $enroll_details[] = array(
                'title' => $course->title,
                'enroll' => $enrol,
                'course' => $course

            );

        }

        return response()->json(array('enroll_details' =>$enroll_details), 200); 
    } 


    public function addtocart(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::user();

        $courses = Course::where('id', $request->course_id)->first();

        $orders = Order::where('user_id', $auth->id)->where('course_id', $request->course_id)->first();
        $cart = Cart::where('course_id', $request->course_id)->where('user_id', $auth->id)->first();

        if(isset($courses))
        {
            if($courses->type == 1)
            {
                if(isset($orders))
                {
                    return response()->json('You Already purchased this course !', 401);
                }
                else{

                    if(!empty($cart))
                    {
                        return response()->json('Course is already in cart !', 401);
                    }
                    else
                    {
                        $cart = Cart::create([

                            'course_id' => $request->course_id,
                            'user_id'   => $auth->id,
                            'category_id' => $courses->category_id,
                            'price' => $courses->price,
                            'offer_price' => $courses->discount_price
                        ]);

                        return response()->json('Course is added to your cart !', 200);
                    }
                }
            }
            else{
                return response()->json('Course is free', 401);
            }
        }
        else{
            return response()->json('Invalid Course ID', 401);
        }
        
        
    }


    public function removecart(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $cart = Cart::where('course_id', $request->course_id)->where('user_id', $auth->id)->delete();
        
        if($cart == 1){
          return response()->json(array('1'), 200); 
        }
        else{
          return response()->json(array('error'), 401);       
        }
    }


    public function showcart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        
        $user = Auth::user();
        
        $cart = Cart::where('user_id',$user->id)->with('courses')->get();
        
        return response()->json(array('cart' =>$cart), 200);

        

    }

    public function removeallcart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $cart = Cart::where('user_id', $auth->id)->delete();
        
        if(isset($cart)){
          return response()->json(array('1'), 200); 
        }
        else{
          return response()->json(array('error'), 401);       
        }
    }


    public function addbundletocart(Request $request)
    {

        $this->validate($request, [
            'bundle_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $bundle_course = BundleCourse::where('id', $request->bundle_id)->first();

        $orders = Order::where('user_id', $auth->id)->where('bundle_id', $request->bundle_id)->first();


        $cart = Cart::where('bundle_id', $request->bundle_id)->where('user_id', $auth->id)->first();

        if(isset($bundle_course))
        {
            if($bundle_course->type == 1)
            {
                if(isset($orders)){

                    return response()->json('You Already purchased this course !', 401);
                }
                else{


                    if(!empty($cart)){
                        
                        return response()->json('Bundle Course is already in cart !', 401);
                    }
                    else{

                        $cart = Cart::create([

                            'bundle_id' => $request->bundle_id,
                            'user_id'   => $auth->id,
                            'type' => '1',
                            'price' => $bundle_course->price,
                            'offer_price' => $bundle_course->discount_price,
                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                        ]);

                        return response()->json('Bundle Course is added to your cart !', 200);
                    }
                    
                }
            }
            else{
                return response()->json('Bundle course is free !', 401);
            }
            
        }
        else
        {
            return response()->json('Invalid Bundle Course ID !', 401);
        }

        
        
        
    }

    public function removebundlecart(Request $request)
    {
        $this->validate($request, [
            'bundle_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $auth = Auth::user();

        $cart = Cart::where('bundle_id', $request->bundle_id)->where('user_id', $auth->id)->delete();
        
        if($cart == 1){
          return response()->json(array('1'), 200); 
        }
        else{
          return response()->json(array('error'), 401);       
        }
    }

    public function detailpage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $result = Course::where('id','=',$request->course_id)->where('status', 1)->with('include')->with('whatlearns')->with('related')->with('language')->with('user')->with('order')->with('chapter')->with('courseclass')->first();

        if(!$result){
            return response()->json('404 | Course not found !');
        }

        foreach ($result->review as $key => $review) {
            $reviews[] = [

                'user_id' => $review->user_id,
                'fname' => $review->user->fname,
                'lname' =>  $review->user->lname,
                'userimage' => $review->user->user_img,
                'imagepath' =>  url('images/user_img/'),
                'learn' => $review->learn,
                'price' => $review->price,
                'value' => $review->value,
                'reviews' => $review->review,
                'created_by' => $review->created_at,
                'updated_by' => $review->updated_at,
                
            ];
        }
        

        return response()->json([
            'course' => $result->makeHidden(['review']),
            'review' => $reviews
        ]);       
    }


    public function pages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $pages = Page::get();

        return response()->json(array('pages'=>$pages), 200);
    }


    
    


    public function allnotification(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();
        $notifications = $user->unreadnotifications;

        if($notifications){
            return response()->json(array('notifications' => $notifications), 200);
        }else {
            return response()->json(array('error'), 401);
        }
    }


    public function notificationread(Request $request, $id)
    {  

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $userunreadnotification=Auth::user()->unreadNotifications->where('id',$id)->first();
         
        if ($userunreadnotification) {
           $userunreadnotification->markAsRead();
            return response()->json(array('1'), 200);
        }
        else{
            return response()->json(array('error'), 401);            
        }
    }


    public function readallnotification(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $notifications = Auth()->User()->notifications()->delete();

         
        if($notifications) {
          
            return response()->json(array('1'), 200);
        }
        else{
            return response()->json(array('error'), 401);            
        }
    }


    public function instructorprofile(Request $request)
    {
        $this->validate($request, [
            'instructor_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = User::where('id', $request->instructor_id)->first();
        $course_count = Course::where('user_id', $user->id)->count();
        $enrolled_user = Order::where('instructor_id', $user->id)->count();
        $course = Course::where('user_id', $user->id)->get();
         
        if($user) {
          
            return response()->json(array('user'=>$user, 'course'=>$course, 'course_count'=>$course_count, 'enrolled_user'=>$enrolled_user ), 200);
        }
        else{
            return response()->json(array('error'), 401);            
        }
    }


    public function review(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $review = ReviewRating::where('course_id', $request->course_id)->with('user')->get();

        $review_count = ReviewRating::where('course_id', $request->course_id)->count();
         
        if($review) {
          
            return response()->json(array('review'=>$review ), 200);
        }
        else{
            return response()->json(array('error'), 401);            
        }
    }


    public function duration(Request $request)
    {
        $this->validate($request, [
            'chapter_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $chapter = CourseChapter::where('course_id', $request->chapter_id)->first();

        if($chapter) {
        
            $duration =  CourseClass::where('coursechapter_id', $chapter->id)->sum("duration");
        }
        else{
            return response()->json(['Invalid Chapter ID !'], 401);
        }
         
        if($chapter) {
          
            return response()->json(array( 'duration'=>$duration ), 200);
        }
        else{
            return response()->json(array('error'), 401);            
        }
    }




    public function apikeys(Request $request)
    {

        $key = DB::table('api_keys')->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        return response()->json(array('key'=>$key ), 200); 
    }


    public function coursedetail(Request $request){


        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $course = Course::where('status', 1)->with('include')->with('whatlearns')->with('related')->with('review')->with('language')->with('user')->with('order')->with('chapter')->with('courseclass')->get();

        return response()->json(array('course'=>$course), 200);  



        
    }


    public function showcoupon(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $coupon = Coupon::get();

        return response()->json(array('coupon'=>$coupon), 200);       
    }


    public function becomeaninstructor(Request $request)
    {

        $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            'detail' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::user();

        $users = Instructor::where('user_id', $auth->id)->get();

        if(!$users->isEmpty()){

            return response()->json('Already Requested !', 401);  
        }
        else{

            if ($file = $request->file('image'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('images/instructor', $name);
                $input['image'] = $name;
            }


            if($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('files/instructor/',$name);
                $input['file'] = $name;
            }

            $input = $request->all();

            $instructor = Instructor::create([
                'user_id' => $auth->id,    
                'fname' => isset($input['fname']) ? $input['fname'] : $auth->fname,
                'lname' => isset($input['lname']) ? $input['lname'] : $auth->lname,
                'email' => $input['email'],
                'mobile' => isset($input['mobile']) ? $input['mobile'] : $auth->mobile,
                'dob' => isset($input['dob']) ? $input['dob'] : $auth->dob,
                'image' =>  isset($input['image']) ? $input['image'] : $auth->image,
                'file' =>  $input['file'],
                'detail' =>  isset($input['detail']) ? $input['detail'] : $auth->detail,
                'gender' =>  isset($input['gender']) ? $input['gender'] : $auth->gender,
                'status' => '0',
            ]);

            return response()->json(array('instructor'=>$instructor), 200);
        }

               
    }


    public function aboutus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $about = About::all()->toArray();
        return response()->json(array('about'=>$about), 200);
    }


    public function contactus(Request $request)
    {

        $this->validate($request, [
            'fname' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'message' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $created_contact = Contact::create([
            'fname' => $request->fname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return response()->json(array('contact'=>$created_contact), 200);
    }


    public function courseprogress(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::user();

        $course = Course::where('id', $request->course_id)->first();

        $progress = CourseProgress::where('course_id', $course->id)->where('user_id', $auth->id)->first();

        
        return response()->json(array('progress'=>$progress), 200);
        
    }

    public function courseprogressupdate(Request $request)
    {

         $this->validate($request, [
            'checked' => 'required',
            'course_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::user();

        $course = Course::where('id', $request->course_id)->first();

        $progress = CourseProgress::where('course_id', $course->id)->where('user_id', $auth->id)->first();

        if(isset($progress))
        {
            CourseProgress::where('course_id', $course->id)->where('user_id', '=', $auth->id)
                    ->update(['mark_chapter_id' => $request->checked]);

            return response()->json('Updated sucessfully !', 200);
        }
        else
        {
        
            $chapter = CourseChapter::where('course_id', $course->id)->get();

            $chapter_id = array();

            foreach($chapter as $c)
            {
               array_push($chapter_id, "$c->id");
            }

            $created_progress = CourseProgress::create([
                'course_id' => $course->id,
                'user_id' => $auth->id,
                'mark_chapter_id' => $request->checked,
                'all_chapter_id' => $chapter_id,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );

            return response()->json(array('created_progress'=>$created_progress), 200);
        }

        
        
        
    }


    public function terms(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $terms_policy = Terms::get()->toArray();

        return response()->json(array('terms_policy'=>$terms_policy), 200);
    }

    public function career(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $career = Career::get()->toArray();

        return response()->json(array('career'=>$career), 200);
    }


    public function zoom(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $meeting = Meeting::get()->toArray();

        return response()->json(array('meeting'=>$meeting), 200);
    }


    public function bigblue(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $bigblue = BBL::get()->toArray();

        return response()->json(array('bigblue'=>$bigblue), 200);
    }



    public function coursereport(Request $request)
    {

        $this->validate($request, [
            'course_id' => 'required',
            'detail' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $auth = Auth::user();

        $course = Course::where('id', $request->course_id)->first();


        $created_report = CourseReport::create([
            'course_id'=> $course->id,
            'user_id'=> $auth->id,
            'title'=> $course->title,
            'email'=> $auth->email,
            'detail'=> $request->detail,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return response()->json(array('course_report'=>$created_report), 200);
    }



    





}