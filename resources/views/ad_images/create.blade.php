@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New ad_image</div>
                    <div class="panel-body">
                        <a href="{{ url('/ad_images') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @include('errors.showerrors')

                        <form method="POST" action="{{ url('/ad_images') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('ad_images.form')

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
