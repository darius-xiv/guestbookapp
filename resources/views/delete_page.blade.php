<form action="/delete_user" method="POST">
    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="form-group">
        <div class="d-block text-center">
            <h4>You are about to delete this account</h4>
            <p>Please confirm to continue</p>
        </div>
        <hr>
        <p class="mt-3">
            <small>People who use our service may have uploaded your contact information to
                Facebook. <a href="#" class="text-decoration-none">Learn more.</a></small>
        </p>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-danger btn-sm" style="width: 150px;"><b>Delete</b></button>
        </div>
    </div>
</form>