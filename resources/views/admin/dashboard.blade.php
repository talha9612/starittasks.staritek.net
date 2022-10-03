@extends('layouts.admin.app')
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
                    <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Projects</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-tasks " style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$projectCount}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Complete Projects</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-check-square" style="font-size: 40px;color:#4caf50" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$CompleteprojectCount}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Managers</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-user-circle" style="font-size: 40px;color:#2196f3" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$managerscount}}</h5>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Team Members</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-user" style="font-size: 40px;color:#00bcd4" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$memCount}}</h5>
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Task Pending</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-file" style="font-size: 40px;color:#ff9800bf" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$taskCount}}</h5>
                                
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
                                                <th>Action</th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $datas)
                                            @foreach($datas as $key=>$project)
                                            <tr>
                                                <td>{{$project->id}}</td>
                                                <td>
                                                    <form method="post" action="/admin/projectdetails" id="my_form_{{ $project->id }}">
                                                        @csrf
                                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                        <a href="javascript:{}" onclick="document.getElementById('my_form_{{ $project->id }}').submit();"><b>{{ $project->project_name}}</b></a>
                                                    </form>
                                                </td>
                                                <td>
                                                    <ul class="list-unstyled team-info sm margin-0 w150 d-inline">
                                                        <li><img src="{{asset('uploads/staf_images/'.$project->head->image)}}" alt="Avatar"></li>
                                                    </ul>
                                                <span class="d-inine">{{$project->head->name}}</span>
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
                                                    <form action="/admin/project-edit" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$project->id}}">    
                                                        <button class="btn btn-primary">Edit</button>
                                                    </form>
                                                     | 
                                                     <form action="/admin/project-delete" method="post" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$project->id}}">    
                                                        <button class="btn btn-danger">Del</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
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