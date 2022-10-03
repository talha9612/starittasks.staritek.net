@extends('layouts.manager.app')
@section('mytitle','Projects')
@section('content')
<style>
 .ck.ck-editor__main .ck-content {
  height: 239px;
}
</style>
<div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between mb-2">
                                    <ul class="nav nav-tabs b-none">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i> Project List</a></li>                                        
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-plus"></i> Add Project</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addmembers"><i class="fa fa-plus"></i> Add Member into Project</a></li>
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
                                <h3 class="card-title">Project Summary</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project</th>
                                                <th>Project Head</th>
                                                <th>Project Team</th>
                                                <th>Start Date</th>
                                                <th>Last Date</th>
                                                <th>Project Catagory</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $key=>$project)
                                                <tr>
                                                    <td>{{$project->id}}</td>
                                                    <td>
                                                        <form method="post" action="/manager/projectdetails" id="my_form_{{ $project->id }}">
                                                            @csrf
                                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                            <a href="javascript:{}" onclick="document.getElementById('my_form_{{ $project->id }}').submit();"><b>{{ $project->project_name}}</b></a>
                                                        </form>
                                                    </td>
                                                    <td>{{$project->head['name']}}</td>
                                                    <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150">
                                                        @foreach($assigns as $assign)
                                                            @if($project->id == $assign->project_id)
                                                                <li><img src="{{asset('uploads/staf_images/'.$assign->GetUsers->image)}}" alt="Avatar"></li>
                                                            @else
                                                               
                                                            @endif
                                                        @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>{{$project->start_date}}</td>
                                                    <td>{{$project->deadline}}</td>
                                                    <td>{{$project->projectcatagory->name}}</td>
                                                    <td>
                                                    @if($project->status == 1)
                                                    <label class="tag tag-yellow">Not Started</label>
                                                    @elseif($project->status == 2)
                                                    <label class="tag tag-blue">In Progress</label>
                                                    @elseif($project->status == 3)
                                                    <label class="tag tag-info">Hold On</label>
                                                    @elseif($project->status == 4)
                                                    <label class="tag tag-green">Cancelled</label>
                                                    @elseif($project->status == 5)
                                                    <label class="tag tag-red">Finished</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="/manager/project-edit" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$project->id}}">    
                                                        <button class="btn btn-primary">Edit</button>
                                                    </form>
                                                     | 
                                                     <form action="/manager/project-delete" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$project->id}}">    
                                                        <button class="btn btn-danger">Del</button>
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
                                        <h3 class="card-title">Add Project</h3>
                                       
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/manager/add-project')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Project Name</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Project Catagory <button type="button" class="btn btn-success btn-sm" onclick="GetCatagory()" data-toggle="modal" data-target="#addtask">Add Catagory</button></label>
                                                    <select class="form-control show_pro_cata" name="catagory">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="datetime-local" name="start_date" data-date-autoclose="true" class="form-control" placeholder="Date of Birth" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label>Deadline</label>
                                                    <input type="datetime-local" name="end_date" data-date-autoclose="true" class="form-control" placeholder="Date of Birth" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label>Project Head</label>
                                                    <select class="form-control" name="head" required>
                                                        <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label>Project Status</label>
                                                    <select class="form-control show-tick" name="status">
                                                        <option value="1">Not Started</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="3">On Hold</option>
                                                        <option value="4">Cancelled</option>
                                                        <option value="5">Finished</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mt-3">
                                                    <label>Project Summary</label>
                                                    <textarea rows="10" id="editor" name="summary" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
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
                    <!-- For Add Member Into Project -->
                    <div class="tab-pane fade" id="addmembers" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Members</h3>
                                       
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/manager/assign-project')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Project Name</label>
                                                    <select class="form-control" name="project_id">
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Team Members</label>
                                                    <select class="form-control" name="user_id">
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
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
                    <!-- Here End For Add Member Into Project -->
                </div>
            </div>
        </div>
        <!-- Add New Task -->
<div class="modal fade" id="addtask" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="title" id="defaultModalLabel">Add New Category</h6>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                <div class="col-12">
                        <div class="form-group show_catagory">                                    
                            <p></p>
                        </div>
                    </div>    
                <div class="col-12">
                        <div class="form-group">
                            <input type="text" id="catagory_name" class="form-control" placeholder="Catagory Name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="target_category"><button type="submit" class="btn btn-primary" onclick="SaveCatagory()">Add</button></form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <script>
            $(document).ready(function(){
                $( "#target_category" ).submit(function( event ) {
                    event.preventDefault();
                    $('#catagory_name').focus();
                });
                ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
                GetCatagory();
                GetProjectHeads();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
            });
            function GetCatagory(){
                $(".show_catagory").empty();
                $(".show_pro_cata").empty();
                   $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/catagory/',
                       success:function(response){
                        var count =1;
                        for(let i=0; i<response.catagories.length; i++){
                           $(".show_catagory").append("<p id='"+response.catagories[i].id+"'>"+(count+i)+") "+response.catagories[i].name+" <span style='float: right;'><button class='btn btn-danger btn-sm' onclick='DeleteCatagory("+response.catagories[i].id+")'>X</button></span></p>");
                           $(".show_pro_cata").append("<option value="+response.catagories[i].id+">"+(count+i)+") "+response.catagories[i].name+"</option>");
                       }
                       }
                   });
               }
            function SaveCatagory(){
                var catagoryname = $('#catagory_name').val();
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/save-catagory/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'catagoryname':catagoryname},
                        
                       success:function(response){
                        GetCatagory();
                        $('#catagory_name').val('');
                       }
                   })
            }
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
            function DeleteCatagory(id){
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/manager/delete-project-catagory/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'id':id},
                       success:function(response){
                        $("p[id="+id+"]").remove();
                       }
                   });
            }
        </script>
        @endsection
