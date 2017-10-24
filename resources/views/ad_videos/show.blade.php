@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Ad Video : {{ $ad_video->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/ad_videos') }}" title="Back">
                            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>
                        <a href="{{ url('/ad_videos/' . $ad_video->id . '/edit') }}" title="Edit ad_video">
                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                      aria-hidden="true"></i> Edit
                            </button>
                        </a>

                        <form method="POST" action="{{ url('ad_videos' . '/' . $ad_video->id) }}" accept-charset="UTF-8"
                              style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete ad_video"
                                    onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o"
                                                                                             aria-hidden="true"></i>
                                Delete
                            </button>
                        </form>
                        <br/>
                        <br/>
                        @include('errors.showerrors')
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $ad_video->id }}</td>
                                </tr>
                                <tr>
                                    <th> Thumbnail</th>
                                    <td><img src="{{ $ad_video->thumbnail_url }}" style="width: 200px;height: 200px;" class="img-responsive"
                                             alt="video thumbnail"></td>
                                </tr>
                                <tr>
                                    <th> Object Url</th>
                                    <td> {{ $ad_video->object_url or "NA" }} </td>
                                </tr>
                                <tr>
                                    <th> Ad Creative Title</th>
                                    <td> {{ $ad_video->ad_creative_name or "NA" }} </td>
                                </tr>
                                <tr>
                                    <th> Ad Creative Body</th>
                                    <td> {{ $ad_video->ad_creative_body or "NA" }} </td>
                                </tr>
                                <tr>
                                    <th> Adset</th>
                                    <td> {{ $ad_video->adset ? $ad_video->adset->adset_name: "NA" }} </td>
                                </tr>
                                <tr>
                                    <th> Page ID</th>
                                    <td> {{ $ad_video->page_id or "NA" }} </td>
                                </tr>

                                <tr>
                                    <th> Video ID</th>
                                    <td> {{ $ad_video->video_id or "NA" }} </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
