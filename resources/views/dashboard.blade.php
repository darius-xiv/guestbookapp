@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <div class="jumbotron">
        <div class="d-block">
            <img src="/images/{{ session('profile_picture_path') }}" class="img-thumbnail d-inline "
                alt="Profile picture" style="width: 150px; height: 150px;"
                onclick="updateProfile({{ session('exist_id') }})">
            <h1 class="display-4 d-inline align-bottom">Hello, {{ session('first_name') }} {{ session('last_name') }}!
            </h1>

            <a href="/sign_out" class="btn btn-danger align-top float-end">Sign out</a>
        </div>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to
            featured content or information.</p>

        <div class="row">
            <div class="col-md-2">
                <select class="form-select" name="sort_gender" id="sort_gender">
                    <option value="" selected >All gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" name="b_day_sort" id="b_day_sort">
                    <option value="" selected disabled>Sort by birthday</option>
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>
            <div class="col-md-8">
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
            </div>
        </div>
        <hr class="my-4">

        @if ($errors->any())
        <div class="alert alert-danger text-start">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @elseif (session()->has('edit_success'))
        <div class="alert alert-success text-start">
            {{ session('edit_success') }}
        </div>
        @elseif (session()->has('edit_errors'))
        <div class="alert alert-danger text-start">
            {{ session('edit_errors') }}
        </div>
        @endif

        <div id="dashboard_tbl">
            No data was found.
        </div>
    </div>
</div>

@include('modals.dashboard_modal')
@include('scripts.dashboard_script')
@endsection