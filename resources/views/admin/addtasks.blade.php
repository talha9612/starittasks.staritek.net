@extends('layouts.admin.app')
@section('mytitle','add-task')
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
                                <h3 class="card-title">View All Tasks</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <!--<th>#</th>-->
                                                <th>Task Name</th>
                                                <th>Project</th>
                                                <th>Assigned To</th>
                                                {{-- <th>Assigned By</th> --}}
                                                <th>Due Date</th>
                                                <th>Task Complete</th>
                                                <th>Task Approved</th>
                                                <th>Show Task CEO</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $datas)
                                            @foreach($datas as $key=>$task)
                                            <tr>
                                                <!--<td>{{$task->id}}</td>-->
                                                {{-- <td class="task_heading_width">{{ $task->heading}}</td> --}}
                                                <td class="text-capitalize task_heading_width"><a href="javascript:void(0)" class="getmodel" data-id="{{$task->id}}" data-toggle="modal" data-target="#exampleModal"><h6 class="mb-0">{{$task->heading}}</h6></a>
                                                </td>
                                                {{-- <td>{{\Illuminate\Support\Str::limit($task->heading, 30, $end=' ...')}}</td> --}}
                                                <td>{{$task->project->project_name}}</td>
                                                <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150">
                                                        @if($task->GetUsers != null)
                                                            <li><img src="{{asset('uploads/staf_images/'.$task->GetUsers->image)}}" alt="Avatar">
                                                                <span>{{ $task->GetUsers->name }}</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                                {{-- <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150">
                                                        @if($task->AssignBy != null)
                                                            <li><img src="{{asset('uploads/staf_images/'.$task->AssignBy->image)}}" alt="Avatar">
                                                                <span> {{$task->AssignBy->name}}</span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td> --}}
                                                <td>{{$task->due_date}}</td>
                                                <td>
                                                    <div class="form-group mt-3">
                                                        <input type="radio" style="display:none;" value="{{ $task->progress }}" id="a-{{ $task->progress }}" checked>
                                                        <div class="progress" style="width: 160px">
                                                          <div class="progress-bar" style="position: relative">
                                                            @if( $task->progress == 'five')
                                                                <span style="position: absolute; left:75px;color:#292b30;">5%</span>
                                                            @elseif ($task->progress == 'twentyfive')
                                                                <span style="position: absolute; left:75px;color:#292b30;">25%</span>
                                                            @elseif ($task->progress == 'fifty')
                                                                <span style="position: absolute; left:75px;color:#292b30;">50%</span>
                                                            @elseif ($task->progress == 'seventyfive')
                                                            <span style="position: absolute; left:75px;color:#292b30;">75%</span>
                                                            @elseif ($task->progress == 'onehundred')
                                                            <span style="position: absolute; left:75px;color:#292b30;">100%</span>
                                                            @else
                                                            <span style="position: absolute; left:75px;color:#292b30;">0%</span>
                                                            @endif
                                                          </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="custom-switch m-0">
                                                    <input type="checkbox" value="0" class="custom-switch-input admin-task-approved" data-id="{{$task->id}}" 
                                                    data-toggle="toggle" data-onstyle="outline-success" {{$task->approved == 1? 'checked':''}}>
                                                    <span class="custom-switch-indicator"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-switch m-0">
                                                    <input type="checkbox" value="0" class="custom-switch-input task-shows-ceo" data-id="{{$task->id}}" 
                                                    data-toggle="toggle" data-onstyle="outline-success" {{$task->task_view_ceo == 1? 'checked':''}}>
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
                                                    <form action="/admin/edit-task" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$task->id}}">    
                                                        <button class="btn btn-primary">Edit</button>
                                                    </form>
                                                     | 
                                                    <form action="/admin/delete-task" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$task->id}}">    
                                                        <button class="btn btn-danger" onclick="archiveFunction()">Del</button>
                                                    </form>
                                                    <script>
                                                        function archiveFunction() {
                                                             event.preventDefault(); // prevent form submit
                                                             var form = event.target.form; // storing the form
                                                             Swal.fire({
                                                             title: 'Are you sure?',
                                                             text: "You won't be able to revert this!",
                                                             icon: 'warning',
                                                             showCancelButton: true,
                                                             confirmButtonColor: '#3085d6',
                                                             cancelButtonColor: '#d33',
                                                             confirmButtonText: 'Yes, delete it!'
                                                             }).then((result) => {
                                                             if (result.isConfirmed) {
                                                                 form.submit(); 
                                                                 Swal.fire(
                                                                 'Deleted!',
                                                                 'Task has been deleted.',
                                                                 'success'
                                                                 )
                                                             }
                                                             })
                                                         }
                                                     </script>
                                                </td>
                                            </tr>
                                            @endforeach
                                          @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <!--<th>#</th>-->
                                                <th>Task Name</th>
                                                <th>Project</th>
                                                <th>Assigned To</th>
                                                {{-- <th>Assigned By</th> --}}
                                                <th>Due Date</th>
                                                <th>Task Complete</th>
                                                <th>TaskApproved</th>
                                                <th>Show Task CEO</th>
                                                <th>Status</th>
                                                <th>Action</th>
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
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">New Task</h3>
                                       
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/admin/add-task')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Select Projects</label>
                                                    <select class="form-control select_project" name="project_id">
                                                        <option value="">-- Project --</option>
                                                        @foreach($projects as $datas)
                                                        @foreach($datas as $project)
                                                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                                                        @endforeach
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
                                                    <select class="form-control show_head" name="assign_to">
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Status To</label>
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
{{-- For Task Details --}}
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:1250px;" role="document">
        
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{url('/admin/single-task-model-complete/')}}" enctype="multipart/form-data">
                @csrf
            <div class="modal-body" style="background-color: #ebebeb;">
                <div class="row">
                    <div class="col-md-12 ">
                        <spane class="project-title "> Project name :- </spane></br>
                        <spane class="task-title "> Task name :- </spane></br>
                        <label class="tag tag-default task-catagory" style="border-radius: 15px;"> </label>
                        <span class="task-status" style="border-radius: 15px;"></span>
                        <span class="task-priority" style="border-radius: 15px;"></span>
                        <div class="row mt-3">
                            <div class="col-xs-6 col-md-3 font-12 m-t-10">
                                <label class="font-12" for="">Assigned To</label><br>
                                <ul class="list-unstyled d-inline team-info sm margin-0 w150">
                                    <li><img id="assign_to" src="" class="img-circle" width="25" alt=""></li>
                                </ul>
                                <p class="text-capitalize d-inline assign_to_name"></p>
                            </div>
                            <div class="col-xs-6 col-md-3 font-12 m-t-10">
                                <label class="font-12" for="">Assigned By</label><br>
                                <ul class="list-unstyled d-inline team-info sm margin-0 w150">
                                    <li><img id="assign_by" src="" class="img-circle" width="25" alt=""></li>
                                </ul>
                                <p class="text-capitalize d-inline assign_by_name"></p>
                            </div>
                            <div class="col-xs-6 col-md-3 font-12 m-t-10">
                                <label class="font-12" for="">Start Date</label><br>
                                <label class="tag tag-danger task-start-date"></label>
                            </div>
                            <div class="col-xs-6 col-md-3 font-12 m-t-10">
                                <label class="font-12" for="">Due Date</label><br>
                                <label class="tag tag-success task-due-date"></label>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="exampleInputPassword1">Description</label>
                            <input type="hidden" name="task_id" class="task-idd">
                            <textarea rows="10" id="editor" name="desc" class="form-control no-resize task-desc" placeholder="Please type what you want..."></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group mt-3">
                                <label for="screenshot">Task ScreenShot</label><br>
                                <span class="screenshots">
                                   
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-3">
                                <label for="screenshot">Task Completed</label><br>
                                <span class="check_progress">

                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="background: aliceblue;">
                                <div class="float-right form-group mt-3">
                                    <button type="submit" class="btn btn-danger" >Update Task</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <h3 class="m-4">Task History</h3>
                                <ul class="new_timeline">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

</div>
{{-- ----------- --}}
        <script>
        $('.getmodel').on('click',function(){
            var task_id = $(this).data('id');
            $('.task-start-date').empty();
            $('.task-due-date').empty();
            $('.task-catagory').empty();
            $('.task-title').empty();
            $('.project-title').empty();
            $('.task-priority').empty();
            $('.task-status').empty();
            $(".check_progress").empty();
            $('.screenshots').empty();
            $(".new_timeline").empty();
            $("#editor").empty();
            $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:'/admin/single-task-model/',
                    data:{
                        "_token": $('#csrf-token')[0],
                        'task_id':task_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(response){
                        
                        var regex = /(<([^>]+)>)/ig;
                        var rehtml = response.data.description.replace(/(<([^>]+)>)/gi, "");
                        var progresscheck =  response.data.progress;
                        if(progresscheck == 'five'){
                            $(".check_progress").append("<input type='radio' style='display:none;' value='five' id='a-five' checked><div class='progress'><div class='progress-bar' style='position: relative'><span style='position: absolute; left:105px;color:#292b30;'>5%</span></div></div>");
                        }else if(progresscheck == 'twentyfive'){
                            $('.check_progress').append("<input type='radio' style='display:none;' value='twentyfive' id='a-twentyfive' checked><div class='progress'><div class='progress-bar' style='position: relative'><span style='position: absolute; left:105px;color:#292b30;'>25%</span></div></div>");
                        }else if(progresscheck == 'fifty'){
                            $('.check_progress').append("<input type='radio' style='display:none;' value='fifty' id='a-fifty' checked><div class='progress'><div class='progress-bar' style='position: relative'><span style='position: absolute; left:105px;color:#292b30;'>50%</span></div></div>");
                        }else if(progresscheck == 'seventyfive'){
                            $('.check_progress').append("<input type='radio' style='display:none;' value='seventyfive' id='a-seventyfive' checked><div class='progress'><div class='progress-bar' style='position: relative'><span style='position: absolute; left:105px;color:#292b30;'>75%</span></div></div>");
                        }else if(progresscheck == 'onehundred'){
                            $('.check_progress').append("<input type='radio' style='display:none;' value='onehundred' id='a-onehundred' checked><div class='progress'><div class='progress-bar' style='position: relative'><span style='position: absolute; left:105px;color:#292b30;'>100%</span></div></div>");
                        }else if(progresscheck == null){
                            $('.check_progress').append("<input type='radio' style='display:none;' value='0' id='a-0' checked><div class='progress'><div class='progress-bar' style='position: relative'><span style='position: absolute; left:105px;color:#292b30;'>0%</span></div></div>");
                        }
                        $('.task-desc').text(rehtml.replace(/\&nbsp;/g, ''));
                        $('.task-idd').val(response.data.id);
                        $('.mark_as_complete').attr('data-id',task_id);
                        $('.task-start-date').append(response.data.start_date);
                        $('.task_id').val(response.data.id);
                        $('.task-due-date').append(response.data.due_date);
                        $("#assign_to").attr("src","/uploads/staf_images/"+response.data.assign_to.image);
                        $(".assign_to_name").text(response.data.assign_to.name);
                        $("#assign_by").attr("src","/uploads/staf_images/"+response.data.assign_by.image);
                        $(".assign_by_name").text(response.data.assign_by.name);
                        $('.task-catagory').append("Task Category > <span class='text-capitalize'>"+response.data.get_task_catagory.category_name+"</span>");
                        $('.task-title').append("<h6 class='d-inline'>Task Title : <span class='text-capitalize' style='color:#17a2b8!important'>"+response.data.heading+"</span></h6>");
                        $('.project-title').append("<h6 class='d-inline'>Project Name : <span class='text-danger text-capitalize'>"+response.data.project.project_name+"</span></h6>");
                        if(response.data.priority == 1){
                            $('.task-priority').append("<label class='tag tag-success' style='border-radius: 15px;'>Priority > High</label>");
                        }else if(response.data.priority == 2){
                            $('.task-priority').append("<label class='tag tag-warning' style='border-radius: 15px;'>Priority > Medium</label>");
                        }else if(response.data.priority == 3){
                            $('.task-priority').append("<label class='tag tag-primary' style='border-radius: 15px;'>Priority > Low</label>");
                        }
                        // For Status
                        if(response.data.status == 1){
                            $('.task-status').append("<label class='tag tag-warning' style='border-radius: 15px;'>Status > NOt Started</label>");
                        }else if(response.data.status == 2){
                            $('.task-status').append("<label class='tag tag-info' style='border-radius: 15px;'>Status > In Progress</label>");
                        }else if(response.data.status == 3){
                            $('.task-status').append("<label class='tag tag-primary' style='border-radius: 15px;'>Status > ON Hold</label>");
                        }else if(response.data.status == 4){
                            $('.task-status').append("<label class='tag tag-danger' style='border-radius: 15px;'>Status > Cancelled</label>");
                        }else if(response.data.status == 5){
                            $('.task-status').append("<label class='tag tag-success' style='border-radius: 15px;'>Status > Finished</label>");
                        }
                        var screenshots =  response.data.screen_shot;
                        var screens = $.parseJSON(screenshots);
                       if(screens == undefined){
                                $('.screenshots').append("<p>ScreenShot not Added!</p>");
                        }else{
                            for(var i=0; i<screens.length; i++){
                                $('.screenshots').append("<a href='"+window.location.origin+"/uploads/screenshots/"+screens[i]+"' target='_blank'><img src='"+window.location.origin+"/uploads/screenshots/"+screens[i]+"' width='150' class='img-thumbnail'></a>");
                            }
                        }
                          // For Histtory ////////////////////////
                          for(var i=0; i<response.activities.length; i++){
                            var name = '';
                            for(var j=0; j<response.users.length; j++)
                            {
                                if(response.users[j].id==response.activities[i].causer_id){
                                    name = response.users[j].name;
                                }
                            }
                            var historyscreenshots =  response.activities[i].properties.attributes.screen_shot;
                            var his_screens = $.parseJSON(historyscreenshots);
                            $(".new_timeline").append("<li><div class='bullet pink'></div><div class='time'>"+moment( response.activities[i].created_at).format('DD-MM-YYYY h:mm:ss a')+"<span class='tag tag-default' style='border-radius:20px;'>"+name+"</span><span>"+((response.activities[i].properties.attributes['priority']==1)?'<spane class="tag tag-success" style="border-radius:20px;">Priority:- High</spane>':'')+"</span><span>"+((response.activities[i].properties.attributes['priority']==2)?'<spane class="tag tag-default" style="border-radius:20px; background-color:#fbbd08;">Priority:- Medium</spane>':'')+"</span><span>"+((response.activities[i].properties.attributes['priority']==3)?'<spane class="tag tag-default" style="border-radius:20px; background-color:#28a745;">Priority:- Low</spane>':'')+"</span></div><div class='desc'><h3 class='text-capitalize'>"+response.activities[i].description+"</h3><h4 class='text-capitalize'>"+((JSON.stringify(response.activities[i].properties.attributes) != undefined) ? JSON.stringify(response.activities[i].properties.attributes['heading']).replace(/^"(.*)"$/, '$1') :'Not Found')+"</h4>"+((JSON.stringify(response.activities[i].properties.attributes['description'])!=undefined)?response.activities[i].properties.attributes['description']:'')+"</div>"+((historyscreenshots != null)?((his_screens[0]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[0]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[1]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[1]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[2]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[2]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[3]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[3]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[4]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[4]+"' width='150' class='img-thumbnail'/>":""):"")+"</li>");
                        }
                        // End For History /////////////////////
                    }
                });
        });



        $(document).ready(function(){
            $('#example').DataTable({
                scrollX: true,
                responsive: true
            });
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
        });
        $('.select_project').on('click',function(){
            $(".show_head").empty();
            var id = $('.select_project').val();
            $.ajax({
                    type:"GET",
                    dataType:"json",
                    url:'/admin/select-head/',
                    data:{
                    "_token": "{{ csrf_token() }}",
                    'id':id},
                    success:function(response){
                        for(var i=0; i<response.users.length; i++){
                            $(".show_head").append("<option value="+response.users[i].id+">"+response.users[i].name+"</option>");
                        }
                        
                    }
                })
        });
        // Custom function for get category
        function GetCatagory(){
                $(".show_catagory").empty();
                $(".show_pro_cata").empty();
                   $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/admin/task-catagory/',
                       success:function(response){
                        var count =1;
                        for(let i=0; i<response.catagories.length; i++){
                           $(".show_catagory").append("<p style='border-bottom: 1px solid #e5e5e5;' id='"+response.catagories[i].id+"'>"+(count+i)+") "+response.catagories[i].category_name+" <span style='float: right;margin-top:-8px'><button class='btn btn-danger btn-sm' onclick='DeleteCatagory("+response.catagories[i].id+")'>X</button></span></p>");
                           $(".show_pro_cata").append("<option value="+response.catagories[i].id+">"+(count+i)+") "+response.catagories[i].category_name+"</option>");
                       }
                       }
                   })
               }
        // Add Task Category
        function SaveCatagory(){
                var catagoryname = $('#catagory_name').val();
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/admin/add-task-catagory/',
                       data:{
                        "_token": "{{ csrf_token() }}",
                        'catagoryname':catagoryname},
                        
                       success:function(response){
                        GetCatagory();
                        $('#catagory_name').val('');
                       }
                   })
            }
            function DeleteCatagory(id){
                $.ajax({
                       type:"GET",
                       dataType:"json",
                       url:'/admin/delete-task-catagory/',
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