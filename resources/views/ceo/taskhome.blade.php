@extends('layouts.ceo.app')
@section('mytitle','ViewProject')
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
                                    <table class="table table-hover table-striped table-vcenter mb-0 table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Task Name</th>
                                                <th>Project</th>
                                                <th>Assigned To</th>
                                                <th>Assigned By</th>
                                                <th>Due Date</th>
                                                <th>Task Complete</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $task)
                                            <tr>
                                                <td>{{ $task->id }}</td>
                                                {{-- <td class="task_heading_width">{{ $task->heading}}</td> --}}
                                                <td class="text-capitalize task_heading_width"><a href="javascript:void(0)" class="getmodel" data-id="{{$task->id}}" data-toggle="modal" data-target="#exampleModal"><h6 class="mb-0">{{$task->heading}}</h6></a>
                                                </td>
                                                {{-- <td>{{\Illuminate\Support\Str::limit($task->heading, 30, $end=' ...')}}</td> --}}
                                                <td>{{ $task['project']['project_name'] }}</td>
                                                <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150">
                                                        @if($task->GetUsers) <!-- Check if the relationship is not null -->
                                                        <li>
                                                            <img src="{{ asset('uploads/staf_images/'.$task->GetUsers->image) }}" alt="Avatar">
                                                            <span>{{ $task->GetUsers->name }}</span>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </td>

                                                <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150">
                                                        @if($task->AssignBy)
                                                        <li>
                                                            <img src="{{ asset('uploads/staf_images/'.$task->AssignBy->image) }}" alt="Avatar">
                                                            <span>{{ $task->AssignBy->name }}</span>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </td>
                                                <td>{{ $task['due_date'] }}</td>
                                                <td>
                                                    <div class="form-group mt-3">
                                                        <input type="radio" style="display:none;" value="{{ $task['progress'] }}" id="a-{{ $task['progress'] }}" checked>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="position: relative">
                                                                @if($task['progress'] == 'five')
                                                                <span style="position: absolute; left:105px;color:#292b30;">5%</span>
                                                                @elseif($task['progress'] == 'twentyfive')
                                                                <span style="position: absolute; left:105px;color:#292b30;">25%</span>
                                                                @elseif($task['progress'] == 'fifty')
                                                                <span style="position: absolute; left:105px;color:#292b30;">50%</span>
                                                                @elseif($task['progress'] == 'seventyfive')
                                                                <span style="position: absolute; left:105px;color:#292b30;">75%</span>
                                                                @elseif($task['progress'] == 'onehundred')
                                                                <span style="position: absolute; left:105px;color:#292b30;">100%</span>
                                                                @else
                                                                <span style="position: absolute; left:105px;color:#292b30;">0%</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($task['status'] == 1)
                                                    <span class="tag tag-danger">Not Started</span>
                                                    @elseif($task['status'] == 2)
                                                    <span class="tag tag-info">In Progress</span>
                                                    @elseif($task['status'] == 3)
                                                    <span class="tag tag-warning">On Hold</span>
                                                    @elseif($task['status'] == 4)
                                                    <span class="tag tag-success">Cancelled</span>
                                                    @else
                                                    <span class="tag tag-secondary">Completed</span>
                                                    @endif
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
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:1250px;" role="document">
        
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
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
                            <p class="form-control task-desc" name="desc"></p>
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
    </div>

</div>
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
    $.ajax({
            type:"GET",
            dataType:"json",
            url:'/ceo/single-task-model/',
            data:{
                "_token": $('#csrf-token')[0],
                'task_id':task_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response){
                if(response.data.status == 5){
                    $('.mark_complete').prop('disabled', true);
                }
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
                }
                $('.task-desc').text(rehtml.replace(/\&nbsp;/g, ''));
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
                    $(".new_timeline").append("<li><div class='bullet pink'></div><div class='time'>"+moment( response.activities[i].created_at).format('DD-MM-YYYY h:mm:ss a')+"<span class='tag tag-default' style='border-radius:20px;'>"+name+"</span><span>"+((response.activities[i].properties.attributes['priority']==1)?'<spane class="tag tag-success" style="border-radius:20px;">Priority:- High</spane>':'')+"</span><span>"+((response.activities[i].properties.attributes['priority']==2)?'<spane class="tag tag-default" style="border-radius:20px; background-color:#fbbd08;">Priority:- Medium</spane>':'')+"</span><span>"+((response.activities[i].properties.attributes['priority']==3)?'<spane class="tag tag-default" style="border-radius:20px; background-color:#28a745;">Priority:- Low</spane>':'')+"</span></div><div class='desc'><h3 class='text-capitalize'>"+response.activities[i].description+"</h3><h4 class='text-capitalize'>"+((JSON.stringify(response.activities[i].properties.attributes) != undefined) ? JSON.stringify(response.activities[i].properties.attributes['heading']).replace(/^"(.*)"$/, '$1') :'Not Found')+"</h4>"+((JSON.stringify(response.activities[i].properties.attributes['description'])!=undefined)?JSON.stringify(response.activities[i].properties.attributes['description']).replace(/^"(.*)"$/, '$1'):'')+"</div>"+((historyscreenshots != null)?((his_screens[0]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[0]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[1]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[1]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[2]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[2]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[3]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[3]+"' width='150' class='img-thumbnail'/>":"")+((his_screens[4]!=undefined)?"<img src='"+window.location.origin+"/uploads/screenshots/"+his_screens[4]+"' width='150' class='img-thumbnail'/>":""):"")+"</li>");
                }
                // End For History /////////////////////
            }
        });
});
</script>
@endsection