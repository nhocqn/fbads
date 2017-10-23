<div class="form-group {{ $errors->has('image_path') ? 'has-error' : ''}}">
    <label for="image_path" class="col-md-4 control-label">{{ 'Image Path' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="image_path" type="text" id="image_path"
               value="{{ $ad_image->image_path or ''}}">
        {!! $errors->first('image_path', '<p class="help-block">:message</p>') !!}
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
<div class="form-group {{ $errors->has('object_url') ? 'has-error' : ''}}">
    <label for="object_url" class="col-md-4 control-label">{{ 'Object Url' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="object_url" type="text" id="object_url"
               value="{{ $ad_image->object_url or ''}}">
        {!! $errors->first('object_url', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_creative_body') ? 'has-error' : ''}}">
    <label for="ad_creative_body" class="col-md-4 control-label">{{ 'Ad Creative Body' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="ad_creative_body" type="textarea"
                  id="ad_creative_body">{{ $ad_image->ad_creative_body or ''}}</textarea>
        {!! $errors->first('ad_creative_body', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_creative_title') ? 'has-error' : ''}}">
    <label for="ad_creative_title" class="col-md-4 control-label">{{ 'Ad Creative Title' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="ad_creative_title" type="text" id="ad_creative_title"
               value="{{ $ad_image->ad_creative_title or ''}}">
        {!! $errors->first('ad_creative_title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_name') ? 'has-error' : ''}}">
    <label for="ad_name" class="col-md-4 control-label">{{ 'Ad Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="ad_name" type="text" id="ad_name" value="{{ $ad_image->ad_name or ''}}">
        {!! $errors->first('ad_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
