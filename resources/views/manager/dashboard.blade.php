@extends('layouts.manager.app')
@section('mytitle','Dashboard')
@section('content')
<div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <h4><i class="fa fa-address-book" aria-hidden="true"></i> Welcome {{Auth::user()->name}}</h4>
                            <small>Measure How Fast You’re Growing Monthly Recurring Revenue. <a href="#">Learn More</a></small>
                        </div>                        
                    </div>
                </div>
                <div class="row clearfix row-deck">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Assign Projects</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-tasks " style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$project}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Team Mambers</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-user" style="font-size: 40px;color:#00bcd4" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$user}}</h5>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Task Pandding</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-file" style="font-size: 40px;color:#ff9800bf" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$pandding_tasks}}</h5>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Complete Task</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-check-square" style="font-size: 40px;color:#4caf50" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$pandding_tasks_complete}}</h5>
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
                                                <th>Start Date</th>
                                                <th>Last Date</th>
                                                <th>Project Category</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $project)
                                            <tr>
                                                <td>{{$project->id}}</td>
                                                <td>{{$project->project_name}}</td>
                                                <td>
                                                {{$project->head->name}}
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
       
@endsection