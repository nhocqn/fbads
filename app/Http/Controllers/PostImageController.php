<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostImageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()

    {

        $this->middleware('auth');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $this->validate($request, [

            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'post_id' => 'required',
        ]);

//        dd($request->all());
        $image = $request->file('image');

        $input['image_url'] = time() . '.' . $image->getClientOriginalExtension();
        $input['post_id'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/images');

        $image->move($destinationPath, $input['image_url']);

        $input['user_id'] = auth()->user()->id;
        $input['post_id'] = $request->input('post_id');

        PostImage::create($input);
        $this->flashSuccess('Image Upload successful');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        PostImage::destroy($id);
        $this->flashSuccess('Post Image Deleted!');
        return redirect()->back();
    }
}
