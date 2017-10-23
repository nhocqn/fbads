<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\FacebookPost;
use App\Models\Post;
use App\Models\PostCampaign;
use App\Models\PostImage;
use App\Models\PostVideo;
use Illuminate\Http\Request;

class PostsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $posts = Post::paginate($perPage);
        } else {
            $posts = Post::paginate($perPage);
        }

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('posts.create');
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

        $requestData = $request->all();

        Post::create($requestData);
        $this->flashSuccess('Post added!');
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $post = Post::findOrFail($id);
        $post->update($requestData);
        $this->flashSuccess('Post updated!');
        return redirect('posts');
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
        PostCampaign::where('post_id', $id)->where('user_id', auth()->user()->id)->delete();
        PostImage::where('post_id', $id)->where('user_id', auth()->user()->id)->delete();
        PostVideo::where('post_id', $id)->where('user_id', auth()->user()->id)->delete();
        FacebookPost::where('post_id', $id)->where('user_id', auth()->user()->id)->delete();
        Post::destroy($id);

        $this->flashSuccess('Post deleted!');
        return redirect('posts');
    }


}
