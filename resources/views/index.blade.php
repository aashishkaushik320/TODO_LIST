<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
                    <div class="card-header">
                        <h3>To-Do List</h3>
                    </div>
                    <div class="card-body">
                        <form id="addtask" action="{{ route('task.add') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Task</label>
                                <div class="form-control">
                                    <input type="text" id="name" name="name" class="form-control"
                                        placeholder="Enter your task" aria-label="Enter Task">
                                    <span class="error-p text-danger" id="task_error"></span>
                                    <div class="input-group-append">
                                        <button id="addTaskBtn" type="button" class="btn btn-primary formsubmit">
                                            <i class="fas fa-plus"></i> Add Task
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="text-center mb-3">
                            <button id="showAllTasksBtn" class="btn btn-secondary showall"><i class="fas fa-list"></i> Show All
                                Tasks</button>
                        </div>
                        <div class="col-md-12" id="todo_body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            get_todo_list();

            function get_todo_list() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get_todo_list') }}",
                    dataType: "json",
                    success: function(response) {
                        $('#todo_body').html(response.html);
                    }
                });
            }
            $('.showall').on('click',function(){


                $.ajax({
                    type: "get",
                    url: "{{ route('task.showall') }}",

                    dataType: "json",
                    success: function (response) {
                        $('#todo_body').html(response.html);
                    },
                    error: function (error) {
                        alert('Something Went Wrong');
                     }
                });

            });

            $(document).on('click', '.action', function(e) {
                const type = $(this).data('type');
                const id = $(this).data('task-id');
                if(type=='delete'){
                    var text ="Are you sure to delete this?";
                }else{
                    var text ="Update task as Completed?";
                }

                Swal.fire({
                    title: text,
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('action') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                type: type,
                                id: id
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success",
                                        timer: 2000,
                                    });
                                    get_todo_list();
                                } else {
                                    Swal.fire({
                                        title: "Failed!",
                                        text: response.message,
                                        icon: "error",
                                        timer: 2000,
                                    });

                                }
                            }
                        });
                    }
                });


            });
            $('.formsubmit').on('click', function(e) {
                const form = $('#addtask');
                const task = $('#tasks').val();
                const formData = new FormData(form[0]);
                $.ajax({

                    type: form.attr("method"),
                    url: form.attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#task_error').html('');
                        $('input[name="name"]').val('');
                        Swal.fire({
                            title: 'Success!',
                            text: 'Task has been added successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            get_todo_list();
                        });

                    },
                    error: function(response) {
                        if (response.status === 422) {
                            var errors = response.responseJSON.errors;
                            // alert(errors);
                            $.each(errors, function(field, msg) {
                                $(`#${field}`).siblings('.error-p')
                                    .html(msg[0]);
                            });
                        }
                    },
                });
            });

        });
    </script>


</body>

</html>
