@extends('layouts.developer.app')
@section('content')
<div class="section-body">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="d-lg-flex justify-content-between">
                            <ul class="nav nav-tabs page-header-tab">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Company_Settings">Company</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Change_Password">Change Password </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="Company_Settings">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Company Settings</h3>
                                        <div class="card-options">
                                            {{-- <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="/admin/update-setting" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Company Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="id" type="hidden" value="{{ $setting->id }}">
                                                        <input class="form-control" name="name" type="text" value="{{ $setting->name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Contact Person</label>
                                                        <select class="form-control" name="contact_person">
                                                            <option value="">-- Select Manager --</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" <?php echo($user->id == $setting->contact_person)?'selected':'';?>>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Mobile Number <span class="text-danger">*</span></label>
                                                        <input class="form-control" name="phone" value="{{ $setting->phone }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <textarea class="form-control" name="address" placeholder="44 Shirley Ave. West Chicago, IL 60185" aria-label="With textarea">{{ $setting->address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Email <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                                            </div>
                                                            <input type="text" name="email" class="form-control" value="{{ $setting->email }}" type="email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Website Url</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fa fa-globe" aria-hidden="true"></i></span>
                                                            </div>
                                                            <input type="text" name="web_url" value="{{ $setting->web_url }}" class="form-control" placeholder="http://">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Phone Number</label>
                                                        <input class="form-control" name="mobile" value="{{ $setting->phone }}" type="text">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Fax</label>
                                                        <input class="form-control" name="fax" value="818-978-7102" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mt-2 mb-3">
                                                        <input type="file" name="logo" value="{{$setting->logo}}" class="dropify">
                                                        <label class="mt-4">Logo</label>
                                                        <img src="{{asset('uploads/company_logos/'.$setting->logo)}}" width="60">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right m-t-20">
                                                    <button type="submit" class="btn btn-primary">SAVE</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Change_Password">
                                <div class="card col-md-8">
                                    <div class="card-header">
                                        <h3 class="card-title">Change Password</h3>
                                    </div>
                                    <form method="post" action="/admin/update-password">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row clearfix">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled="" placeholder="Username">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled="" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <hr>
                                                    <h6>Change Password</h6>
                                                    <div class="form-group">
                                                        <input type="password" name="old_password" id="current-password" class="form-control" placeholder="Current Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" id="txtNewPassword" name="new_password" class="form-control" placeholder="New Password">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" id="txtConfirmPassword" name="confirm_passowrd" class="form-control" placeholder="Confirm New Password">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 m-t-20 text-right">
                                                    <button type="submit" class="btn btn-primary">SAVE</button> &nbsp;
                                                    <button type="button" class="btn btn-default">CANCEL</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $( document ).ready(function() {
                $('#txtConfirmPassword').on('keyup', function() {
                    var password = $("#txtNewPassword").val();
                    var confirmPassword = $("#txtConfirmPassword").val();
                    // console.log(password+" "+confirmPassword);
                    if (password != confirmPassword){
                        $('#txtConfirmPassword').addClass('is-invalid');
                        $('#txtConfirmPassword').removeClass('is-valid');
                    }else{
                        $('#txtConfirmPassword').addClass('is-valid');
                        $('#txtConfirmPassword').removeClass('is-invalid');
                    }
                });
                //  Check password Validation
                $('#current-password').on('keyup', function() {
                    var password = $('#current-password').val();
                    //ajax request
                    $.ajax({
                        method:'get',
                        url: "/admin/check-password",
                        data: {
                            'password' : password,
                        },
                        dataType: 'json',
                        success: function(data) {
                            if(data == 0) {
                                $('#current-password').addClass('is-invalid');
                                $('#current-password').removeClass('is-valid');
                            }
                            else {
                                $('#current-password').removeClass('is-invalid');
                                $('#current-password').addClass('is-valid');
                            }
                        },
                        error: function(data){
                            //error
                        }
                    });
                });
            });
         </script>
@endsection