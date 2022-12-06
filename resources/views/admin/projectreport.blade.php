@extends('layouts.admin.app')
@section('mytitle','-Project-Report')
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
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i> Projects Report</a></li>                                        
                                        {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-plus"></i> Add New Project</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addmembers"><i class="fa fa-plus"></i> Add Member into Project</a></li> --}}
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
                                        <h3 class="card-title">Projects Report For Dwonload</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                       
                                                        <th>Project</th>
                                                        <th>Project Head</th>
                                                        <th>Project Team</th>
                                                        <th>Start Date</th>
                                                        <th>Last Date</th>
                                                        <th>Project Catagory</th>
                                                        <th>Proejct Completed</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($projects as $project)
                                                  
                                                        <tr>
                                                           
                                                            <td>
                                                                <form method="post" action="/admin/projectdetails" id="my_form_{{ $project->id }}">
                                                                    @csrf
                                                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                                    <a href="javascript:{}" onclick="document.getElementById('my_form_{{ $project->id }}').submit();"><b>{{ $project->project_name}}</b></a>
                                                                </form>
                                                            </td>
                                                            <td>{{$project->head['name']}}</td>
                                                            <td>
                                                                
                                                                <ul class="list-unstyled team-info sm margin-0 w150">
                                                                   <ul class="list-unstyled team-info sm margin-0 w150">
                                                                    <li>
                                                                        @foreach ($project->assign_project as $team)
                                                                            {{ $team->getusers->name."," }}
                                                                        @endforeach
                                                                    </li>
                                                                </ul>
                                                                </ul>
                                                            </td>
                                                            <td>{{$project->start_date}}</td>
                                                            <td>{{$project->deadline}}</td>
                                                            <td>{{$project->projectcatagory->name}}</td>
                                                            <td>{{$project->project_complete}}%</td>
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
                                                <tfoot>
                                                    <tr>
                                                       
                                                        <th>Project</th>
                                                        <th>Project Head</th>
                                                        <th>Project Team</th>
                                                        <th>Start Date</th>
                                                        <th>Last Date</th>
                                                        <th>Project Catagory</th>
                                                        <th>Proejct Completed</th>
                                                        <th>Status</th>
                                                       </tr>
                                                </tfoot>
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
        <!-- Add New Task -->

<script>
    $(document).ready(function(){
        $('select').selectpicker();
        $('#example').DataTable({
                scrollX: true,
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    // 'copyHtml5',
                    'excelHtml5',
                    // 'csvHtml5',
                    // 'pdfHtml5'
                ]
            });
        });
</script>
@endsection
