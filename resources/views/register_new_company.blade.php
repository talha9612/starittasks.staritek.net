<!doctype html>
<html lang="en" dir="ltr">

<!-- soccer/project/register.html  07 Jan 2020 03:42:43 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('login.png') }}" type="image/x-icon" />

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
            <form action="add-company" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    @include('layouts.flashmsg')
                    <div class="text-center">
                        <!-- <img src="{{asset('logo.png')}}" width="100"/> -->
                    </div>
                    <div class="card-body">
                        <div class="card-title text-center">
                            <h5>Welcome to TaskManager</h5>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $name }}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control" value="{{ $email }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="c_name" class="form-control" value="{{ $c_name }}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Phone</label>
                                <input type="text" name="c_phone" class="form-control" value="{{ $c_phone }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $address }}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Company Logo</label>
                                <input type="hidden" name="c_image" class="form-control" value="{{ $c_image }}" readonly>
                                <!-- Display the logo preview -->
                                <div class="text-center">
                                    @if ($c_image)
                                        <img src="{{ asset($c_image) }}" alt="Company Logo" class="img-thumbnail" style="max-width: 150px;">
                                    @else
                                        <p>No logo uploaded.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Confirmation Code</label>
                                <input type="text" name="con_code" class="form-control" placeholder="Confirmation Code">
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block">Create New Company Account</button>
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
    <script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/core.js') }}"></script>

</body>

<!-- soccer/project/register.html  07 Jan 2020 03:42:43 GMT -->

</html>
