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
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-plus"></i> Add Team</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addceo"><i class="fa fa-plus"></i> Add CEO</a></li>
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
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <!--<th>#</th>-->
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Team Member</th>
                                                <th>Account Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <!--<td>{{$user->id}}</td>-->
                                                <td class="text-capitalize">{{$user->name}}</td>
                                                <td><img src="{{asset('uploads/staf_images/'.$user->image)}}" width="80" style="border: 1px solid lightgray; padding:5px;" alt="Avatar"></td>
                                                <td class="text-capitalize">{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
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
                                                    | <form action="/admin/delete-manager" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                        <button class="btn btn-info btn-sm">Del</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <!--<th>#</th>-->
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Email</th>
                                                <th>Phone No</th>
                                                <th>Team Member</th>
                                                <th>Account Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
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
                            </div>
                            <form class="card-body" method="post" action="{{url('/admin/add-manager')}}" enctype="multipart/form-data">
                                @csrf()
                                <div class="row clearfix">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" id="check-email" name="email" class="form-control" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group mb-3">
                                                <input type="password" name="password" id="myInput" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="Password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" onclick="myFunction()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" value="2000-01-22" name="dob" data-date-autoclose="true" class="form-control" placeholder="Date of Birth" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="">-- Gender --</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" name="department" class="form-control" placeholder="Designation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Department
                                                <button type="button" class="btn btn-success btn-sm" onclick="GetDepartment()" data-toggle="modal" data-target="#addtask">Add Department</button>
                                            </label>
                                            <select class="form-control show_department" name="department">
                                                @foreach($departments as $dep)
                                                <option value="{{$dep->id}}">{{$dep->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Skills <button type="button" class="btn btn-success btn-sm" onclick="GetSkill()" data-toggle="modal" data-target="#addskill">Add Skill</button></label>
                                            <select class="form-control show_skill" name="skill">
                                                @foreach($skills as $skill)
                                                <option value="{{$skill->id}}">{{$skill->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select class="form-control show-members" name="role">
                                                <option value="2">Manager</option>
                                                <option value="3">Worker</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 manager_value d-none">
                                        <div class="form-group">
                                            <label>Select Manager</label>
                                            <select class="form-control select-members text-capitalize" name="team_memeber">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mt-2 mb-3">
                                            <input type="file" name="image" class="dropify" required>
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
            <!-- Add CEO Form -->
            <div class="tab-pane fade" id="addceo" role="tabpanel">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Make Company CEO Account</h3>

                            </div>
                            <form class="card-body" method="post" action="{{url('/admin/add-ceo')}}" enctype="multipart/form-data">
                                @csrf()
                                <div class="row clearfix">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" id="check-email" name="email" class="form-control" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group mb-3">
                                                <input type="password" name="password" id="myInput1" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="Password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" onclick="myFunction1()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" value="2000-01-22" name="dob" data-date-autoclose="true" class="form-control" placeholder="Date of Birth" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender">
                                            <option value="">-- Gender --</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" name="department" class="form-control" placeholder="Designation" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Skills <button type="button" class="btn btn-success btn-sm" onclick="GetSkill()" data-toggle="modal" data-target="#addskill">Add Skill</button></label>
                                            <select class="form-control show_skill" name="skill">
                                                @foreach($skills as $skill)
                                                <option value="{{$skill->id}}">{{$skill->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" placeholder="Address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 manager_value d-none">
                                        <div class="form-group">
                                            <label>Select Manager</label>
                                            <select class="form-control select-members text-capitalize" name="team_memeber">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mt-2 mb-3">
                                            <input type="file" name="image" class="dropify" required>
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
            <!-- End Here Add CEO Form -->

        </div>
    </div>
</div>
<!-- Add New Department -->
<div class="modal fade" id="addtask" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add New Department</h6>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="form-group show_department_p">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" id="department_name" class="form-control" placeholder="Department Name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="target_department"><button type="submit" class="btn btn-primary" onclick="SaveDepartment()">Add</button></form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add New Skill -->
<div class="modal fade" id="addskill" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add New Skill</h6>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="form-group show_skill_p">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <input type="text" id="skill_name" class="form-control" placeholder="Skill Name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="target_category"><button type="submit" class="btn btn-primary" onclick="SaveSkill()">Add</button></form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function myFunction1() {
        var x = document.getElementById("myInput1");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    $(document).ready(function() {
        $("#target_department").submit(function(event) {
            event.preventDefault();
            $('#department_name').focus();
        });
        $("#target_category").submit(function(event) {
            event.preventDefault();
            $('#skill_name').focus();
        });
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
        GetDepartment();
        GetSkill();
        GetProjectHeads();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        // 
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/select-team-managers/',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                for (var i = 0; i < response.users.length; i++) {
                    $(".select-members").append("<option value=" + response.users[i].id + ">" + response.users[i].name + "</option>");
                }
            }
        });
    });
    $('.show-members').on('click', function() {
        var value = $('.show-members').val();
        if (value == 3) {
            $('.manager_value').removeClass('d-none');
        } else {
            $('.manager_value').addClass('d-none');
        }
    });

    function GetDepartment() {
        $(".show_department").empty();
        $(".show_department_p").empty();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/department/',
            success: function(response) {
                var count = 1;
                for (let i = 0; i < response.departments.length; i++) {
                    $(".show_department_p").append("<p id='" + response.departments[i].id + "'>" + (count + i) + ") " + response.departments[i].name + " <span style='float: right;'><button class='btn btn-danger btn-sm' onclick='DeleteDepartment(" + response.departments[i].id + ")'>X</button></span></p>");
                    $(".show_department").append("<option value=" + response.departments[i].id + ">" + (count + i) + ") " + response.departments[i].name + "</option>");
                }
            }
        });
    }

    function SaveDepartment() {
        var departmentname = $('#department_name').val(); // Assuming this is the correct ID for your input field

        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/admin/save-department', // The route to handle the department saving
            data: {
                "_token": "{{ csrf_token() }}", // Include CSRF token for security
                'departmentname': departmentname
            },
            success: function(response) {
                // Handle the response from the server
                if (response.success) {
                    GetDepartment(); // Refresh the department list
                    $('#department_name').val(''); // Clear the input field
                    $('#adddepartment').modal('hide'); // Optionally hide the modal
                } else {
                    alert(response.message); // Display any error messages
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Log any errors
            }
        });
    }


    function DeleteDepartment(id) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/delete-project-department/',
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function(response) {
                $("p[id=" + id + "]").remove();
                GetDepartment();
            }
        });
    }
    // End //
    // For Skill
    function GetSkill() {
        $(".show_skill").empty();
        $(".show_skill_p").empty();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/skill/',
            success: function(response) {
                var count = 1;
                for (let i = 0; i < response.skills.length; i++) {
                    $(".show_skill_p").append("<p id='" + response.skills[i].id + "'>" + (count + i) + ") " + response.skills[i].name + " <span style='float: right;'><button class='btn btn-danger btn-sm' onclick='DeleteSkill(" + response.skills[i].id + ")'>X</button></span></p>");
                    $(".show_skill").append("<option value=" + response.skills[i].id + ">" + (count + i) + ") " + response.skills[i].name + "</option>");
                }
            }
        });
    }

    function SaveSkill() {
        var skillname = $('#skill_name').val();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/save-skill/',
            data: {
                "_token": "{{ csrf_token() }}",
                'skillname': skillname
            },

            success: function(response) {
                GetSkill();
                $('#skill_name').val('');
            }
        });
    }

    function DeleteSkill(id) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/delete-project-skill/',
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function(response) {
                $("p[id=" + id + "]").remove();
                GetSkill();
            }
        });
    }
    // End //

    function GetProjectHeads() {
        $(".show_catagory").empty();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/prjectheads/',
            success: function(response) {
                console.log(response.users[0].name)
                var count = 1;
                for (let i = 0; i < response.users.length; i++) {
                    $(".show_pro_head").append("<option value=" + response.users[i].id + ">" + (count + i) + ") " + response.users[i].name + "</option>");
                }
            }
        })
    }
</script>
@endsection