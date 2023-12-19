<form action="/edit_user" method="POST">
    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
    <input type="hidden" name="id" value="{{ $id }}">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" name="first_name" placeholder="First name"
                    value="{{ $first_name }}" autocomplete="off">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="last_name" placeholder="Last name"
                    value="{{ $last_name }}" autocomplete="off">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <select class="form-select" name="gender">
                    <option selected hidden value="{{ $gender }}">{{ $gender }}</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="date" class="form-control" name="b_day" value="{{ $b_day }}" placeholder="Birthday"
                    autocomplete="off">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <input type="text" class="form-control" name="mobile_no" placeholder="Mobile no."
                    value="{{ $mobile_no }}" autocomplete="off">
            </div>
            <div class="col-md-12 mt-3">
                <input type="text" class="form-control" name="landline" placeholder="Landline" value="{{ $landline }}"
                    autocomplete="off">
            </div>
            <div class="col-md-12 mt-3">
                <input type="text" class="form-control" name="address" placeholder="Address" value="{{ $address }}"
                    autocomplete="off">
            </div>
        </div>
        <hr>
        <p class="mt-3">
            <small>People who use our service may have uploaded your contact information to
                Facebook. <a href="#" class="text-decoration-none">Learn more.</a></small>
        </p>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-sm" style="width: 150px;"><b>Edit</b></button>
        </div>
    </div>
</form>