<form enctype="multipart/form-data" method="post" action="/submit_profile_picture">
    {{ csrf_field() }}
    <div class="form-group">
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="mb-3">
            <input class="form-control" name="input_img" type="file" id="imageInput">
        </div>
        <div class="form-group text-end">
            <input class="btn btn-success" type="submit">
        </div>
</form>