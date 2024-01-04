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

    getTable = function (keyword, gender, b_day) {
        $.ajax({
            type: "POST",
            url: "/search_employee",
            data: {
                "_token": "{{ csrf_token() }}",
                "keyword": keyword,
                "gender": gender,
                "b_day": b_day
            },
            dataType: "html",
            beforeSend: function () {
                $('#dashboard_tbl').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div></div>');
            },
            success: function (response) {
                $('#dashboard_tbl').html(response);
            }
        })
    }

    $(document).ready(function () {
        getTable();

        $("#myInput").on("keyup", function () {
            getTable($(this).val(), $("#sort_gender").val(), $("#b_day_sort").val());
        });

        $("#sort_gender").on("change", function () {
            getTable($("#myInput").val(), $(this).val(), $("#b_day_sort").val());
        });

        $("#b_day_sort").on("change", function () {
            getTable($("#myInput").val(), $("#sort_gender").val(), $(this).val());
        });
    });
</script>