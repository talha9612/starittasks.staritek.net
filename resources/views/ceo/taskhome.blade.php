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
                                                <!-- <td class="task_heading_width">{{ $task['heading'] }}</td> -->
                                                <td class="text-capitalize task_heading_width">
                                                    <a href="javascript:void(0)" class="getmodel" data-id="{{ $task['id'] }}" data-toggle="modal" data-target="#exampleModal">
                                                        <h6 class="mb-0">{{ $task['heading'] }}</h6>
                                                    </a>
                                                </td>
                                                <!-- <td>{{ \Illuminate\Support\Str::limit($task['heading'], 30, $end=' ...') }}</td> -->
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
@endsection