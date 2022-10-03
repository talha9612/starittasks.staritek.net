@extends('layouts.user.app')
@section('mytitle','ViewProjectDetails')
@section('content')
<style>
 .ck.ck-editor__main .ck-content {
  height: 239px;
}
</style>
        <div class="section-body mt-3">
            <div class="container-fluid">
            
                <div class="row clearfix row-deck">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Days Left</h3>
                            </div>
                            <div class="card-body">
                                <span class="float-left"><i class="fa fa-clock-o" style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$left_days}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pending Tasks</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-file" style="font-size: 40px;color:#ff9800bf" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$assign_task}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Complete Task</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-check-square-o" style="font-size: 40px;color:#4caf50;" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$complete_task}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
<div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between mb-2">
                                    <ul class="nav nav-tabs b-none">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i> Project OverView</a></li>                                        
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-plus"></i> Members</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addmembers"><i class="fa fa-plus"></i> Tasks</a></li>
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
                                        <h3 class="card-title">Project #{{$project->id}} - {{$project->project_name}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-3">Description</h6>
                                    {{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($project->project_summary)))))), 40)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="addnew" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12 col-md-10">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Project Menbers</h3>
                                    </div>
                                    <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assign_tables as $key=>$assign_table)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td><img src="{{asset('uploads/staf_images/'.$assign_table->GetUsers->image)}}" alt="Avatar" style="width:100px;padding:5px;border:1px solid black; border-radius:50px;"></td>
                                                    <td><h6>{{$assign_table->GetUsers->name}}</h6>
                                                            @foreach($skills as $skill)
                                                                @if($assign_table->GetUsers->skill == $skill->id)
                                                                <span>{{$skill->name}}</span>
                                                                @endif
                                                            @endforeach
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
                    <!-- For Add Member Into Project -->
                    <div class="tab-pane fade" id="addmembers" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Project Tasks</h3>
                                       
                                    </div>
                                    <div class="card-body" >
                                    <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Task</th>
                                                <th>Project</th>
                                                <th>Assign To</th>
                                                <th>Assign By</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($tasks as $task)
                                          
                                            <tr>
                                                <td>{{$task->id}}</td>
                                                <td class="text-capitalize"><h6 class="mb-0 text-dark">{{$task->heading}}</h6>
                                                    {{-- <span>{{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($task->description)))))), 40)}}</span> --}}
                                                </td>
                                                <td class="text-capitalize">
                                                       {{$task->project->project_name}}
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled d-inline team-info sm margin-0 w150">   
                                                        <li><img src="{{asset('uploads/staf_images/'.$task->AssignTo->image)}}" alt="Avatar"></li>
                                                    </ul>
                                                    <p class="text-capitalize d-inline">{{$task->AssignTo->name}}</p> 
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled d-inline team-info sm margin-0 w150">   
                                                        <li><img src="{{asset('uploads/staf_images/'.$task->AssignBy->image)}}" alt="Avatar"></li>
                                                    </ul>
                                                    <p class="text-capitalize d-inline">{{$task->AssignBy->name}}</p>
                                                </td>
                                                <td>{{$task->due_date}}</td>
                                                <td>
                                                    @if($task->status == 1)
                                                    <label class="tag tag-yellow">Not Started</label>
                                                    @elseif($task->status == 2)
                                                    <label class="tag tag-blue">In Progress</label>
                                                    @elseif($task->status == 3)
                                                    <label class="tag tag-info">Hold On</label>
                                                    @elseif($task->status == 4)
                                                    <label class="tag tag-green">Cancelled</label>
                                                    @elseif($task->status == 5)
                                                    <label class="tag tag-red">Finished</label>
                                                    @endif
                                                </td>
                                            </tr>
                                          
                                           @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                    </d>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- Here End For Add Member Into Project -->
                </div>
            </div>
        </div>
          <!-- Modal -->
       
<div class="modal fade bd-example-modal-lg" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color: #ebebeb;">
                <!-- <a href="javascript:void(0)" class="btn btn-danger mb-3 mark_as_complete" >Mark As Complete</a></br> -->
                <spane class="task-title "> Task name :- </spane></br>
                <spane class="project-title "> Project name :- </spane></br>
                <label class="tag tag-default task-catagory" style="border-radius: 15px;">Task Category > </label>
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
                    <textarea class="form-control task-desc"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
        $.ajax({
                type:"POST",
                dataType:"json",
                url:'/user/single-task-model/',
                data:{
                    "_token": "{{ csrf_token() }}",
                    'task_id':task_id
                },
                success:function(response){
                    console.log(response);
                    var regex = /(<([^>]+)>)/ig;
                    var rehtml = response.data.description.replace(/(<([^>]+)>)/gi, "");
                    $('.task-desc').text(rehtml.replace(/\&nbsp;/g, ''));
                    $('.task-start-date').append(response.data.start_date);
                    $('.task-due-date').append(response.data.due_date);
                    $("#assign_to").attr("src","/uploads/staf_images/"+response.data.assign_to.image);
                    $(".assign_to_name").text(response.data.assign_to.name);
                    $("#assign_by").attr("src","/uploads/staf_images/"+response.data.assign_by.image);
                    $(".assign_by_name").text(response.data.assign_by.name);
                    $('.task-catagory').append(response.data.get_task_catagory.category_name);
                    $('.task-title').append("<h6 class='d-inline'>"+response.data.heading+"</h6>");
                    $('.project-title').append("<h6 class='d-inline'>"+response.data.project.project_name+"</h6>");
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
                }
            });
    });
    $('.mark_as_complete').on('click',function(){
        var task_id = $(this).data('id');
        $.ajax({
                type:"POST",
                dataType:"json",
                url:'/user/single-task-model-complete/',
                data:{
                    "_token": "{{ csrf_token() }}",
                    'task_id':task_id
                },
                success:function(response){

                }
            });
    });

</script>
        @endsection
