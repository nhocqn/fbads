@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">facebook_post {{ $facebook_post->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/facebook_posts') }}" title="Back">
                            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>
                        <a href="{{ url('/facebook_posts/' . $facebook_post->id . '/edit') }}"
                           title="Edit facebook_post">
                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                      aria-hidden="true"></i> Edit
                            </button>
                        </a>

                        <form method="POST" action="{{ url('facebook_posts' . '/' . $facebook_post->id) }}"
                              accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete facebook_post"
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
                                    <td>{{ $facebook_post->id }}</td>
                                </tr>
                                <tr>
                                    <th> Facebook Post Id</th>
                                    <td> {{ $facebook_post->facebook_post_id }} </td>
                                </tr>
                                <tr>
                                    <th> Facebook Post Type</th>
                                    <td> {{ getPostType($facebook_post->type) }} </td>
                                </tr>
                                <tr>
                                    <th> Facebook Page Id</th>
                                    <td> {{ $facebook_post->page_id }} </td>
                                </tr>
                                <tr>
                                    <th> Created At</th>
                                    <td> {{ $facebook_post->created_at }} </td>
                                </tr>
                                <tr>
                                    <th> Updated At</th>
                                    <td> {{ $facebook_post->updated_at }} </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        @if($facebook_post->type == 1)
                            <button class="btn btn-success btn-sm col-md-3 m-sm"
                                    onclick="loadJsonFb('{{$facebook_post->facebook_post_id }}', '0')">
                                Load Image From Facebook
                            </button>
                        @endif
                        @if($facebook_post->type == 0)
                            <button class="btn btn-success btn-sm col-md-3 m-sm"
                                    onclick="loadJsonFb('{{$facebook_post->facebook_post_id }}','1')">
                                Load Feed From Facebook
                            </button>
                        @endif
                        @if($facebook_post->type == 2)

                            <button class="btn btn-success btn-sm col-md-3 m-sm"
                                    onclick="loadJsonFb('{{$facebook_post->facebook_post_id }}','2')">
                                Load Video From Facebook
                            </button>
                        @endif

                        <br> <br>
                        <br> <br>
                        <div class="table-responsive  image">

                        </div>
                        <br> <br>
                        <div class="table-responsive feed">

                        </div>
                        <br> <br>
                        <div class="table-responsive video">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>

    <script>
        function output(inp, flag) {
            if (flag == 0) {
                $('.image').html("<b> Image :</b> <br />" + inp);
            } else if (flag == 1) {
                $('.feed').html("<b> Feed :</b> <br />" + inp);
            } else {
                $('.video').html("<b> Video :</b> <br />" + inp);
            }
        }

        function syntaxHighlight(json) {
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                var cls = 'number';
                var gra = '';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                        gra = '<br/>';
                    } else {
                        gra = '';
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                    gra = '';
                } else if (/null/.test(match)) {
                    cls = 'null';
                    gra = '';
                }
                return gra + '<span class="' + cls + '">' + match + '</span>';
            });
        }


        function loadJsonFb(fb_post_id, flag) {
            if (flag == 0) {
                var send_data = {'face_bk_id': fb_post_id, 'flag': 0};
                var url = "/facebook/load-post/image";
            } else if (flag == 1) {
                var send_data = {'face_bk_id': fb_post_id, 'flag': 1};
                var url = "/facebook/load-post/feed";
            } else {
                var send_data = {'face_bk_id': fb_post_id, 'flag': 2};
                var url = "/facebook/load-post/video";
            }

            $.ajax({
                url: url,
                data: send_data,
                cache: false,
                type: 'post',
                dataType: 'JSON',
                success: function (data) {
                    var obj = data;
                    var str = JSON.stringify(obj, undefined, 4);
                    output(syntaxHighlight(str), flag);

                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    </script>
@endsection
