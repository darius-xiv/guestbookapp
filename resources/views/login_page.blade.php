@extends('layouts.layout')

@section('content')

<div class="container" syle="background-color: #fff;">
    <div class="row d-flex align-items-center vh-100 mx-auto" style="max-width: 1200px;">
        <div class="col">
            <h1 class="text-primary">Fakebook</h1>
            <p>Connect with friends and the world around you on Facebook.</p>
        </div>
        <div class="col text-center">
            <div class="card border-0 p-3 shadow mb-4 mx-auto" style="max-width: 360px;">
                @if ($errors->any() || session()->has('form_validation'))
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        @if (session()->has('form_validation'))
                        <li>{{ session('form_validation') }}</li>
                        @endif
                    </ul>
                </div>
                @elseif (session()->has('success'))
                <div class="alert alert-success text-start">
                    {{ session('success') }}
                </div>
                @endif

                <form action="/login" method="POST">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <input type="text" class="form-control px-3 py-2 mb-3" name="username"
                            placeholder="Email or phone number" autocomplete="off">
                        <input type="password" class="form-control px-3 py-2 mb-3" name="password"
                            placeholder="Password">
                        <button type="submit" class="btn btn-primary w-100 mb-3">Log In</button>
                        <a href="#" class="text-decoration-none"><small>Forgot password?</small></a>
                        <hr class="my-4">
                    </div>
                </form>
                <div class="d-block">
                    <button class="btn btn-success border-0 mb-2" data-bs-toggle="modal"
                        data-bs-target="#createNewAccountModal" style="background-color: #42b72a;">Create new
                        account</button>
                </div>
            </div>
            <small><a href="#" class="text-decoration-none text-dark"><b>Create a Page</b></a> for a
                celebrity, brand or business.</small>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createNewAccountModal" tabindex="-1" aria-labelledby="createNewAccountModal1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="createNewAccountModal1">Sign up</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/sign_up" method="POST">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" placeholder="First name"
                                    autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" placeholder="Last name"
                                    autocomplete="off">
                            </div>
                        </div>
                        <input type="text" class="form-control mt-3" name="username" placeholder="Username"
                            autocomplete="off">
                        <input type="password" class="form-control mt-3" name="password" placeholder="Password"
                            autocomplete="off">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <select class="form-select" name="gender">
                                    <option selected disabled hidden>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="b_day" placeholder="Birthday"
                                    autocomplete="off">
                            </div>
                        </div>
                        <hr>
                        <p class="mt-3">
                            <small>People who use our service may have uploaded your contact information to
                                Facebook. <a href="#" class="text-decoration-none">Learn more.</a></small>
                        </p>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-sm"
                                style="width: 150px; background-color: #00a400;"><b>Sign Up</b></button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection