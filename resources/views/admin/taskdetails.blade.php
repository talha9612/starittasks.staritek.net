@extends('layouts.admin.app')
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i>Task Detail</a></li>
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
                                    <h3 class="card-title">Tasks Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <spane class="project-title "> Project name :- <span class="text-danger text-capitalize"><b>{{ $task->project->project_name }}</b></span></span>
                                            </spane>
                                            </br>
                                            <spane class="task-title "> Task name :- <span class="text-capitalize" style="color:#17a2b8!important"><b>{{ $task->heading }}</b></span>
                                            </spane>
                                            </br>
                                            <label class="tag tag-default task-catagory" style="border-radius: 15px;">Task Category &gt; 
                                                <span class="text-capitalize">{{ $task->GetTaskCatagory->category_name }}</span>
                                            </label>
                                            <span class="task-status" style="border-radius: 15px;">
                                                @if($task->status == 1)
                                                <label class='tag tag-warning' style='border-radius: 15px;'>Status > Not Started</label>
                                                @elseif($task->status == 2)
                                                <label class='tag tag-info' style='border-radius: 15px;'>Status > In Progress</label>
                                                @elseif($task->status == 3)
                                                <label class='tag tag-primary' style='border-radius: 15px;'>Status > ON Hold</label>
                                                @elseif($task->status == 4)
                                                <label class='tag tag-danger' style='border-radius: 15px;'>Status > Cancelled</label>
                                                @elseif($task->status == 5)
                                                <label class='tag tag-success' style='border-radius: 15px;'>Status > Finished</label>
                                                @endif
                                            </span>
                                            <span class="task-priority" style="border-radius: 15px;">
                                                @if($task->priority == 1)
                                                <label class="tag tag-success" style="border-radius: 15px;">Priority &gt; High</label>
                                                @elseif($task->priority == 2)
                                                <label class="tag tag-warning" style="border-radius: 15px;">Priority &gt; Medium</label>
                                                @elseif($task->priority == 3)
                                                <label class="tag tag-primary" style="border-radius: 15px;">Priority &gt; Low</label>
                                                @endif
                                            </span>
                                            <div class="row mt-3">
                                                <div class="col-xs-4 col-md-2 font-12 m-t-10">
                                                    <label class="font-12" for="">Assigned To</label><br>
                                                    <ul class="list-unstyled d-inline team-info sm margin-0 w150">
                                                        <li><img id="assign_to" src="{{ asset('/uploads/staf_images/'.$task->AssignTo->image) }}" class="img-circle" width="25" alt=""></li>
                                                    </ul>
                                                    <p class="text-capitalize d-inline">{{ $task->AssignTo->name }}</p>
                                                </div>
                                                <div class="col-xs-4 col-md-2 font-12 m-t-10">
                                                    <label class="font-12" for="">Assigned By</label><br>
                                                    <ul class="list-unstyled d-inline team-info sm margin-0 w150">
                                                        <li><img id="assign_by" src="{{ asset('/uploads/staf_images/'.$task->AssignBy->image) }}" class="img-circle" width="25" alt=""></li>
                                                    </ul>
                                                    <p class="text-capitalize d-inline">{{ $task->AssignBy->name }}</p>
                                                </div>
                                                <div class="col-xs-4 col-md-2 font-12 m-t-10">
                                                    <label class="font-12" for="">Start Date</label><br>
                                                    <label class="tag tag-danger">{{ $task->start_date }}</label>
                                                </div>
                                                <div class="col-xs-4 col-md-2 font-12 m-t-10">
                                                    <label class="font-12" for="">Due Date</label><br>
                                                    <label class="tag tag-success">{{ $task->due_date }}</label>
                                                </div>
                                                <div class="col-xs-4 col-md-2 font-12 m-t-10">
                                                    <label class="font-12" for="">Days Left</label><br>
                                                    <label class="tag tag-success">{{ $left_days }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="exampleInputPassword1">Description</label>
                                                <p class="form-control task-desc" name="desc">{{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($task->description)))))), 50000)}}</p>
                                            </div>
                                            <div class="row">
                                                <div class="form-group mt-3">
                                                    <label for="screenshot">Task ScreenShot</label><br>
                                                    <span class="screenshots">
                                                        <a href="#" target="_blank">
                                                            <?php $svalues = json_decode($task->screen_shot);?>
                                                            @if($svalues !== null)
                                                                @foreach($svalues as $image)
                                                                    <img src="{{ asset('/uploads/screenshots/'.$image) }}" width="150" class="img-thumbnail">
                                                                @endforeach
                                                            @endif
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group mt-3">
                                                    <label for="screenshot">Task Completed</label><br>
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h3 class="m-4">Task History</h3>
                                                    <ul class="new_timeline">
                                                        @foreach ($backups as $backup)
                                                            <li>
                                                                <div class="bullet pink"></div>
                                                                <div class="time">
                                                                    {{ $backup->created_at }}
                                                                    <span class="tag tag-default" style="border-radius:20px;">
                                                                        @foreach ($users as $user)
                                                                            @if($user->id == $backup->causer_id)
                                                                                {{ $user->name }}
                                                                            @else
                                                                            @endif
                                                                        @endforeach
                                                                    </span>

                                                                    @if($backup->properties['attributes']['status'] == 1)
                                                                    <label class='tag tag-warning' style='border-radius: 15px;'>Status > Not Started</label>
                                                                    @elseif($backup->properties['attributes']['status'] == 2)
                                                                    <label class='tag tag-info' style='border-radius: 15px;'>Status > In Progress</label>
                                                                    @elseif($backup->properties['attributes']['status'] == 3)
                                                                    <label class='tag tag-primary' style='border-radius: 15px;'>Status > ON Hold</label>
                                                                    @elseif($backup->properties['attributes']['status'] == 4)
                                                                    <label class='tag tag-danger' style='border-radius: 15px;'>Status > Cancelled</label>
                                                                    @elseif($backup->properties['attributes']['status'] == 5)
                                                                    <label class='tag tag-success' style='border-radius: 15px;'>Status > Finished</label>
                                                                    @endif
                                                                    <span class="task-priority" style="border-radius: 15px;">
                                                                        @if($backup->properties['attributes']['priority'] == 1)
                                                                        <label class="tag tag-success" style="border-radius: 15px;">Priority &gt; High</label>
                                                                        @elseif($backup->properties['attributes']['priority'] == 2)
                                                                        <label class="tag tag-warning" style="border-radius: 15px;">Priority &gt; Medium</label>
                                                                        @elseif($backup->properties['attributes']['priority'] == 3)
                                                                        <label class="tag tag-primary" style="border-radius: 15px;">Priority &gt; Low</label>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="desc">
                                                                    <h3 class="text-capitalize">{{ $backup->description }}</h3>
                                                                    <h4 class="text-capitalize mt-2">Title:- {{ $backup->properties['attributes']['heading'] }}</h4>
                                                                    <p class="form-control task-desc" name="desc">{{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($backup->properties['attributes']['description'])))))), 50000)}}</p>
                                                                    <?php $values = json_decode($backup->properties['attributes']['screen_shot']);?>
                                                                    @if($values !== null)
                                                                        @foreach($values as $value)
                                                                            <img src="{{ asset('uploads/screenshots/'.$value) }}" width="150" class="img-thumbnail">
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
