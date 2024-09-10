@extends('layouts.developer.app')
@section('mytitle', 'Dashboard')
@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="row clearfix row-deck">
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Number of Companies</h3>
                                    </div>
                                    <div class="card-body">
                                        <span class="float-left"><i class="fa fa-tasks "
                                                style="font-size: 40px;color:#EB6F62" aria-hidden="true"></i></span>
                                        <h5 class="number mb-0 font-32 counter float-right">{{ $allcompanies }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-md-flex justify-content-between mb-2">
                                <ul class="nav nav-tabs b-none">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i
                                                class="fa fa-list-ul"></i>user List</a></li>
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
                                    <h3 class="card-title">View All Users</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone No</th>
                                                    <th>Address</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($userDetails as $user)
                                                    <tr>
                                                        <td class="text-capitalize">{{ $user->name }}</td>
                                                        <td class="text-capitalize">{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td class="text-capitalize">{{ $user->address }}</td>
                                                        <td>
                                                            <label class="custom-switch m-0">
                                                                <input type="checkbox" value="1" class="custom-switch-input manager-change-status-user" data-id="{{$user->id}}" data-toggle="toggle" data-onstyle="outline-success" {{ $user->status == 1 ? 'checked' : '' }}>
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
                    </div>
                </div>
                <div class="tab-pane fade" id="addnew" role="tabpanel">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add Staff</h3>

                                </div>
                                <form class="card-body" method="post" action="{{ url('/manager/add-user') }}"
                                    enctype="multipart/form-data">
                                    @csrf()
                                    <div class="row clearfix">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" name="password" id="myInput"
                                                        class="form-control" aria-label="Amount (to the nearest dollar)">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" onclick="myFunction()"><i
                                                                class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" name="dob" value="2000-01-22"
                                                    data-date-autoclose="true" class="form-control"
                                                    placeholder="Date of Birth" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <label>Gender</label>
                                            <select class="form-control show-tick" name="gender" required>
                                                <option value="">-- Gender --</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Department <button type="button" class="btn btn-success btn-sm"
                                                        onclick="GetDepartment()" data-toggle="modal"
                                                        data-target="#addtask">Add Department</button></label>
                                                <select class="form-control show_department" name="department">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Skills <button type="button" class="btn btn-success btn-sm"
                                                        onclick="GetSkill()" data-toggle="modal"
                                                        data-target="#addskill">Add
                                                        Skill</button></label>
                                                <select class="form-control show_skill" name="skill">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" name="phone" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select class="form-control show-tick" name="role">
                                                    <option value="3">My Team Member</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class=" col-md-4 col-sm-12">
                                            <label>Select Image</label>
                                            <div class="form-group mt-2 mb-3">
                                                <input type="file" name="image" placeholder="check abid"
                                                    class="dropify" required>
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
                <div class="tab-pane fade" id="otherteammembers" role="tabpanel">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add Team Member From Other Teams</h3>
                                </div>
                                <form class="card-body" method="post" action="{{ url('/manager/privous-add-user') }}"
                                    enctype="multipart/form-data">
                                    @csrf()
                                    <div class="row clearfix">
                                        <div class="col-md-4 col-sm-12">
                                            <label>Other Team Member List</label>
                                            <select class="form-control show-tick" name="member_id" required>
                                                {{-- @foreach ($teams as $team)
                                            @if ($team->team_member == Auth::user()->id)
                                            @else
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                            @endif
                                            @endforeach --}}

                                            </select>
                                        </div>
                                        <div class="col-sm-12 mt-3">
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
@endsection
