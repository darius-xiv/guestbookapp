<table class="table table-responsive table-bordered table-hover" id="account_list">
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
                <button class="btn btn-primary" onclick="editBtn({{ $row['id'] }})">Edit</button>
                <button class="btn btn-danger" onclick="deleteBtn({{ $row['id'] }})">Delete</button>
                <button class="btn btn-info" onclick="viewBtn({{ $row['id'] }})">View</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('scripts.dashboard_tbl_script')