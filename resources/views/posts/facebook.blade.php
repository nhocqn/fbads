@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')
{{--{{ dd($post->id) }}--}}
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"> Title: {{ $post->title or "NA" }}</div>

                    <div class="panel-body">


                        @include('errors.showerrors')


                        <form action="{{ url('/facebook/push/posts') }}" method="post"
                              id="image_post"> {{csrf_field()}}
                            <input name="user_id" value="{{ auth()->user()->id  }}" class="hidden">
                            <input name="post_id" value="{{ $post->id or "  " }}" class="hidden">

                        </form>


                        <div class="col-lg-12">
                            <h4>Select the type of post you want.</h4>
                            <div class="pad col-md-2">
                                <input type="checkbox"
                                       onchange="form_post_type_select('0')">
                                Feed Post
                            </div>
                            <div class="pad  col-md-2">
                                <input type="checkbox"
                                       onchange="form_post_type_select('1')">
                                Video Post
                            </div>
                            <div class="pad  col-md-2">
                                <input type="checkbox"
                                       onchange="form_post_type_select('2')">
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
                                        <td>{{ $post->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Message</th>
                                        <td>{{ $post->message }}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>


                            <div class="col-md-12">

                                <h3> Post Images</h3>
                                <code> Select the Image to upload </code>

                                @if($post->post_images->count() > 0)
                                    @foreach($post->post_images as $post_image)
                                        <div class="col-xs-12 col-sm-6 col-md-6 ">
                                            <div class="col-md-12 ">
                                                <img src="{{ url('images/'.$post_image->image_url)}}"
                                                     class="img-responsive">
                                            </div>
                                            <div class="col-md-12 ">
                                                <input type="checkbox" class="form-control"
                                                       onchange="form_image_select('{{ url('images/'.$post_image->image_url)}}')">

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


                                                <input type="checkbox" class="form-control"
                                                       onchange="form_video_select('{{ url('videos/'.$post_vid->video_url)}}')">


                                            </div>
                                        </div>

                                    @endforeach
                                @else
                                    <div class="alert alert-info"> No video attached to this post</div>
                                @endif
                            </div>

                        </div>

                        <button class="btn btn-lg btn-success pull-right" onclick="form_submit()"> Post</button>

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
