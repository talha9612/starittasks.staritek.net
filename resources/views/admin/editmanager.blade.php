@extends('layouts.admin.app')
@section('mytitle','Edit-User')
@section('content')
<div class="section-body mt-3">
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between mb-2">
                                    <ul class="nav nav-tabs b-none">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-list-ul"></i>Edit User</a></li>                                        
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
                                <h3 class="card-title">Add Staff</h3>
                                <div class="card-options ">
                                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <form class="card-body" method="post" action="{{url('/admin/update-manager')}}" enctype="multipart/form-data">
                                @csrf()
                                <div class="row clearfix">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="hidden" name="id" value="{{$user->id}}" class="form-control">
                                            <input type="text" name="name" value="{{$user->name}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" value="{{$user->email}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="datetime-local" name="dob" value="{{date('Y-m-d H:i:s', strtotime($user->dob))}}" data-date-autoclose="true" class="form-control" placeholder="Date of Birth">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label>Gender</label>
                                        <select class="form-control show-tick" name="gender">
                                            <option value="">-- Gender --</option>
                                            <option value="1" <?php echo($user->gender == 1)?'selected':'';?>>Male</option>
                                            <option value="2" <?php echo($user->gender == 2)?'selected':'';?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <select class="form-control show-tick" name="department">
                                                @foreach($departments as $department)
                                                    @foreach($department as $define)
                                                        <option value="{{$define->id}}" <?php echo($define->id == $user->department?'selected':'')?>>{{$define->name}}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Skills</label>
                                            <select class="form-control show-tick" name="skill">
                                                @foreach($skills as $skill)
                                                    @foreach($skill as $define)
                                                        <option value="{{$define->id}}" <?php echo($define->id == $user->skill?'selected':'')?>>{{$define->name}}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" value="{{$user->phone}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" value="{{$user->address}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select class="form-control show-tick" name="role">
                                            <option value="">-- Role --</option>
                                            <option value="2" <?php echo($user->role == 2)?'selected':'';?>>Manager</option>
                                            <option value="3" <?php echo($user->role == 3)?'selected':'';?>>Worker</option>
                                        </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group mt-2 mb-3">
                                            <input type="file" name="image" value="{{$user->image}}" class="dropify">
                                            <label>Privous Image</label>
                                            <img src="{{asset('uploads/staf_images/'.$user->image)}}" width="100">
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
@endsection