@extends('layouts.manager.app')
@section('mytitle','Tasks')
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
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i> Tasks List</a></li>                                        
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-plus"></i> Add New Tasks</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addmembers"><i class="fa fa-plus"></i> Add Member into Project</a></li> -->
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
                                <h3 class="card-title">Tasks Summary</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Task Name</th>
                                                <th>Project</th>
                                                <th>Assigned To</th>
                                                <th>Assigned By</th>
                                                <th>Due Date</th>
                                                <th>Approved Complete Task</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($tasks as $task)
                                            <tr>
                                                <td>{{$task->id}}</td>
                                                <td>{{$task->heading}}</td>
                                                <td>{{$task->project->project_name}}</td>
                                                <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150">
                                                        @if($task->GetUsers != null)
                                                            <li><img src="{{asset('uploads/staf_images/'.$task->GetUsers->image)}}" alt="Avatar"></li>
                                                        @endif
                                                    </ul>
                                                </td>
                                                <td>{{$task->AssignBy->name}}</td>
                                                <td>{{$task->due_date}}</td>
                                                <td>
                                                    <label class="custom-switch m-0">
                                                    <input type="checkbox" value="0" class="custom-switch-input manager-task-approved" data-id="{{$task->id}}" 
                                                    data-toggle="toggle" data-onstyle="outline-success" {{$task->approved == 1? 'checked':''}}>
                                                    <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    @if($task->status ==1)
                                                    <span class="tag tag-danger">Not Started</span>
                                                    @elseif($task->status ==2)
                                                    <span class="tag tag-info">In Progress</span>
                                                    @elseif($task->status ==3)
                                                    <span class="tag tag-warning">On Hold</span>
                                                    @elseif($task->status ==4)
                                                    <span class="tag tag-success">Cancelled</span>
                                                    @else
                                                    <span class="tag tag-secondary">Completed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="/manager/edit-task" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$task->id}}">    
                                                        <button class="btn btn-primary">Edit</button>
                                                    </form>
                                                     | 
                                                    <form action="/manager/delete-task" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$task->id}}">    
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
                                        <h3 class="card-title">New Task</h3>
                                        <div class="card-options ">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/manager/add-task')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Select Projects</label>
                                                    <select class="form-control show-tick" name="project_id">
                                                        <option value="">-- Project --</option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Task Category <button type="button" class="btn btn-success btn-sm" onclick="GetCatagory()" data-toggle="modal" data-target="#addtask">Add Catagory</button></label>
                                                    <select class="form-control show_pro_cata" name="catagory">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Task Title</label>
                                                    <input type="text" name="title" class="form-control" placeholder="Task Title" required>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="datetime-local" name="start_date" data-date-autoclose="true" class="form-control" placeholder="Start date" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Due Date</label>
                                                    <input type="datetime-local" name="due_date" data-date-autoclose="true" class="form-control" placeholder="Due Date" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Assigned To</label>
                                                    <select class="form-control" name="assign_to">
                                                        @foreach($users as $user)
                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Assigned To</label>
                                                    <select class="form-control" name="status">
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
                                                    <label>Description</label>
                                                    <textarea rows="10" id="editor" name="summary" class="form-control no-resize" placeholder="Please type what you want..."></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Priority</label>
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="priority" value="1" id="flexRadioDefault1"/>
                                                        <label class="form-check-label text-danger" for="flexRadioDefault1"> High </label>
                                                        </div>
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="priority" value="2" id="flexRadioDefault2" checked="true"/>
                                                        <label class="form-check-label text-warning" style="color:#ffc107!important" for="flexRadioDefault2"> Medium </label>
                                                        </div>
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="priority" value="3" id="flexRadioDefault3"/>
                                                        <label class="form-check-label text-success" style="color:#28a745!important" for="flexRadioDefault3"> Low </label>
                                                        </div>
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
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Team Members</label>
                                                    <select class="form-control" name="user_id">
                                                       
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
                <button type="button" class="btn btn-primary" onclick="SaveCatagory()">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <script>
            $(document).ready(function(){
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
                       type:"POST",
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
                       type:"POST",
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
