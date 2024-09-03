@extends('layouts.manager.app')
@section('mytitle', 'Edit-Task')
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i
                                                class="fa fa-list-ul"></i> Edit Task</a></li>
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
                                    <h3 class="card-title">Add Task</h3>

                                </div>
                                <form class="card-body" method="post" action="{{ url('/manager/update-task') }}"
                                    enctype="multipart/form-data">
                                    @csrf()
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                <label>Select Projects</label>
                                                <select class="form-control show-tick" name="project_id">
                                                    <option value="{{ $project->id }}">{{ $project->project_name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Task Category </label>
                                                <select class="form-control" name="catagory">
                                                    @foreach ($catagories as $catagory)
                                                        @if ($catagory->id == $task->task_category_id)
                                                            <option value="{{ $catagory->id }}" selected>
                                                                {{ $catagory->category_name }}</option>
                                                        @endif
                                                        <option value="{{ $catagory->id }}">{{ $catagory->category_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Task Title</label>
                                                <input type="text" name="title" value="{{ $task->heading }}"
                                                    class="form-control" placeholder="Task Title">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="datetime-local" name="start_date"
                                                    value="{{ date('Y-m-d H:i:s', strtotime($task->start_date)) }}"
                                                    data-date-autoclose="true" class="form-control"
                                                    placeholder="Start date">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Due Date</label>
                                                <input type="datetime-local" name="due_date"
                                                    value="{{ date('Y-m-d H:i:s', strtotime($task->due_date)) }}"
                                                    data-date-autoclose="true" class="form-control" placeholder="Due Date">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Assigned To</label>
                                                <select class="form-control" name="assign_to">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" <?php echo $user->id == $task->user_id ? 'selected' : ''; ?>>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Task Status</label>
                                                <select class="form-control" name="status">
                                                    @if ($task->status == 1)
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
                                            <input type="radio" class="radio" name="progress" value="five"
                                                id="five" <?php echo $task->progress == 'five' ? 'checked' : ''; ?>>
                                            <input type="radio" class="radio" name="progress" value="twentyfive"
                                                id="twentyfive" <?php echo $task->progress == 'twentyfive' ? 'checked' : ''; ?>>
                                            <label for="twentyfive" class="label">25%</label>

                                            <input type="radio" class="radio" name="progress" value="fifty"
                                                id="fifty" <?php echo $task->progress == 'fifty' ? 'checked' : ''; ?>>
                                            <label for="fifty" class="label">50%</label>

                                            <input type="radio" class="radio" name="progress" value="seventyfive"
                                                id="seventyfive" <?php echo $task->progress == 'seventyfive' ? 'checked' : ''; ?>>
                                            <label for="seventyfive" class="label">75%</label>

                                            <input type="radio" class="radio" name="progress" value="onehundred"
                                                id="onehundred" <?php echo $task->progress == 'onehundred' ? 'checked' : ''; ?>>
                                            <label for="onehundred" class="label">100%</label>

                                            <div class="progress" style="margin: 0px;width:290px;">
                                                <div class="progress-bar"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="d-block">Add ScreenShot</label>
                                                <input type="file" name="images[]"
                                                    class="form-control col-md-4 d-inline">
                                                <input type="file" name="images[]"
                                                    class="form-control col-md-4 d-inline">
                                                <input type="file" name="images[]"
                                                    class="form-control col-md-4 d-inline">
                                                <input type="file" name="images[]"
                                                    class="form-control col-md-4 d-inline">
                                                <input type="file" name="images[]"
                                                    class="form-control col-md-4 d-inline">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mt-3">
                                                <label>Description</label>
                                                <textarea rows="10" id="editor" name="summary" class="form-control no-resize"
                                                    placeholder="Please type what you want...">{{ $task->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Priority</label>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="priority"
                                                        value="1" id="flexRadioDefault1" <?php echo $task['priority'] == 1 ? 'checked' : ''; ?> />
                                                    <label class="form-check-label text-danger" for="flexRadioDefault1">
                                                        High </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="priority"
                                                        value="2" id="flexRadioDefault2" <?php echo $task['priority'] == 2 ? 'checked' : ''; ?> />
                                                    <label class="form-check-label text-warning"
                                                        style="color:#ffc107!important" for="flexRadioDefault2"> Medium
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="priority"
                                                        value="3" id="flexRadioDefault3" <?php echo $task['priority'] == 3 ? 'checked' : ''; ?> />
                                                    <label class="form-check-label text-success"
                                                        style="color:#28a745!important" for="flexRadioDefault3"> Low
                                                    </label>
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

                <!-- Here End For Add Member Into Project -->
            </div>
        </div>
    </div>
    <!-- Add New Task -->
    <div class="modal fade" id="addtask" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title" id="defaultModalLabel">Add New Category</h6>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="form-group show_catagory">
                                <p></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" id="catagory_name" class="form-control"
                                    placeholder="Catagory Name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="SaveCatagory()">Add</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });
            GetCatagory();
            GetProjectHeads();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        });

        function GetCatagory() {
            $(".show_catagory").empty();
            $(".show_pro_cata").empty();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/manager/catagory/',
                success: function(response) {
                    var count = 1;
                    for (let i = 0; i < response.catagories.length; i++) {
                        $(".show_catagory").append("<p id='" + response.catagories[i].id + "'>" + (count + i) +
                            ") " + response.catagories[i].name +
                            " <span style='float: right;'><button class='btn btn-danger btn-sm' onclick='DeleteCatagory(" +
                            response.catagories[i].id + ")'>X</button></span></p>");
                        $(".show_pro_cata").append("<option value=" + response.catagories[i].id + ">" + (count +
                            i) + ") " + response.catagories[i].name + "</option>");
                    }
                }
            });
        }

        function SaveCatagory() {
            var catagoryname = $('#catagory_name').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/manager/save-catagory/',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'catagoryname': catagoryname
                },

                success: function(response) {
                    GetCatagory();
                    $('#catagory_name').val('');
                }
            })
        }

        function GetProjectHeads() {
            $(".show_catagory").empty();
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/manager/prjectheads/',
                success: function(response) {
                    console.log(response.users[0].name)
                    var count = 1;
                    for (let i = 0; i < response.users.length; i++) {
                        $(".show_pro_head").append("<option value=" + response.users[i].id + ">" + (count + i) +
                            ") " + response.users[i].name + "</option>");
                    }
                }
            })
        }

        function DeleteCatagory(id) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/manager/delete-project-catagory/',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': id
                },
                success: function(response) {
                    $("p[id=" + id + "]").remove();
                }
            });
        }
    </script>
@endsection
