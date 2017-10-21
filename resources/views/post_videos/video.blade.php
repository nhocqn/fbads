<form action="{{ url('') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-4">
        <input name="image" type="file" class="image">
    </div>
    <input name="user_id" value="{{ auth()->user()->id }}" class="hidden">
    <input name="post_id" value="0" class="hidden">
    <div class="col-md-4">
        <input type="submit" class="btn btn-sm btn-success" value="Add A Video to the Post">
    </div>

</form>

