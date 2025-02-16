<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terms;

class TermsController extends Controller
{
    public function show()
    {
        $items = Terms::first();
        return view('admin.terms.terms', compact('items'));
    }

    public function update(Request $request)
    {
        $data = Terms::first();
        $input = $request->all();

        if (isset($data)) {
            $data->update($input);
        } else {
            $data = Terms::create($input);

            $data->save();
        }

        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }

    public function showpolicy()
    {
        $items = Terms::first();
        return view('admin.terms.policy', compact('items'));
    }

    public function updatepolicy(Request $request)
    {
        $data = Terms::first();
        $input = $request->all();

        if (isset($data)) {
            $data->update($input);
        } else {
            $data = Terms::create($input);

            $data->save();
        }

        return back()->with('success', trans('flash.UpdatedSuccessfully'));
    }
}
