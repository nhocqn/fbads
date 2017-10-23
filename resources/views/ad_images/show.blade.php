@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">ad_image {{ $ad_image->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/ad_images') }}" title="Back">
                            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>
                        <a href="{{ url('/ad_images/' . $ad_image->id . '/edit') }}" title="Edit ad_image">
                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                      aria-hidden="true"></i> Edit
                            </button>
                        </a>

                        <form method="POST" action="{{ url('ad_images' . '/' . $ad_image->id) }}" accept-charset="UTF-8"
                              style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete ad_image"
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
                                    <td>{{ $ad_image->id }}</td>
                                </tr>
                                <tr>
                                    <th> Image Path</th>
                                    <td> {{ $ad_image->image_path }} </td>
                                </tr>
                                <tr>
                                    <th> Adset Id</th>
                                    <td> {{ $ad_image->adset_id }} </td>
                                </tr>
                                <tr>
                                    <th> Object Url</th>
                                    <td> {{ $ad_image->object_url }} </td>
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
