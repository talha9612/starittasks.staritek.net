<!doctype html>
<html lang="en" dir="ltr">

<!-- soccer/project/login.html  07 Jan 2020 03:42:43 GMT -->
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="icon" href="#" type="image/x-icon"/>

<title>:: Login :: </title>

<!-- Bootstrap Core and vandor -->
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" />

<!-- Core css -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}"/>
<link rel="stylesheet" href="{{ asset('assets/css/theme1.css') }}"/>
<style>
    .auth .auth_left{
        width:400px;
    }
    .auth .auth_left .card{
        right: -200px;
    }
    .auth .auth_right{
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
                <img src="" width="70" style="border-radius:50px "/>
            </div>
            <form method="POST" action="{{ route('login') }}">
                        @csrf
            <div class="card-body">
                <div class="card-title">Login to your account</div>
                <!-- <div class="form-group">
                    <select class="custom-select">
                        <option>Project Manager</option>
                        <option>Team Leader</option>
                        <option>Employee</option>
                    </select>
                </div> -->
                <div class="form-group">
                    <!-- <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"> -->
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Password<a href="forgot-password.html" class="float-right small">I forgot password</a></label>
                    <!-- <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"> -->
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
                   <a href="/register-company" class="btn btn-danger btn-block " style="color:white;">Registered Your Company</a></br> Powered By StarAutomation
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

<!-- soccer/project/login.html  07 Jan 2020 03:42:43 GMT -->
</html>