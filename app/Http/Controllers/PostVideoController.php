<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\PostVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostVideoController extends Controller
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


        $image = $request->file('image');

        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
        $input['post_id'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/images');

        $image->move($destinationPath, $input['imagename']);

        $input['user_id'] = auth()->user()->id;
        $input['post_id'] = $request->file('post_id');

        Log::info(print_r($input, true));
        PostVideo::create($input);

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
        PostVideo::destroy($id);

        return redirect('post_videos')->with('flash_message', 'Post Video deleted!');
    }
}
