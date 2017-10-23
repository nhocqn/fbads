{{--<div class="form-group {{ $errors->has('video_path') ? 'has-error' : ''}}">--}}
{{--<label for="video_path" class="col-md-4 control-label">{{ 'Video Path' }}</label>--}}
{{--<div class="col-md-6">--}}
{{--<input class="form-control" name="video_path" type="text" id="video_path"--}}
{{--value="{{ $ad_video->video_path or ''}}">--}}
{{--{!! $errors->first('video_path', '<p class="help-block">:message</p>') !!}--}}
{{--</div>--}}
{{--</div>--}}

<div class="col-md-12">
    <br/>


    <h5>Video Path</h5>
    <br/>
    <?php
    $post_videos = getAllPostVideos();
    ?>
    @if($post_videos->count() > 0)

        @foreach($post_videos as $post_vid)
            <div class="col-xs-12 col-sm-6 col-md-6 ">
                <div class="col-md-12 ">
                    @if($post_vid->is_url == "0")
                        <video width="340" height="240" controls>
                            <source src="{{ url('/videos').'/'.$post_vid->video_url }}"
                                    type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div class="video">
                            <iframe class="embed-responsive-item" width="340"
                                    height="240"
                                    {{--src="https://youtu.be/embed/HwXsFPZp3fQ"--}}
                                    src="{{yourtubeVidEmbeder($post_vid->video_url)}}"
                                    frameborder="0"
                                    allowfullscreen></iframe>
                        </div>

                    @endif
                </div>
                <div class="col-md-12 ">


                    <input type="radio" checked name="video_path" class="form-control"
                           value="{{ $post_vid->is_url > 0 ? $post_vid->video_url: url('/videos/'.$post_vid->video_url)}}">


                </div>
            </div>

        @endforeach
    @else
        <div class="alert alert-info"> No video uploaded</div>
    @endif
</div>

<div class="col-md-12">

    <h5> Thumbnail </h5>
    <code> Select the Thumbnail to upload </code><br/><br/>
    <?php
    $post_images = getAllPostImages();
    ?>
    @if($post_images->count() > 0)
        @foreach($post_images as $post_image)
            <div class="col-xs-12 col-sm-6 col-md-6 ">
                <div class="col-md-12 ">
                    <img src="{{ url('images/'.$post_image->image_url)}}"
                         class="img-responsive">
                </div>
                <div class="col-md-12 ">
                    <input type="radio" checked name="thumbnail_url"
                           class="form-control"
                           value="{{ url('/images/'.$post_image->image_url)}}">
                </div>
            </div>

        @endforeach
    @else
        <div class="alert alert-info"> No image uploaded</div>
    @endif
</div>
<div class="form-group {{ $errors->has('object_url') ? 'has-error' : ''}}">
    <label for="object_url" class="col-md-4 control-label">{{ 'Object Url (e.g your website address )' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="object_url" type="text" id="object_url"
               value="{{ $ad_video->object_url or ''}}">
        {!! $errors->first('object_url', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_creative_body') ? 'has-error' : ''}}">
    <label for="ad_creative_body" class="col-md-4 control-label">{{ 'Ad Creative Body' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="ad_creative_body" type="textarea"
                  id="ad_creative_body">{{ $ad_video->ad_creative_body or ''}}</textarea>
        {!! $errors->first('ad_creative_body', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_creative_title') ? 'has-error' : ''}}">
    <label for="ad_creative_title" class="col-md-4 control-label">{{ 'Ad Creative Title' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="ad_creative_title" type="text" id="ad_creative_title"
               value="{{ $ad_video->ad_creative_title or ''}}">
        {!! $errors->first('ad_creative_title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('ad_name') ? 'has-error' : ''}}">
    <label for="ad_name" class="col-md-4 control-label">{{ 'Ad Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="ad_name" type="text" id="ad_name" value="{{ $ad_video->ad_name or ''}}">
        {!! $errors->first('ad_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('page_id') ? 'has-error' : ''}}">
    <label for="page_id" class="col-md-4 control-label">{{ 'Page ID' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="page_id" type="text" id="page_id" value="{{ $ad_video->page_id or ''}}">
        {!! $errors->first('page_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
 


<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
