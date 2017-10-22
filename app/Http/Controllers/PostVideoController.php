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
        try {

            $this->validate($request, [
                'video_url' => 'sometimes|mimetypes:video/avi,video/mp4,video/mpeg,video/quicktime',
                'post_id' => 'required',
                'user_id' => 'required',
            ]);


            if (isset($request->is_url)) {
                $input['video_url'] = $request->video_text_url;
                $input['is_url'] = 1;
            } else {
                $video = $request->file('video');
                $input['is_url'] = 0;
                $input['video_url'] = time() . '.' . $video->getClientOriginalExtension();

                $destinationPath = public_path('/videos');

                $video->move($destinationPath, $input['video_url']);
            }


            $input['user_id'] = auth()->user()->id;
            $input['post_id'] = $request->input('post_id');

            PostVideo::create($input);
            $this->flashSuccess('Video Upload successful');

            return redirect()->back();

        } catch (\Exception $e) {
            $this->flashError($e->getMessage());
            return redirect()->back();
        }
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

        $this->flashSuccess('Post Video deleted!');

        return redirect()->back();
    }
}
