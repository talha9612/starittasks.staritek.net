<!doctype html>
<html lang="en" dir="ltr">

<!-- soccer/project/register.html  07 Jan 2020 03:42:43 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{asset('logo.png')}}" type="image/x-icon" />

    <title>TaskManager::Register</title>

    <!-- Bootstrap Core and vandor -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />

    <!-- Core css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme1.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body class="font-montserrat">

    <div class="auth">
        <div class="auth_left">
            <form method="post" action="add-company" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    @include('layouts.flashmsg')
                    <div class="text-center">
                        <!--<img src="{{asset('logo.png')}}" width="100"/>-->
                    </div>
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h5>Register New Company</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Email address</label>
                                <input type="email" id="check-email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter address" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="c_name" class="form-control" placeholder="Company Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Email</label>
                                <input type="email" name="c_email" class="form-control" placeholder="Enter address" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Phone</label>
                                <input type="text" name="c_phone" class="form-control" placeholder="Company Phone Number" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Logo</label>
                                <input type="file" name="c_image" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Confirmation Code</label>
                                <input type="text" name="con_code" class="form-control" placeholder="Comfirmation Code">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <button type="button" class="btn btn-info mt-2" id="generate-code-btn">Get Confirmation Code</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" />
                                <span class="custom-control-label">Agree the <a href="#">terms and policy</a></span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Create new Company account</button>
                        </div>
                    </div>
                    <div class="text-center text-muted">
                        <a href="/" class="btn btn-danger mb-3">Back To Login</a>
                    </div>
                    <div class="text-center text-muted">
                        Powered By StarAutomation
                    </div>
                </div>
            </form>
        </div>
        <div class="auth_right full_img"></div>
    </div>
    <script>
        $(document).ready(function() {
            //  Check Email Validation

            $('#check-email').on('keyup', function() {
                var email = $('#check-email').val();
                //ajax request
                $.ajax({
                    method: 'get',
                    url: "/checkEmail",
                    data: {
                        'email': email,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data == true) {
                            $('#check-email').addClass('is-invalid');
                            $('#check-email').removeClass('is-valid');
                        } else {
                            $('#check-email').removeClass('is-invalid');
                            $('#check-email').addClass('is-valid');
                        }
                    },
                    error: function(data) {
                        //error
                    }
                });
            });
            $('#generate-code-btn').on('click', function() {
                var email = $('input[name="email"]').val(); // Admin's email
                var devEmail = "sales@starautomation.com"; // Replace with developer's email
                var compname = $('input[name="c_name"]').val();
                var adname = $('input[name="name"]').val();
                // AJAX request to generate and send the confirmation code
                $.ajax({
                    method: 'post',
                    url: '/generateConfirmationCode', // Define this route in your web.php
                    data: {
                        _token: '{{ csrf_token() }}',
                        'email': email,
                        'dev_email': devEmail,
                        'company_name': compname, // Company name
                        'admin_name': adname,
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            $('#con_code').val(data.code); // Set the generated code in the input field
                            alert('Confirmation code sent to ' + email + ' and ' + devEmail);
                        } else {
                            alert('Failed to generate confirmation code. Please try again.');
                        }
                    },
                    error: function(data) {
                        console.error('Error:', data);
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/core.js') }}"></script>

</body>

<!-- soccer/project/register.html  07 Jan 2020 03:42:43 GMT -->

</html>