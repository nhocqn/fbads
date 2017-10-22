<div class="form-group {{ $errors->has('facebook_post_id') ? 'has-error' : ''}}">
    <label for="facebook_post_id" class="col-md-4 control-label">{{ 'Facebook Post Id' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="facebook_post_id" type="text" id="facebook_post_id"
               value="{{ $facebook_post->facebook_post_id or ''}}">
        {!! $errors->first('facebook_post_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
