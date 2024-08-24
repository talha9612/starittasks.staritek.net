@extends('layouts.ceo.app')
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
                                <h3 class="card-title">Projects</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-tasks " style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$projectCount}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
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
                    {{-- <div class="col-xl-2 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Managers</h3>
                            </div>
                            <div class="card-body">
                            <span class="float-left"><i class="fa fa-user-circle" style="font-size: 40px;color:#2196f3" aria-hidden="true"></i></span>
                                <h5 class="number mb-0 font-32 counter float-right">{{$managerscount}}</h5>

                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xl-3 col-lg-4 col-md-6">
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
                    <div class="col-xl-3 col-lg-4 col-md-6">
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
                    @foreach($users as $user)
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header bg-danger">
                                    <h3 class="card-title">Tasks of ({{ $user->name }})</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped  table-vcenter mb-0">
                                            <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Project</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user->getTasks as $task)
                                                <tr>
                                                    <td>{{$task->heading}}</td>
                                                    <td>{{$task->project->project_name}}</td>
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
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

@endsection
