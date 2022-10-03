@extends('layouts.admin.app')
@section('mytitle','edit-task')
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
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i>Edit Task</a></li>                                        
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
                                <h3 class="card-title">Edit Task</h3>
                                <div class="card-options ">
                                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <form class="card-body" method="post" action="{{url('/admin/update-task')}}" enctype="multipart/form-data">
                                        @csrf()
                                        <div class="row clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Select Projects</label>
                                                    <select class="form-control select_project" name="project_id">
                                                        <option value="{{$task->project->id}}">{{$task->project->project_name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Task Category</label>
                                                    <select class="form-control show_pro_cata" name="catagory">
                                                        @foreach($task_catagories as $catagories)
                                                            @foreach($catagories as $catagory)
                                                                <option value="{{$catagory->id}}" <?php echo ($catagory->id == $task->task_category_id ?'selected':'') ?> >{{$catagory->category_name}}</option>
                                                            @endforeach
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Task Title</label>
                                                    <input type="hidden" name="id" value="{{$task->id}}" class="form-control" placeholder="Task Title">
                                                    <input type="text" name="title" value="{{$task->heading}}" class="form-control" placeholder="Task Title">
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="datetime-local" name="start_date" value="{{date('Y-m-d H:i:s', strtotime($task->startdate))}}" data-date-autoclose="true" class="form-control" placeholder="Start date">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Due Date</label>
                                                    <input type="datetime-local" name="due_date" value="{{date('Y-m-d H:i:s', strtotime($task->due_date))}}" data-date-autoclose="true" class="form-control" placeholder="Due Date">
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Assigned To</label>
                                                    <select class="form-control show_head" name="assign_to">
                                                        <option value="{{$task->AssignTo->id}}">{{$task->AssignTo->name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Task Status</label>
                                                    <select class="form-control" name="status">
                                                        @if($task->status == 1)
                                                        <option value="1" selected>Not Started</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="3">On Hold</option>
                                                        <option value="4">Cancelled</option>
                                                        <option value="5">Finished</option>
                                                        @elseif($task->status == 2)
                                                        <option value="1">Not Started</option>
                                                        <option value="2" selected>In Progress</option>
                                                        <option value="3">On Hold</option>
                                                        <option value="4">Cancelled</option>
                                                        <option value="5">Finished</option>
                                                        @elseif($task->status == 3)
                                                        <option value="1">Not Started</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="3" selected>On Hold</option>
                                                        <option value="4">Cancelled</option>
                                                        <option value="5">Finished</option>
                                                        @elseif($task->status == 4)
                                                        <option value="1">Not Started</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="3">On Hold</option>
                                                        <option value="4" selected>Cancelled</option>
                                                        <option value="5">Finished</option>
                                                        @elseif($task->status == 5)
                                                        <option value="1">Not Started</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="3">On Hold</option>
                                                        <option value="4">Cancelled</option>
                                                        <option value="5" selected>Finished</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <label for="screenshot">Task Completed</label><br>
                                                <label for="five" class="label">5%</label>
                                                <input type="radio" class="radio" name="progress" value="five" id="five" <?php echo ($task->progress=='five')?'checked':''; ?>>
                                                <input type="radio" class="radio" name="progress" value="twentyfive" id="twentyfive" <?php echo ($task->progress=='twentyfive')?'checked':''; ?>>
                                                <label for="twentyfive" class="label">25%</label>
                                            
                                                <input type="radio" class="radio" name="progress" value="fifty" id="fifty" <?php echo ($task->progress=='fifty')?'checked':''; ?>>
                                                <label for="fifty" class="label">50%</label>
                                            
                                                <input type="radio" class="radio" name="progress" value="seventyfive" id="seventyfive" <?php echo ($task->progress=='seventyfive')?'checked':''; ?>>
                                                <label for="seventyfive" class="label">75%</label>
                                            
                                                <input type="radio" class="radio" name="progress" value="onehundred" id="onehundred" <?php echo ($task->progress=='onehundred')?'checked':''; ?>>
                                                <label for="onehundred" class="label">100%</label>
                                            
                                                <div class="progress" style="margin: 0px;width:290px;">
                                                <div class="progress-bar"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label  class="d-block">Add ScreenShot</label>
                                                    <input type="file" name="images[]" class="form-control col-md-4 d-inline">
                                                    <input type="file" name="images[]" class="form-control col-md-4 d-inline">
                                                    <input type="file" name="images[]" class="form-control col-md-4 d-inline">
                                                    <input type="file" name="images[]" class="form-control col-md-4 d-inline">
                                                    <input type="file" name="images[]" class="form-control col-md-4 d-inline">
                                                </div>
                                            </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mt-3">
                                                <label>Description</label>
                                                <textarea rows="10" id="editor" name="summary" class="form-control no-resize" placeholder="Please type what you want...">{{$task->description}}</textarea>
                                            </div>
                                        </div>
                                           
                                        </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Priority</label>
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" <?php echo ($task['priority']==1 ? 'checked' : '')?> name="priority" value="1" id="flexRadioDefault1"/>
                                                        <label class="form-check-label text-danger" for="flexRadioDefault1"> High </label>
                                                        </div>
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" <?php echo ($task['priority']==2 ? 'checked' : '')?> name="priority" value="2" id="flexRadioDefault2"/>
                                                        <label class="form-check-label text-warning" style="color:#ffc107!important" for="flexRadioDefault2"> Medium </label>
                                                        </div>
                                                        <div class="form-check">
                                                        <input class="form-check-input" type="radio" <?php echo ($task['priority']==3 ? 'checked' : '')?> name="priority" value="3" id="flexRadioDefault3"/>
                                                        <label class="form-check-label text-success" style="color:#28a745!important" for="flexRadioDefault3"> Low </label>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="submit" class="btn btn-outline-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function(){
            ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
        });
        </script>
@endsection