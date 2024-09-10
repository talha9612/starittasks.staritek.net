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
                <div class="card-body">
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label for="name" style="color: white;">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $name }}" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="email" style="color: white;">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $email }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label for="c_name" style="color: white;">Company Name</label>
                            <input type="text" name="c_name" class="form-control" value="{{ $c_name }}" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="c_phone" style="color: white;">Company Phone</label>
                            <input type="text" name="c_phone" class="form-control" value="{{ $c_phone }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label for="address" style="color: white;">Company Address</label>
                            <input type="text" name="address" class="form-control" value="{{ $address }}" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="company_logo" style="color: white;">Company Logo</label>
                            <input type="hidden" name="c_image" class="form-control" value="{{ $c_image }}" readonly>
                            <!-- Display the logo preview -->
                            <div class="text-center">
                                @if($c_image)
                                <img src="{{ asset($c_image) }}" alt="Company Logo" class="img-thumbnail" style="max-width: 150px;">
                                @else
                            </div>
                            <p>No logo uploaded.</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label" style="color: white;">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" style="color: white;">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-label" style="color: white;">Confirmation Code</label>
                        <input type="text" name="con_code" class="form-control" placeholder="Comfirmation Code">
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Create new Company account</button>
                </div>
            </form>
        </div>
        <div class="auth_right full_img"></div>
    </div>
    <script>
    </script>
    <script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/core.js') }}"></script>

</body>

<!-- soccer/project/register.html  07 Jan 2020 03:42:43 GMT -->

</html>