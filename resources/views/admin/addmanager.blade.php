@extends('layouts.admin.app')
@section('mytitle','View-And-Add-Users')
@section('content')
<div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between mb-2">
                                    <ul class="nav nav-tabs b-none">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i>Company Staff List</a></li>                                        
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-plus"></i> Add New</a></li>
                                    </ul>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="container-fluid">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="list" role="tabpanel">
                    <div class="row clearfix">
                    <div class="col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">View All Users</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Address</th>
                                                <th>Role</th>
                                                <th>Team Member</th>
                                                <th>Account Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td class="text-capitalize">{{$user->name}}</td>
                                                <td><img src="{{asset('uploads/staf_images/'.$user->image)}}" width="80" style="border: 1px solid lightgray; padding:5px;" alt="Avatar"></td>
                                                <td class="text-capitalize">{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td class="text-capitalize">{{$user->address}}</td>
                                                <td> 
                                                    @if($user->role == 1)
                                                        Super Admin
                                                    @elseif($user->role == 2)
                                                        Manager
                                                    @else
                                                        User
                                                    @endif</td>
                                                <td class="text-capitalize">
                                                   {{$user->getusers->name}}
                                                </td>
                                                <td>
                                                @if($user->status == 1)
                                                
                                                <label class="custom-switch m-0">
                                                <input type="checkbox" value="0" class="custom-switch-input admin-change-status-user" data-id="{{$user->id}}" data-toggle="toggle" data-onstyle="outline-success" {{$user->status == 1? 'checked':''}}>
                                                <span class="custom-switch-indicator"></span>
                                                </label>
                                              
                                                @else
                                                <label class="custom-switch m-0">
                                                <input type="checkbox" value="0" class="custom-switch-input admin-change-status-user" data-id="{{$user->id}}" data-toggle="toggle" data-onstyle="outline-success" {{$user->status == 1? 'checked':''}}>
                                                <span class="custom-switch-indicator"></span>
                                                </label>
                                                @endif
                                               

                                                </td>
                                                <td>
                                                    <form action="/admin/edit-manager" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$user->id}}">    
                                                        <button class="btn btn-primary btn-sm">Edit</button>
                                                    </form>    
                                                    |  <form action="/admin/delete-manager" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$user->id}}">    
                                                        <button class="btn btn-info btn-sm">Del</button>
                                                    </form> 
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                    <div class="tab-pane fade" id="addnew" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Staff</h3>
                                        <div class="card-options ">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/admin/add-manager')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" name="email" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="datetime-local" name="dob" data-date-autoclose="true" class="form-control" placeholder="Date of Birth" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender" required>
                                                    <option value="">-- Gender --</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Department</label>
                                                    <select class="form-control show-tick" name="department">
                                                        @foreach($designations as $designation)
                                                            <option value="{{$designation->id}}">{{$designation->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Skills</label>
                                                    <select class="form-control show-tick" name="skill">
                                                        @foreach($skills as $skill)
                                                            <option value="{{$skill->id}}">{{$skill->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" name="phone" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" name="address" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>User Type</label>
                                                    <select class="form-control show-members" name="role" required>
                                                    <option value="">-- Role --</option>
                                                    <option value="2">Manager</option>
                                                    <option value="3">Worker</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 manager_value d-none">
                                                <div class="form-group">
                                                    <label>Select Manager</label>
                                                    <select class="form-control select-members text-capitalize" name="team_memeber" required>
                                                   
                                                </select>
                                                </div>
                                            </div>
                                          
                                            <div class="col-sm-12">
                                                <div class="form-group mt-2 mb-3">
                                                    <input type="file" name="image" class="dropify" required>
                                                    <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                                                </div>
                                            </div>
                                           
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="submit" class="btn btn-outline-secondary">Cancel</button>
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
            $(document).ready(function(){
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/admin/select-team-managers/',
                       data:{
                        "_token": "{{ csrf_token() }}"},
                       success:function(response){
                        for(var i=0; i<response.users.length; i++){
                            $(".select-members").append("<option value="+response.users[i].id+">"+response.users[i].name+"</option>");
                        }
                       }
                   })
            });
            $('.show-members').on('click',function(){
                var value = $('.show-members').val();
                if(value == 3){
                    $('.manager_value').removeClass('d-none');
                }else{
                    $('.manager_value').addClass('d-none');
                }
            });
        </script>
@endsection