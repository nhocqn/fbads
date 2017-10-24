{{--<div class="form-group {{ $errors->has('video_path') ? 'has-error' : ''}}">--}}
{{--<label for="video_path" class="col-md-4 control-label">{{ 'Video Path' }}</label>--}}
{{--<div class="col-md-6">--}}
{{--<input class="form-control" name="video_path" type="text" id="video_path"--}}
{{--value="{{ $ad_video->video_path or ''}}">--}}
{{--{!! $errors->first('video_path', '<p class="help-block">:message</p>') !!}--}}
{{--</div>--}}
{{--</div>--}}

<div class="form-group {{ $errors->has('thumbnail_url') ? 'has-error' : ''}}">
    <label for="thumbnail_url"
           class="col-md-4 control-label">{{ 'Uploaded Image Source' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="thumbnail_url" type="text" id="thumbnail_url"
               value="{{ $ad_video->thumbnail_url or old('thumbnail_url')}}">
        {!! $errors->first('thumbnail_url', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('video_id') ? 'has-error' : ''}}">
    <label for="video_id"
           class="col-md-4 control-label">{{ 'Video Id (e.g  id of the video )' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="video_id" type="text" id="video_id"
               value="{{ $ad_video->video_id or old('video_id')}}">
        {!! $errors->first('video_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{{--<div class="form-group {{ $errors->has('object_url') ? 'has-error' : ''}}">--}}
    {{--<label for="object_url" class="col-md-4 control-label">{{ 'Object Url (e.g your website address )' }}</label>--}}
    {{--<div class="col-md-6">--}}
        {{--<input class="form-control" name="object_url" type="text" id="object_url"--}}
               {{--value="{{ $ad_video->object_url or old('object_url')}}">--}}
        {{--{!! $errors->first('object_url', '<p class="help-block">:message</p>') !!}--}}
    {{--</div>--}}
{{--</div>--}}
<div class="form-group {{ $errors->has('ad_creative_body') ? 'has-error' : ''}}">
    <label for="ad_creative_body" class="col-md-4 control-label">{{ 'Ad Creative Body' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="ad_creative_body" type="textarea"
                  id="ad_creative_body">{{ $ad_video->ad_creative_body or old('ad_creative_body')}}</textarea>
        {!! $errors->first('ad_creative_body', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_creative_title') ? 'has-error' : ''}}">
    <label for="ad_creative_title" class="col-md-4 control-label">{{ 'Ad Creative Title' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="ad_creative_title" type="text" id="ad_creative_title"
               value="{{ $ad_video->ad_creative_title or old('ad_creative_title')}}">
        {!! $errors->first('ad_creative_title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_name') ? 'has-error' : ''}}">
    <label for="ad_name" class="col-md-4 control-label">{{ 'Ad Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="ad_name" type="text" id="ad_name"
               value="{{ $ad_video->ad_name or old('ad_name')}}">
        {!! $errors->first('ad_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('page_id') ? 'has-error' : ''}}">
    <label for="page_id" class="col-md-4 control-label">{{ 'Page ID' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="page_id" type="text" id="page_id"
               value="{{ $ad_video->page_id or old('page_id')}}">
        {!! $errors->first('page_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('adset_id') ? 'has-error' : ''}}">
    <label for="adset_id" class="col-md-4 control-label">{{ 'Adset Id' }}</label>
    <div class="col-md-6">
        <?php
        $adsets = getAllAdsets();
        ?>
        <select class="form-control" required name="adset_id">
            @foreach($adsets as $key => $adset)
                <option value="{{$key}}">{{$adset}}</option>
            @endforeach
        </select>

    </div>
</div>


<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
