<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title"  class="col-md-4 control-label">{{ 'Title' }}</label>
    <div class="col-md-6">
        <input class="form-control" required  name="title" type="text" id="title" value="{{ $post->title or ''}}">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('message') ? 'has-error' : ''}}">
    <label for="message" class="col-md-4 control-label">{{ 'Messagw' }}</label>
    <div class="col-md-6">
        <textarea required class="form-control" rows="5" name="message" type="textarea"
                  id="message">{{ $post->message or ''}}</textarea>
        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
    </div>
    <input name="user_id" value="{{ auth()->user()->id }}" class="hidden">
    <input name="pushed_to_fb" value="0" class="hidden">
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>

