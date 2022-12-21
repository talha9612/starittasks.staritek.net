@extends('layouts.admin.app')
@section('mytitle','Tasks')
@section('content')
<style>
 .ck.ck-editor__main .ck-content {
  height: 239px;
}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
    $chart_array = [];
    $check_sm = [
            $project->project_name,
            $project->project_name,
            null,
            date('Y,m,d', strtotime($project->start_date)),
            date('Y,m,d', strtotime($project->deadline)),
            $left_days* 24 * 60 * 60 * 1000,
            round($project->project_complete),
            null,
    ];
    array_push($chart_array,$check_sm);
    $check_sm = [];
    for($i=0; $i<sizeof($tasks); $i++){
        array_push($check_sm,$tasks[$i]->heading);
        array_push($check_sm,$tasks[$i]->heading);
        array_push($check_sm,$tasks[$i]->heading);
        array_push($check_sm, date('Y,m,d', strtotime($tasks[$i]->start_date)));
        array_push($check_sm, date('Y,m,d', strtotime($tasks[$i]->due_date)));
        array_push($check_sm,10* 24 * 60 * 60 * 1000);
        array_push($check_sm,$tasks[$i]->progress_int );
        if($i == 0 ){
            array_push($check_sm,null);
        }else{
            array_push($check_sm,$tasks[$i-1]->heading);
        }
        array_push($chart_array,$check_sm);
        $check_sm = [];
    }
?>
    <script>
        google.charts.load("current", { packages: ["gantt"] });
        google.charts.setOnLoadCallback(drawChart);
        function daysToMilliseconds(days) {
        return days * 24 * 60 * 60 * 1000;
        }
        function drawChart() {
            var otherData = new google.visualization.DataTable();
            otherData.addColumn("string", "Task ID");
            otherData.addColumn("string", "Task Name");
            otherData.addColumn("string", "Resource");
            otherData.addColumn("date", "Start");
            otherData.addColumn("date", "End");
            otherData.addColumn("number", "Duration");
            otherData.addColumn("number", "Percent Complete");
            otherData.addColumn("string", "Dependencies");
            var user = [];
            // user = <?php echo json_encode($chart_array); ?>;
            user = @json($chart_array);
            for(var i=0; i<user.length; i++){
                user[i][3] = new Date(user[i][3]);
                user[i][4] = new Date(user[i][4]);
            }
            // console.log(user);
            otherData.addRows(user);
            var options = {
            height: 500,
            gantt: {
                defaultStartDate: new Date(),
            },
            };
            var chart = new google.visualization.Gantt(document.getElementById("chart_div"));
            chart.draw(otherData, options);
        }
    </script>
        <div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between mb-2">
                                    <ul class="nav nav-tabs b-none">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i> Project Details</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#projectmember"><i class="fa fa-plus"></i> Project Members</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#projecttask"><i class="fa fa-plus"></i> Project Tasks</a></li>
                                        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addmembers"><i class="fa fa-plus"></i> Add Member into Project</a></li> -->
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body mt-3">
            <div class="container-fluid">

                <div class="row clearfix row-deck">
                    @if($datecheck == false)
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Days Left</h3>
                                </div>
                                <div class="card-body">
                                    <span class="float-left"><i class="fa fa-clock-o" style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                    <h5 class="number mb-0 font-32 counter float-right">{{ $left_days }}</h5>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Delay Days</h3>
                                </div>
                                <div class="card-body">
                                    <span class="float-left"><i class="fa fa-clock-o" style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                    <h5 class="number mb-0 font-32 counter float-right">{{ $left_days }}</h5>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pending Tasks</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-file" style="font-size: 40px;color:#ff9800bf" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{ $pending_tasks }}</h5>
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
                                <h5 class="number mb-0 font-32 counter float-right">{{ $complete_task }}</h5>
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
                            <div class="col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Project Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <select id="ShowDetails"  class="browser-default custom-select col-md-3 text-capitalize" >
                                                <option selected><b>View Task Details</b></option>
                                                @foreach ($tasks as $task)
                                                    <option value="{{ $task->id }}">{{ $task->heading }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div id="chart_div"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="projectmember" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
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
                    <!-- For Project Task -->
                    <div class="tab-pane fade" id="projecttask" role="tabpanel">
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
                                                <td class="text-capitalize">

                                                        <h6 class="mb-0 text-dark">{{$task->heading}}</h6>

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
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Here End Project Task -->
                </div>
            </div>
        </div>
        <script>
            $('#ShowDetails').change(function(){
                var value ="";
                value = $(this).val();
                if(value !== ""){
                    location.href = "showtaskdetail/"+value;
                }else{}
            });
        </script>


@endsection
