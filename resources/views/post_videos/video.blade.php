<form action="{{ url('post/add-video') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-6">
        <input name="video" required type="file" class="video">
    </div>
    <input name="user_id" value="{{ auth()->user()->id }}" class="hidden">
    <input name="post_id" value="{{  $post->id or "" }}" class="hidden">
    <div class="col-md-4">
        <input type="submit" class="btn btn-sm btn-default" value="Add Video to the Post">
    </div>

</form>

