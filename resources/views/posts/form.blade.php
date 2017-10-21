<div class="form-group {{ $errors->has('created_at') ? 'has-error' : ''}}">
    <label for="created_at" class="col-md-4 control-label">{{ 'Created At' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="created_at" type="text" id="created_at" value="{{ $post->created_at or ''}}" >
        {!! $errors->first('created_at', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('updated_at') ? 'has-error' : ''}}">
    <label for="updated_at" class="col-md-4 control-label">{{ 'Updated At' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="updated_at" type="textarea" id="updated_at" >{{ $post->updated_at or ''}}</textarea>
        {!! $errors->first('updated_at', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
