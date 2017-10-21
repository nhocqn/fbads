<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostImageController extends Controller
{

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


        $image = $request->file('image');

        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
        $input['post_id'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/images');

        $image->move($destinationPath, $input['imagename']);

        $input['user_id'] = auth()->user()->id;
        $input['post_id'] = $request->file('post_id');

        Log::info(print_r($input, true));
        PostImage::create($input);

        return back()->with('success', 'Image Upload successful');
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

        return redirect('post_images')->with('flash_message', 'Post Image Deleted!');
    }
}