
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
