@extends('layouts.manager.app')
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
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th style="border-top:none;">Company name</th>
                                                        <td style="border-top:none;">{{ ucfirst($setting->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company Email</th>
                                                        <td>{{ ucfirst($setting->email) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person</th>
                                                        
                                                        @empty($setting->ContactPerson)
                                                        <td></td>
                                                        @else
                                                        <td>{{ ucfirst($setting->ContactPerson->name) }}</td>
                                                        @endempty
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person Phone</th>
                                                        <td>{{ ucfirst($setting->phone) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Mobile</th>
                                                        <td>{{ ucfirst($setting->mobile) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>{{ ucfirst($setting->address) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>WebSite URL</th>
                                                        <td>{{ ucfirst($setting->web_url) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fax</th>
                                                        <td>{{ ucfirst($setting->fax) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Logo</th>
                                                        <td><img src="{{asset('uploads/company_logos/'.$setting->logo)}}" style="width:100px;padding:5px;border:3px solid lightgray;" alt="Avatar"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="Change_Password">
                                <div class="card col-md-8">
                                    <div class="card-header">
                                        <h3 class="card-title">Change Password</h3>
                                    </div>
                                    <form method="post" action="/manager/update-password">
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
                        url: "/manager/check-password",
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