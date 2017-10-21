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

            'video' => 'mimetypes:video/avi,video/mpeg,video/quicktime|max:10000',
            'post_id' => 'required',
        ]);

        if (isset($request->is_url)) {
            $input['video_url'] = $request->video_text_url;
        } else {
            $image = $request->file('image');

            $input['video_url'] = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('/videos');

            $image->move($destinationPath, $input['video_url']);
        }


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
