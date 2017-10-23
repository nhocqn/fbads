@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')
            {{--{{ dd($post->id) }}--}}
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"> Post to Facebook</div>

                    <div class="panel-body">


                        @include('errors.showerrors')


                        <form action="{{ url('/facebook/push/posts') }}" method="post"
                              id="image_post"> {{csrf_field()}}
                            <input name="user_id" value="{{ auth()->user()->id  }}" class="hidden">
                            <input name="post_id" value="{{ $post->id or "  " }}" class="hidden">

                            <input name="feed_post" value="1" class="hidden">
                            <input name="video_post" value="0" class="hidden">
                            <input name="image_post" value="0" class="hidden">
                            <input name="image_url" class="hidden">
                            <input name="video_url" class="hidden">


                            <div class="col-lg-12">
                                <h4>Select the type of post you want.</h4>
                                <div class="pad col-md-2">
                                    <input type="checkbox" checked name="feed_post">
                                    Feed Post
                                </div>
                                <div class="pad  col-md-2">
                                    <input type="checkbox" name="video_post">
                                    Video Post
                                </div>
                                <div class="pad  col-md-2">
                                    <input type="checkbox" name="image_post">
                                    Image Post
                                </div>
                            </div>
                            <div class="col-md-12">

                                <br/>
                                <code> Total Post Images : {{$post->post_images->count()}}</code>
                                <code> Total Post Videos : {{$post->post_videos->count()}}</code>

                                <br/>

                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>

                                        <tr>
                                            <th>Title</th>
                                            <td><code> video </code>
                                                <input name="title" value="{{ $post->title or "" }}"
                                                       class="form-control">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Page ID</th>
                                            <td><code> all </code>
                                                <input name="page_id" value="{{ $post->page_id or "" }}"
                                                       class="form-control">
                                            </td>
                                        </tr>
                                        <tr class="feed_only">
                                            <th>Caption</th>
                                            <td>
                                                <code> feed </code>
                                                <input name="caption" value="{{ $post->caption or "" }}"
                                                       class="form-control">
                                            </td>

                                        </tr>
                                        <tr class="feed_only">
                                            <th>Name</th>
                                            <td>
                                                <code> feed </code>
                                                <input name="name" value="{{ $post->name or "" }}"
                                                       class="form-control">
                                            </td>

                                        </tr>
                                        <tr>
                                            <th>Message</th>
                                            <td>
                                                <code> image, feed </code>
                                                <textarea name="message" rows="10"
                                                          class="form-control">{{ $post->message or "" }}</textarea>
                                            </td>

                                        </tr>
                                        <tr class="feed_only">
                                            <th>Link</th>
                                            <td>
                                                <code> feed </code>
                                                <input name="link" value="{{ $post->link or "" }}" class="form-control">
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>Description</th>
                                            <td>
                                                <code> feed, video </code>
                                                <input name="description" value="{{ $post->description }}"
                                                       class="form-control">
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-12">

                                    <h3> Post Images</h3>
                                    <code> Select the Image to upload </code><br/><br/>
                                    <code> feed </code>

                                    @if($post->post_images->count() > 0)
                                        @foreach($post->post_images as $post_image)
                                            <div class="col-xs-12 col-sm-6 col-md-6 ">
                                                <div class="col-md-12 ">
                                                    <img src="{{ url('images/'.$post_image->image_url)}}"
                                                         class="img-responsive">
                                                </div>
                                                <div class="col-md-12 ">
                                                    <input type="radio" checked name="selected_image"
                                                           class="form-control"
                                                           value="{{ url('/images/'.$post_image->image_url)}}">
                                                </div>
                                            </div>

                                        @endforeach
                                    @else
                                        <div class="alert alert-info"> No image attached to this post</div>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <br/>


                                    <h3> Post Videos</h3>
                                    <code> video </code>
                                    <br/>
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
                                                            <iframe class="embed-responsive-item" width="340"
                                                                    height="240"
                                                                    {{--src="https://youtu.be/embed/HwXsFPZp3fQ"--}}
                                                                    src="{{yourtubeVidEmbeder($post_vid->video_url)}}"
                                                                    frameborder="0"
                                                                    allowfullscreen></iframe>
                                                        </div>

                                                    @endif
                                                </div>
                                                <div class="col-md-12 ">


                                                    <input type="radio" checked name="selected_vid" class="form-control"
                                                           value="{{ $post_vid->is_url > 0 ? $post_vid->video_url: url('/videos/'.$post_vid->video_url)}}">


                                                </div>
                                            </div>

                                        @endforeach
                                    @else
                                        <div class="alert alert-info"> No video attached to this post</div>
                                    @endif
                                </div>

                            </div>

                            <input class="btn btn-lg btn-success pull-right" value="Post" type="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function form_shape() {

        }
        $(function () {
            $('.dropdown-menu li').on('click', function (event) {
                var $checkbox = $(this).find('.checkbox');
                if (!$checkbox.length) {
                    return;
                }
                var $input = $checkbox.find('input');
                var $icon = $checkbox.find('span.fa');
                if ($input.is(':checked')) {
                    $input.prop('checked', false);
                    $icon.removeClass('fa-check').addClass('fa-unchecked')
                } else {
                    $input.prop('checked', true);
                    $icon.removeClass('fa-unchecked').addClass('fa-check')
                }
                return false;
            });
        });

        function form_post_type_select() {

        }
        function form_video_select() {

        }
        function form_image_select() {

        }
    </script>
@endsection
