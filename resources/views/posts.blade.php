<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Ajax Crud App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <div class="container ">
        <div class="card mt-5 ">
            <div class="card-header">
                CRUD Application using Ajax in Laravel
            </div>
            <div class="card-body ">
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                    data-bs-target="#createPost"><i class="fa-regular fa-plus"></i> Create Post</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Body</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="postList"></tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-body-secondary" id="last-updated">
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div class="modal fade" id="createPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-create-Id">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                        </div>
                        <div class="col-md-12">
                            <label for="body" class="form-label">Body</label>
                            <textarea type="text" class="form-control" id="body" name="body" autocomplete="off"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-x"></i> Close</button>
                    <button type="button" class="btn btn-primary create-post"><i class="fa-solid fa-arrow-right-to-bracket"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Post Modal -->
    <div class="modal fade" id="editPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="post-id">
                    <form id="form-edit-Id">

                        <div class="col-md-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title-edit" name="title"
                                autocomplete="off">
                        </div>
                        <div class="col-md-12">
                            <label for="body" class="form-label">Body</label>
                            <textarea type="text" class="form-control" id="body-edit" name="body" autocomplete="off"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-x"></i> Close</button>
                    <button type="button" class="btn btn-primary update-post"><i class="fa-solid fa-arrow-right-to-bracket"></i> Update</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        $(document).ready(function() {

            // SHOW POST
            fetchPosts();

            function fetchPosts() {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "/posts",
                    success: function(response) {
                        // console.log(response);
                        let row = '';
                        $.each(response.posts, function(key, post) {
                            row += `
                        <tr>
                            <th scope="row">${post.id}</th>
                            <td>${post.title}</td>
                            <td>${post.body}</td>
                            <td>
                                <button data-id="${post.id}" class="btn btn-primary btn-sm edit-post" ><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                <button data-id="${post.id}" class="btn btn-danger btn-sm delete-post"><i class="fa-solid fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        `
                        });

                        $("#postList").html(row);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            // CREATE POST
            $(".create-post").click(function() {
                // alert("Hi, Am working!");

                const formData = {
                    title: $("#title").val(),
                    body: $("#body").val(),
                    _token: $("meta[name='csrf-token']").attr("content")
                };

                // alert(JSON.stringify(formData));

                $(".error-message").remove();

                $.ajax({
                    type: "POST",
                    url: "/posts",
                    data: formData,
                    dataType: 'json',
                    success: function(response) {

                        // alert(JSON.stringify(response));
                        if (response.errors) {
                            // alert("An Error Occurred!");
                            $.each(response.errors, function(key, value) {
                                $("#" + key).after(
                                    '<div class="text-danger error-message">' +
                                    value[0] + '</div>');
                            })
                        } else {

                            $('#createPost').find('[data-bs-dismiss="modal"]').trigger('click');
                            $('#form-create-Id')[0].reset();
                            fetchPosts();

                        }
                        // console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });



            });

            // EDIT POST
            $("body").on("click", ".edit-post", function() {
                const id = $(this).attr("data-id");
                // alert(id);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "/posts/" + id,
                    success: function(response) {
                        // console.log(response);
                        $("#post-id").val(response.post.id);
                        $("#title-edit").val(response.post.title);
                        $("#body-edit").val(response.post.body);
                        $("#editPost").modal("show");
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            // UPDATE POST
            $(".update-post").click(function() {
                // alert("Hi, Am working!");

                const formData = {
                    title: $("#title-edit").val(),
                    body: $("#body-edit").val(),
                    _token: $("meta[name='csrf-token']").attr("content")
                };

                // alert(JSON.stringify(formData));

                $(".error-message").remove();

                $.ajax({
                    type: "PUT",
                    url: "/posts/" + $("#post-id").val(),
                    data: formData,
                    dataType: 'json',
                    success: function(response) {

                        // alert(JSON.stringify(response));
                        if (response.errors) {
                            // alert("An Error Occurred!");
                            $.each(response.errors, function(key, value) {
                                $("#" + key + "-edit").after(
                                    '<div class="text-danger error-message">' +
                                    value[0] + '</div>');
                            })
                        } else {
                            $('#editPost').find('[data-bs-dismiss="modal"]').trigger('click');
                            $('#form-edit-Id')[0].reset();
                            fetchPosts();
                        }
                        // console.log(response);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });



            });

            // Delete POST
            $("body").on("click", ".delete-post", function() {
                const id = $(this).attr("data-id");

                if (confirm("Are you sure?")) {
                        $.ajax({
                            type: "DELETE",
                            dataType: "json",
                            url: "/posts/" + id,
                            data: {_token: $("meta[name='csrf-token']").attr("content")},
                            success: function(response) {
                                // console.log(response);
                                fetchPosts();
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    }
                // alert(id);

            });

        })
    </script>


</body>

</html>
