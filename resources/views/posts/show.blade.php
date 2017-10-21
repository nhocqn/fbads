@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"> Title: {{ $post->title or "NA" }}</div>

                    <div class="panel-body">
                        @include('errors.showerrors')
                        @include('post_images.image')
                        <br/>
                        <br/>
                        @include('post_videos.video')
                        <br>
                        <br>
                        <div class="col-md-12">
                            <a href="{{ url('/posts') }}" title="Back">
                                <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left"
                                                                          aria-hidden="true"></i>
                                    Back
                                </button>
                            </a>
                            <a href="{{ url('/posts/' . $post->id . '/edit') }}" title="Edit post">
                                <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                          aria-hidden="true"></i> Edit
                                </button>
                            </a>

                            <form method="POST" action="{{ url('posts' . '/' . $post->id) }}" accept-charset="UTF-8"
                                  style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-xs" title="Delete post"
                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                                                                                 aria-hidden="true"></i>
                                    Delete
                                </button>
                            </form>
                            <br/>
                            <br/>

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $post->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Title</th>
                                        <td>{{ $post->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{{ $post->message }}</td>
                                    </tr>
                                    <tr>
                                        <th> Created At</th>
                                        <td> {{ $post->created_at }} </td>
                                    </tr>
                                    <tr>
                                        <th> Updated At</th>
                                        <td> {{ $post->updated_at }} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                            <h3> Post Images</h3>
                            <div>

                                @if($post->post_images->count() > 0)
                                    @foreach($post->post_images as $post_image)
                                        <div class="col-xs-12 col-sm-6 col-md-6 ">
                                            <div class="col-md-12 ">
                                                <img src="{{ url('images/'.$post_image->image_url)}}"
                                                     class="img-responsive">
                                            </div>
                                            <div class="col-md-12 ">


                                                <form method="POST"
                                                      action="{{ url('post/delete-image/' . $post_image->id) }}"
                                                      accept-charset="UTF-8"
                                                      style="display:inline">
                                                    {{ method_field('POST') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-xs"
                                                            title="Delete Image"
                                                            onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                        <i class="fa fa-trash-o"
                                                           aria-hidden="true"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    @endforeach
                                @else
                                    <div class="alert alert-info"> No images attached to this post</div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
