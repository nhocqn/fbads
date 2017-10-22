@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">adset {{ $adset->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/adsets') }}" title="Back">
                            <button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back
                            </button>
                        </a>
                        <a href="{{ url('/adsets/' . $adset->id . '/edit') }}" title="Edit adset">
                            <button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"
                                                                      aria-hidden="true"></i> Edit
                            </button>
                        </a>

                        <form method="POST" action="{{ url('adsets' . '/' . $adset->id) }}" accept-charset="UTF-8"
                              style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete adset"
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
                                    <td>{{ $adset->id }}</td>
                                </tr>
                                <tr>
                                    <th> Campaign Id</th>
                                    <td> {{ $adset->campaign_id }} </td>
                                </tr>
                                <tr>
                                    <th>Interest Query</th>
                                    <td>{{ $adset->interest_query }}</td>
                                </tr>
                                <tr>
                                    <th>Country Digraph</th>
                                    <td> {{ implode(',',json_decode($adset->country_digraph_array)) }} </td>
                                </tr>
                                <tr>
                                    <th>Bid Amount</th>
                                    <td>{{ $adset->bid_amount }}</td>
                                </tr>
                                <tr>
                                    <th>Daily Budget</th>
                                    <td> {{ $adset->daily_budget }} </td>
                                </tr>
                                <tr>
                                    <th>Ref</th>
                                    <td> {{ $adset->ref }} </td>
                                </tr>
                                <tr>
                                    <th>Start Time</th>
                                    <td>{{ $adset->start_time }}</td>
                                </tr>
                                <tr>
                                    <th> End Time</th>
                                    <td> {{ $adset->end_time }} </td>
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
