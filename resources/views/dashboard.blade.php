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
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
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

        <table class="table table-responsive table-hovered" id="account_list">
            <thead>
                <th id="id_header">ID</th>
                <th id="name_header">Name</th>
                <th id="username_header">Username</th>
                <th>Birthday</th>
                <th id="gender_header">Gender</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($user_list as $row)
                <tr>
                    <td>{{ $row['id'] }}</td>
                    <td><img src="/images/{{ $row['profile_picture_path'] }}" ; class="mx-2 rounded-circle"
                            alt="Profile picture" style="width: 25px; height: 25px;"
                            onclick="showProfileEachUser('/images/{{ $row['profile_picture_path'] }}')">
                        {{ $row['first_name'] . " " . $row['last_name'] }}</td>
                    <td>{{ $row['username'] }}</td>
                    <td>{{ date("F j, Y", strtotime($row['b_day'])) }}</td>
                    <td>{{ $row['gender'] }}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editBtn({{$row['id']}})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteBtn({{$row['id']}})">Delete</button>
                        <button class="btn btn-info" onclick="viewBtn({{$row['id']}})">View</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Image preview</h4>
            </div>
            <div class="modal-body text-center">
                <img src="" id="imagepreview" style="width: 400px; height: 400px;">
            </div>
        </div>
    </div>
</div>


<script>
    editBtn = function (id) {
        $.ajax({
            type: "POST",
            url: "/edit",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            dataType: "html",
            beforeSend: function () {
                $("#modal_title").html('Edit user');
                $("#getModal").modal("show");
                $("#modal_body").addClass('h-100');
            },
            success: function (response) {
                $("#modal_body").html(response);
            }
        })
    }

    deleteBtn = function (id) {
        $.ajax({
            type: "POST",
            url: "/delete",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            dataType: "html",
            beforeSend: function () {
                $("#modal_title").html('Delete user');
                $("#getModal").modal("show");
                $("#modal_body").addClass('h-100');
            },
            success: function (response) {
                $("#modal_body").html(response);
            }
        })
    }

    viewBtn = function (id) {
        $.ajax({
            type: "POST",
            url: "/preview",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            dataType: "html",
            beforeSend: function () {
                $("#modal_title").html('Preview');
                $("#getModal").modal("show");
                $("#modal_body").addClass('h-100');
            },
            success: function (response) {
                $("#modal_body").html(response);
            }
        })
    }

    showProfileEachUser = function (path) {
        $('#imagepreview').attr('src', path);
        $('#imagemodal').modal('show');
    }

    updateProfile = function (id) {
        $.ajax({
            type: "POST",
            url: "/update_profile",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            dataType: "html",
            beforeSend: function () {
                $("#modal_title").html('Update profile');
                $("#getModal").modal("show");
                $("#modal_body").addClass('h-100');
            },
            success: function (response) {
                $("#modal_body").html(response);
            }
        })
    }

    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#account_list tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('th').each(function (col) {
            $(this).hover(
                function () {
                    $(this).addClass('focus');
                },
                function () {
                    $(this).removeClass('focus');
                }
            );
            $(this).click(function () {
                if ($(this).is('.asc')) {
                    $(this).removeClass('asc');
                    $(this).addClass('desc selected');
                    sortOrder = -1;
                } else {
                    $(this).addClass('asc selected');
                    $(this).removeClass('desc');
                    sortOrder = 1;
                }
                $(this).siblings().removeClass('asc selected');
                $(this).siblings().removeClass('desc selected');
                var arrData = $('table').find('tbody >tr:has(td)').get();
                arrData.sort(function (a, b) {
                    var val1 = $(a).children('td').eq(col).text().toUpperCase();
                    var val2 = $(b).children('td').eq(col).text().toUpperCase();
                    if ($.isNumeric(val1) && $.isNumeric(val2))
                        return sortOrder == 1 ? val1 - val2 : val2 - val1;
                    else
                        return (val1 < val2) ? -sortOrder : (val1 > val2) ? sortOrder : 0;
                });
                $.each(arrData, function (index, row) {
                    $('tbody').append(row);
                });
            });
        });
    });
</script>

@endsection

@include('scripts.dashboard_script')