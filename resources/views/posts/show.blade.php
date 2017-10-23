@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"> Title: {{ $post->title or "NA" }}</div>

                    <div class="panel-body">

                        <div class="container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseOne" aria-expanded="true"
                                                       aria-controls="collapseOne">
                                                        Add Image To Post
                                                    </a>
                                                </h4>

                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                                 aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    @include('post_images.image')
                                                    <br/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapseTwo" aria-expanded="false"
                                                       aria-controls="collapseTwo">
                                                        Add Video To Post
                                                    </a>
                                                </h4>

                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                                 aria-labelledby="headingTwo">
                                                <div class="panel-body">
                                                    @include('post_videos.video')

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('errors.showerrors')

                        <br/>

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
                            <code> Total Post Images : {{$post->post_images->count()}}</code>
                            <code> Total Post Videos : {{$post->post_videos->count()}}</code>

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
                                        <th>Page ID</th>
                                        <td>{{ $post->page_id }}</td>
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


                            <div class="col-md-12">

                                <h3> Post Images</h3>
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
                                    <div class="alert alert-info"> No image attached to this post</div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <br/>
                                <br/>

                                <h3> Post Videos</h3>
                                @if($post->post_videos->count() > 0)

                                    @foreach($post->post_videos as $post_vid)
                                        <div class="col-xs-12 col-sm-6 col-md-6 ">
                                            <div class="col-md-12 ">
                                                @if($post_vid->is_url == "0")
                                                    <video width="340" height="240" controls>
                                                        <source src="{{ url('/videos').'/'.$post_vid->video_url }}"
                                                                type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <div class="video">
                                                        <iframe class="embed-responsive-item" width="340" height="240"
                                                                {{--src="https://youtu.be/embed/HwXsFPZp3fQ"--}}
                                                                src="{{yourtubeVidEmbeder($post_vid->video_url)}}"
                                                                frameborder="0"
                                                                allowfullscreen></iframe>
                                                    </div>

                                                @endif
                                            </div>
                                            <div class="col-md-12 ">


                                                <form method="POST"
                                                      action="{{ url('post/delete-video/' . $post_vid->id) }}"
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
                                    <div class="alert alert-info"> No video attached to this post</div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
