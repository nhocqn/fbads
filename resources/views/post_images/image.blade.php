<form action="{{ url('post/add-image') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-6">
        <input name="image" required type="file" class="image">
    </div>
    <input name="user_id" value="{{ auth()->user()->id }}" class="hidden">
    <input name="post_id" value="{{  $post->id or "" }}" class="hidden">
    <div class="col-md-4">
        <input type="submit" class="btn btn-sm btn-default" value="Add A Video to the Post">
    </div>

</form>