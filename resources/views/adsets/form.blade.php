<div class="form-group {{ $errors->has('campaign_id') ? 'has-error' : ''}}">
    <label for="campaign_id" class="col-md-4 control-label">{{ 'Campaign Id' }}</label>
    <div class="col-md-6">
        <?php
        $campaigns = getAllCampaigns();
        ?>
        <select class="form-control" required name="campaign_id">
            @foreach($campaigns as $key => $campaign)
                <option value="{{$key}}">{{$campaign}}</option>
            @endforeach
        </select>

    </div>
</div>

<div class="form-group {{ $errors->has('adset_name') ? 'has-error' : ''}}">
    <label for="adset_name" class="col-md-4 control-label">{{ 'Adset Name' }}</label>
    <div class="col-md-6">

        <input class="form-control" required name="adset_name">
        {!! $errors->first('adset_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('interest_query') ? 'has-error' : ''}}">
    <label for="interest_query" class="col-md-4 control-label">{{ 'Interest Query' }}</label>
    <div class="col-md-6">

        <input class="form-control" required name="interest_query">
        {!! $errors->first('interest_query', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('bid_amount') ? 'has-error' : ''}}">
    <label for="bid_amount" class="col-md-4 control-label">{{ 'Bid Amount' }}</label>
    <div class="col-md-6">

        <input class="form-control" required name="bid_amount">
        {!! $errors->first('bid_amount', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('daily_budget') ? 'has-error' : ''}}">
    <label for="daily_budget" class="col-md-4 control-label">{{ 'Daily Budget' }}</label>
    <div class="col-md-6">

        <input class="form-control" required name="daily_budget">
        {!! $errors->first('daily_budget', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('country_digraph_array') ? 'has-error' : ''}}">
    <label for="country_digraph_array" class="col-md-4 control-label">{{ 'Country Digraph Array' }}</label>
    <div class="col-md-6">

        <select class="form-control" required multiple name="country_digraph_array[]">
            <option value="NG">NG</option>
            <option value="US">US</option>
            <option value="US">GH</option>
            <option value="US">SL</option>
            <option value="US">IN</option>
        </select>

        {!! $errors->first('country_digraph_array', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('start_time') ? 'has-error' : ''}}">
    <label for="start_time" class="col-md-4 control-label">{{ 'Start Date' }}</label>
    <div class="col-md-6">

        <input class="form-control" required name="start_time">
        {!! $errors->first('start_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('end_time') ? 'has-error' : ''}}">
    <label for="end_time" class="col-md-4 control-label">{{ 'End Date' }}</label>
    <div class="col-md-6">

        <input class="form-control" required name="end_time">
        {!! $errors->first('end_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
