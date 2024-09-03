@extends('layouts.manager.app')
@section('mytitle', 'Edit-Project')
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
                                                class="fa fa-list-ul"></i> Edit Project</a></li>
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
                                    <h3 class="card-title">Edit Project</h3>

                                </div>
                                <form class="card-body" method="post" action="{{ url('/manager/update-project') }}"
                                    enctype="multipart/form-data">
                                    @csrf()
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Project Name</label>
                                                <input type="hidden" name="id" value="{{ $project->id }}"
                                                    class="form-control">
                                                <input type="text" name="name" value="{{ $project->project_name }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Project Catagory </label>
                                                <select class="form-control" name="catagory">
                                                    @foreach ($catagories as $catagory)
                                                        <option value="{{ $catagory->id }}">{{ $catagory->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Start Date </label>
                                                <input type="datetime-local"
                                                    value="{{ date('Y-m-d H:i:s', strtotime($project->start_date)) }}"
                                                    name="start_date" data-date-autoclose="true" class="form-control"
                                                    placeholder="Date of Birth">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Deadline</label>
                                                <input type="datetime-local" name="end_date"
                                                    value="{{ date('Y-m-d H:i:s', strtotime($project->deadline)) }}"
                                                    data-date-autoclose="true" class="form-control"
                                                    placeholder="Date of Birth">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Project Head</label>
                                                <select class="form-control" name="head">
                                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Project Status</label>
                                                <select class="form-control show-tick" name="status">
                                                    <option value="1">Not Started</option>
                                                    <option value="2">In Progress</option>
                                                    <option value="3">On Hold</option>
                                                    <option value="4">Cancelled</option>
                                                    <option value="5">Finished</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mt-3">
                                                <label>Project Summary</label>
                                                <textarea rows="10" id="editor" name="summary" class="form-control no-resize"
                                                    placeholder="Please type what you want...">{{ $project->project_summary }}</textarea>
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
