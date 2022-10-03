@extends('layouts.manager.app')
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
        $project->project_name,
        'null',
        'null',
        $left_days,
        '30',
        'null',
];
array_push($chart_array,$check_sm);
$check_sm = [];
for($i=0; $i<sizeof($tasks); $i++){
    array_push($check_sm,$tasks[$i]->heading);
    array_push($check_sm,$tasks[$i]->heading);
    array_push($check_sm,$tasks[$i]->heading);
    array_push($check_sm,null);
    array_push($check_sm,null);
    array_push($check_sm,10);
    array_push($check_sm,50);
    array_push($check_sm,null);
    array_push($chart_array,$check_sm);
    $check_sm = [];
}

// dd(json_encode($chart_array)); 
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
        user = <?php echo json_encode($chart_array) ?>;
        console.log(user);
        otherData.addRows([['laravel', 'laravel', 'laravel', null, null, daysToMilliseconds(3), 30, null]]);

        var options = {
          height: 275,
          gantt: {
            defaultStartDate: new Date(),
          },
        };

        var chart = new google.visualization.Gantt(
          document.getElementById("chart_div")
        );

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
                            <div class="col-md-9 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Project Details</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <td>{{ ucfirst($project->project_name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Created By</th>
                                                        <td>{{ ucfirst($project->createproject->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Manager</th>
                                                        <td>{{ ucfirst($project->head->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Start Date</th>
                                                        <td>{{ $project->start_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Last date</th>
                                                        <td>{{ $project->deadline }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Category</th>
                                                        <td>{{  ucfirst($project->projectcatagory->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th>
                                                        <td  class="text-capitalize">
                                                            {{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($project->project_summary)))))), 40)}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            @if($project->status ==1)
                                                            <span class="tag tag-danger">Not Started</span>
                                                            @elseif($project->status ==2)
                                                            <span class="tag tag-info">In Progress</span>
                                                            @elseif($project->status ==3)
                                                            <span class="tag tag-warning">On Hold</span>
                                                            @elseif($project->status ==4)
                                                            <span class="tag tag-success">Cancelled</span>
                                                            @else
                                                            <span class="tag tag-secondary">Completed</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tasks Summary</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <td>{{ ucfirst($project->project_name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Created By</th>
                                                        <td>{{ ucfirst($project->createproject->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Manager</th>
                                                        <td>{{ ucfirst($project->head->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Start Date</th>
                                                        <td>{{ $project->start_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Last date</th>
                                                        <td>{{ $project->deadline }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Project Category</th>
                                                        <td>{{  ucfirst($project->projectcatagory->name) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Description</th>
                                                        <td  class="text-capitalize">
                                                            {{\Illuminate\Support\Str::limit(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($project->project_summary)))))), 40)}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            @if($project->status ==1)
                                                            <span class="tag tag-danger">Not Started</span>
                                                            @elseif($project->status ==2)
                                                            <span class="tag tag-info">In Progress</span>
                                                            @elseif($project->status ==3)
                                                            <span class="tag tag-warning">On Hold</span>
                                                            @elseif($project->status ==4)
                                                            <span class="tag tag-success">Cancelled</span>
                                                            @else
                                                            <span class="tag tag-secondary">Completed</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
                                    </d>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <!-- Here End Project Task -->
                </div>
            </div>
        </div>
       


@endsection
