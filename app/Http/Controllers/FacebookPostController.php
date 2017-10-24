<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\FacebookPost;
use Illuminate\Http\Request;

class FacebookPostController extends Controller
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
            $facebook_posts = FacebookPost::paginate($perPage);
        } else {
            $facebook_posts = FacebookPost::paginate($perPage);
        }

        return view('facebook_posts.index', compact('facebook_posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
//    public function create()
//    {
//        return view('facebook_posts.create');
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
//    public function store(Request $request)
//    {
//
//        $requestData = $request->all();
//
//        FacebookPost::create($requestData);
//        $this->flashSuccess('Facebook Post added!');
//        return redirect('facebook_posts');
//    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $facebook_post = FacebookPost::findOrFail($id);

        return view('facebook_posts.show', compact('facebook_post'));
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
        $facebook_post = FacebookPost::findOrFail($id);

        return view('facebook_posts.edit', compact('facebook_post'));
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

        $facebook_post = FacebookPost::findOrFail($id);
        $facebook_post->update($requestData);
        $this->flashSuccess('Facebook Post updated!');
        return redirect('facebook_posts');
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
        FacebookPost::destroy($id);
        $this->flashSuccess('Facebook Post deleted!');
        return redirect('facebook_posts');
    }
}
