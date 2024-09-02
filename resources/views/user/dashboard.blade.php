@extends('layouts.user.app')
@section('mytitle','Dashboard')
@section('content')

        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <h4><i class="fa fa-address-book" aria-hidden="true"></i> Welcome <span class="text-capitalize">{{Auth::user()->name}}</span></h4>
                            <small>Measure How Fast You’re Growing Monthly Recurring Revenue. <a href="#">Learn More</a></small>
                        </div>                        
                    </div>
                </div>
                <div class="row clearfix row-deck">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Assign Projects</h3>
                            </div>
                            <div class="card-body">
                                <span class="float-left"><i class="fa fa-tasks " style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$assign_projects}}</h5>
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
        <div class="section-body">
            <div class="container-fluid">    
                <div class="row clearfix">
                    <div class="col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Task Panel</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Task</th>
                                                <th>Project</th>
                                                <th>Assign To</th>
                                                <th>Assign By</th>
                                                <th>Task Progress</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($tasks as $key=>$task)
                                            <tr>
                                                <td>{{$task->id}}</td>
                                                <td class="text-capitalize"><a href="javascript:void(0)" class="getmodel" data-id="{{$task->id}}" data-toggle="modal" data-target="#exampleModal"><h6 class="mb-0">{{$task->heading}}</h6></a>
                                                    <span>{{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($task->description)))))), 40)}}</span>
                                                </td>
                                                <td class="text-capitalize">
                                                    <form method="post" action="/user/project" id="my_form_{{$key}}">
                                                        @csrf
                                                        <input type="hidden" name="project_id" value="{{$task->project->id}}">
                                                        <a href="javascript:void(0)" onclick="document.getElementById('my_form_{{$key}}').submit();">{{$task->project->project_name}}</a>
                                                    </form>
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
                                                <td>
                                                    <div class="form-group mt-3">
                                                        <input type="radio" style="display:none;" value="{{ $task->progress }}" id="a-{{ $task->progress }}" checked>
                                                        <div class="progress">
                                                          <div class="progress-bar" style="position: relative">
                                                            @if( $task->progress == 'five')
                                                                <span style="position: absolute; left:105px;color:#292b30;">5%</span>
                                                            @elseif ($task->progress == 'twentyfive')
                                                                <span style="position: absolute; left:105px;color:#292b30;">25%</span>
                                                          @elseif ($task->progress == 'fifty')
                                                                <span style="position: absolute; left:105px;color:#292b30;">50%</span>
                                                            @elseif ($task->progress == 'seventyfive')
                                                            <span style="position: absolute; left:105px;color:#292b30;">75%</span>
                                                            @elseif ($task->progress == 'onehundred')
                                                            <span style="position: absolute; left:105px;color:#292b30;">100%</span>
                                                            @else
                                                            <span style="position: absolute; left:105px;color:#292b30;">0%</span>
                                                            @endif
                                                          </div>
                                                        </div>
                                                    </div>
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
                            </div>
                            
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Project Panel</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Project</th>
                                                <th>Manager Head</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($tasks as $key=>$task)
                                            <tr>
                                                <td>{{$task->id}}</td>
                                                <td class="text-capitalize">
                                                    <form method="post" action="/user/project" id="my_form_{{$key}}">
                                                        @csrf
                                                        <input type="hidden" name="project_id" value="{{$task->project->id}}">
                                                        <a href="javascript:void(0)" onclick="document.getElementById('my_form_{{$key}}').submit();">{{$task->project->project_name}}</a>
                                                    </form>
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
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>       
       <!-- Modal -->
       
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width:1250px;" role="document">
                
                <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{url('/user/single-task-model-complete/')}}" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body" style="background-color: #ebebeb;">
                       
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
                            <input type="hidden" name="project_id" class="project-idd">
                            <textarea rows="10" id="editor" name="desc" class="form-control no-resize task-desc" placeholder="Please type what you want..."></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group mt-3">
                                <label for="screenshot">Select Task ScreenShot</label><br>
                                <input type="hidden" name="task_id" class="task_id">
                                <input type="file" name="images[]" style="padding:5px;">
                                <input type="file" name="images[]" style="padding:5px;">
                                <input type="file" name="images[]" style="padding:5px;">
                                <input type="file" name="images[]" style="padding:5px;">
                                <input type="file" name="images[]" style="padding:5px;">
                            </div>
                        </div>
                         <div class="row">
                            <div class="form-group mt-3">
                                <label for="screenshot">Task ScreenShot</label><br>
                                <span class="screenshots">
                                   
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="screenshot">Task Completed</label><br>
                            
                            <input type="radio" class="radio " name="progress" value="five" id="five">
                            <label for="five" class="label">5%</label>
                            
                            <input type="radio" class="radio" name="progress" value="twentyfive" id="twentyfive" >
                            <label for="twentyfive" class="label">25%</label>
                            
                            
                            <input type="radio" class="radio" name="progress" value="fifty" id="fifty">
                            <label for="fifty" class="label">50%</label>
                        
                            <input type="radio" class="radio" name="progress" value="seventyfive" id="seventyfive">
                            <label for="seventyfive" class="label">75%</label>
                        
                            <input type="radio" class="radio" name="progress" value="onehundred" id="onehundred">
                            <label for="onehundred" class="label">100%</label>
                        
                            <div class="progress" style="margin: 0px;width:290px;">
                            <div class="progress-bar"></div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12" style="background: aliceblue;">
                                <div class="float-right form-group mt-3">
                                    <button type="submit" class="btn btn-danger mark_complete">Update Task</button>
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
        <script>
        // function img_pathUrl(input){
        //     $('#img_url').removeClass('d-none');
        //     $('#img_url')[0].src = (window.URL ? URL : webkitURL).createObjectURL(input.files[0]);
        // }
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
                    url:'/user/single-task-model/',
                    data:{
                        "_token": $('#csrf-token')[0].content,
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
                        if(response.data.description != null){
                            var rehtml = response.data.description.replace(/(<([^>]+)>)/gi, "");
                            $('.task-desc').text(rehtml.replace(/\&nbsp;/g, ''));
                        }else{
                            $('.task-desc').text(response.data.description);
                        }
                        
                        var progresscheck =  response.data.progress;
                        if(progresscheck == 'five'){
                            $('#five').prop('checked', true);
                        }else if(progresscheck == 'twentyfive'){
                            $('#twentyfive').prop('checked', true);
                        }else if(progresscheck == 'fifty'){
                            $('#fifty').prop('checked', true);
                        }else if(progresscheck == 'seventyfive'){
                            $('#seventyfive').prop('checked', true);
                        }else if(progresscheck == 'onehundred'){
                            $('#onehundred').prop('checked', true);
                        }
                        
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
        // $('.mark_as_complete').on('click',function(){
        //     var task_id = $(this).data('id');
           
        //     let myform = document.getElementById("myform");
        //     let fd = new FormData(myform );
        //     fd.serialize();
        //     $.ajax({
        //             type:"GET",
        //             dataType:"json",
        //             url:'/user/single-task-model-complete/',
        //             data:{
                      
        //                 'task_id':task_id,
        //                 'formData':fd
        //             },
                  
        //             success:function(response){
        //                 location.reload();
        //             }
        //         });
        // });

        </script>
@endsection