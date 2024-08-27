<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="#" type="image/x-icon" />
    <title>:: Login :: </title>

    <!-- Bootstrap Core and vendor -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />

    <!-- Core css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme1.css') }}" />
    <style>
        .auth .auth_left {
            width: 400px;
        }

        .auth .auth_left .card {
            right: -200px;
        }

        .auth .auth_right {
            width: calc(100% - 400px);
        }

        @media screen and (max-width: 620px) {
            .auth .auth_left .card {
                right: 0px;
            }
        }
    </style>
</head>

<body class="font-montserrat" style="overflow-y:hidden !important;">

    <div class="auth">
        <div class="auth_left">
            <div class="row " style="display: flex">
                <div class="card" style="width:370px;">
                    <div class="text-center mb-2">
                        <img src="" width="70" style="border-radius:50px " />
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error:</strong>
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <div class="card-title">Login to your account</div>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </label>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <div class="text-center text-muted mt-3">
                                <a href="/register-company" class="btn btn-danger btn-block" style="color:white;">Register Your Company</a></br> Powered By StarAutomation
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="auth_right full_img"></div>
    </div>

    <script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/core.js') }}"></script>
</body>

</html>