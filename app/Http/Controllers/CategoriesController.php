<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\SubCategory;
use App\ChildCategory;
use Session;
use App\Course;
use File;
use Image;

class CategoriesController extends Controller
{

    public function index()
    {
        $cate = Categories::orderBy('position', 'ASC')->get();
        return view('admin.category.view', compact('cate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.insert');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            "title" => "required|unique:categories,title",
            "title.required" => "Please enter category title !",
            "title.unique" => "This Category name is already exist !"
        ]);

        $input = $request->all();
        $slug = str_slug($input['title'], '-');
        $input['slug'] = $slug;
        $input['position'] = (Categories::count() + 1);

        if ($file = $request->file('image')) {

            $path = 'images/category/';

            if (!file_exists(public_path() . '/' . $path)) {

                $path = 'images/category/';
                File::makeDirectory(public_path() . '/' . $path, 0777, true);
            }
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/category/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);

            $input['cat_image'] = $image;

        }


        $input['status'] = isset($request->status) ? 1 : 0;

        $input['featured'] = isset($request->featured) ? 1 : 0;


        $data = Categories::create($input);

        $data->save();

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect('category');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\categories $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cate = Categories::find($id);
        return view('admin.category.update', compact('cate'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\categories $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\categories $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            "title" => "required|unique:categories,title",
            "title.required" => "Please enter category title !",
            "title.unique" => "This Category name is already exist !"
        ]);

        $data = Categories::findorfail($id);
        $input = $request->all();

        $slug = str_slug($input['title'], '-');
        $input['slug'] = $slug;


        if ($file = $request->file('image')) {

            $path = 'images/category/';

            if (!file_exists(public_path() . '/' . $path)) {

                $path = 'images/category/';
                File::makeDirectory(public_path() . '/' . $path, 0777, true);
            }

            if ($data->cat_image != null) {
                $content = @file_get_contents(public_path() . '/images/category/' . $data->cat_image);
                if ($content) {
                    unlink(public_path() . '/images/category/' . $data->cat_image);
                }
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/category/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);

            $input['cat_image'] = $image;
        }


        if (isset($request->status)) {
            $input['status'] = '1';
        } else {
            $input['status'] = '0';
        }

        if (isset($request->featured)) {
            $input['featured'] = '1';
        } else {
            $input['featured'] = '0';
        }


        $data->update($input);
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\categories $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::User()->role == "admin") {

            $course = Course::where('category_id', $id)->get();

            if (!$course->isEmpty()) {
                return back()->with('delete', trans('flash.CannotDeleteCategory'));
            } else {

                DB::table('categories')->where('id', $id)->delete();
                SubCategory::where('category_id', $id)->delete();
                ChildCategory::where('category_id', $id)->delete();

                return back()->with('delete', trans('flash.DeletedSuccessfully'));
            }
        }

        return redirect('category');
    }

    public function categoryStore(Request $request)
    {
        $cat = new Categories;
        $cat->title = $request->category;
        $cat->icon = $request->icon;
        $cat->slug = str_slug($request->category);
        $cat->featured = $request->featured;
        $cat->status = $request->status;

        $cat->save();
        return back()->with('success', trans('flash.AddedSuccessfully'));

    }

    public function categoryPage($id)
    {
        $cats = Categories::where('id', $id)->first();
        $courses = $cats->courses()->paginate(15);

        $subcat = SubCategory::where('category_id', $cats->id)->get();

        return view('front.category', compact('cats', 'courses', 'subcat'));

    }

    public function subcategoryPage($id)
    {

        $cats = SubCategory::where('id', $id)->first();
        $courses = $cats->courses()->paginate(15);

        $childcat = ChildCategory::where('subcategory_id', $cats->id)->get();

        return view('front.category', compact('cats', 'courses', 'childcat'));

    }

    public function childcategoryPage($id)
    {

        $cats = ChildCategory::where('id', $id)->first();
        $courses = $cats->courses()->paginate(15);

        $childcat = ChildCategory::where('id', $cats->id)->get();

        return view('front.category', compact('cats', 'courses', 'childcat'));


    }

    public function reposition(Request $request)
    {

        $data = $request->all();

        $posts = Categories::all();
        $pos = $data['id'];

        $position = json_encode($data);

        foreach ($posts as $key => $item) {

            Categories::where('id', $item->id)->update(array('position' => $pos[$key]));
        }

        return response()->json(['msg' => 'Updated Successfully', 'success' => true]);


    }


}
