<?php
include_once 'db.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dronecare</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="node_modules/admin-lte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/datatables.net-dt/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-buttons-dt/css/buttons.dataTables.css">

</head>

<body class="login-page" style="min-height: 466px;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="dronecare.jpg" alt="Logo" class="header-logo img-fluid" style="max-height: 100px;">
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="login-form" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <?php include_once 'templates/footer.php'; ?>

        <script>
            $(document).ready(function() {
                $('#login-form').submit(function(event) {
                    event.preventDefault(); // prevent form from submitting normally

                    var email = $('#email').val();
                    var password = $('#password').val();

                    // make AJAX call to login script
                    $.ajax({
                        type: 'POST',
                        url: 'ajax/login_controller.php',
                        data: {
                            email: email,
                            password: password
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response)
                            console.log(response + '?')
                            // handle response from server
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Login successful',
                                    showConfirmButton: false,
                                    timer: 3000 // 3 seconds
                                }).then(function() {
                                    window.location.href = 'users.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // show error message
                            swal('Error', 'An error occurred while processing your request', 'error');
                        }
                    });
                });
            });
        </script>