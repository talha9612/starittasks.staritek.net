@extends('layouts.manager.app')
@section('mytitle','Users')
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
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#otherteammembers"><i class="fa fa-plus"></i>Add Other Team Users</a></li>
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
                                                        <td>
                                                            <img src="{{asset('uploads/staf_images/'.$user->image)}}" width="80" style="border: 1px solid lightgray; padding:5px;" alt="Avatar">
                                                        </td>
                                                        <td class="text-capitalize">{{$user->email}}</td>
                                                        <td>{{$user->phone}}</td>
                                                        <td class="text-capitalize">{{$user->address}}</td>
                                                        <td class="text-capitalize"> 
                                                            @if($user->role == 1)
                                                                Super Admin
                                                            @elseif($user->role == 2)
                                                                Manager
                                                            @else
                                                                User
                                                            @endif</td>
                                                        <td class="text-capitalize">{{ $user->getusers->name}}</td>
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
                                                            @if($user->team_member == Auth::user()->id)
                                                            <form action="/manager/edit-manager" method="post" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{$user->id}}">    
                                                                <button class="btn btn-primary btn-sm">Edit</button> |
                                                            </form>    
                                                            @endif
                                                              <form action="/manager/delete-manager" method="post" class="d-inline">
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
                                       
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/manager/add-user')}}" enctype="multipart/form-data">
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
                                                    <div class="input-group mb-3">
                                                        <input type="password" name="password" id="myInput" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                        <div class="input-group-append">
                                                          <span class="input-group-text" onclick="myFunction()"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="dob" value="2000-01-22" data-date-autoclose="true" class="form-control" placeholder="Date of Birth" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <label>Gender</label>
                                                <select class="form-control show-tick" name="gender" required>
                                                    <option value="">-- Gender --</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Department <button type="button" class="btn btn-success btn-sm" onclick="GetDepartment()" data-toggle="modal" data-target="#addtask">Add Department</button></label>
                                                    <select class="form-control show_department" name="department">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>Skills <button type="button" class="btn btn-success btn-sm" onclick="GetSkill()" data-toggle="modal" data-target="#addskill">Add Skill</button></label>
                                                    <select class="form-control show_skill" name="skill">
                                                       
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
                                                    <label>Role</label>
                                                    <select class="form-control show-tick" name="role">
                                                    <option value="3">My Team Member</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class=" col-md-4 col-sm-12">
                                                <label>Select Image</label>
                                                <div class="form-group mt-2 mb-3">
                                                    <input type="file" name="image" placeholder="check abid" class="dropify" required>
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
                    <div class="tab-pane fade" id="otherteammembers" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Team Member From Other Teams</h3>
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/manager/privous-add-user')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-4 col-sm-12">
                                                <label>Other Team Member List</label>
                                                <select class="form-control show-tick" name="member_id" required>
                                                    @foreach($teams as $team)
                                                        @if($team->team_member == Auth::user()->id)
                                                        @else
                                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                            <div class="col-sm-12 mt-3">
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
            function myFunction(){
                var x = document.getElementById("myInput");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
            $(document).ready(function(){
                $( "#target_department" ).submit(function( event ) {
                    event.preventDefault();
                    $('#department_name').focus();
                });
                $( "#target_category" ).submit(function( event ) {
                    event.preventDefault();
                    $('#skill_name').focus();
                });
                ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
                GetDepartment();
                GetSkill();
                GetProjectHeads();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            });
            // For Department
            function GetDepartment(){
                $(".show_department").empty();
                $(".show_department_p").empty();
                   $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/department/',
                       success:function(response){
                        var count =1;
                        for(let i=0; i<response.departments.length; i++){
                           $(".show_department_p").append("<p id='"+response.departments[i].id+"'>"+(count+i)+") "+response.departments[i].name+" <span style='float: right;'><button class='btn btn-danger btn-sm' onclick='DeleteDepartment("+response.departments[i].id+")'>X</button></span></p>");
                           $(".show_department").append("<option value="+response.departments[i].id+">"+(count+i)+") "+response.departments[i].name+"</option>");
                       }
                       }
                   });
               }
            function SaveDepartment(){
                var departmentname = $('#department_name').val();
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/save-department/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'departmentname':departmentname},
                        
                       success:function(response){
                        GetDepartment();
                        $('#department_name').val('');
                       }
                   })
            }
            function DeleteDepartment(id){
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/delete-project-department/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'id':id},
                       success:function(response){
                        $("p[id="+id+"]").remove();
                        GetDepartment();
                       }
                   });
            }
            // End //
            // For Skill
            function GetSkill(){
                $(".show_skill").empty();
                $(".show_skill_p").empty();
                   $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/skill/',
                       success:function(response){
                        var count =1;
                        for(let i=0; i<response.skills.length; i++){
                           $(".show_skill_p").append("<p id='"+response.skills[i].id+"'>"+(count+i)+") "+response.skills[i].name+" <span style='float: right;'><button class='btn btn-danger btn-sm' onclick='DeleteSkill("+response.skills[i].id+")'>X</button></span></p>");
                           $(".show_skill").append("<option value="+response.skills[i].id+">"+(count+i)+") "+response.skills[i].name+"</option>");
                       }
                       }
                   });
               }
            function SaveSkill(){
                var skillname = $('#skill_name').val();
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/save-skill/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'skillname':skillname},
                        
                       success:function(response){
                        GetSkill();
                        $('#skill_name').val('');
                       }
                   })
            }
            function DeleteSkill(id){
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/delete-project-skill/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'id':id},
                       success:function(response){
                        $("p[id="+id+"]").remove();
                        GetSkill();
                       }
                   });
            }
            // End //

            function GetProjectHeads(){
                $(".show_catagory").empty();
                   $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/prjectheads/',
                       success:function(response){
                        console.log(response.users[0].name)
                        var count =1;
                        for(let i=0; i<response.users.length; i++){
                           $(".show_pro_head").append("<option value="+response.users[i].id+">"+(count+i)+") "+response.users[i].name+"</option>");
                       }
                       }
                   })
               }
           
        </script>
@endsection