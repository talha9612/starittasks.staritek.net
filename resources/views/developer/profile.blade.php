@extends('layouts.developer.app')
@section('mytitle','add-task')
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#list"><i class="fa fa-user"></i>Profile</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#addnew"><i class="fa fa-edit"></i>Edit Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body p-0">
            <div class="container-fluid">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="list" role="tabpanel">
                    <div class="row clearfix">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Profile</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <tbody>
                                            <tr>
                                                <th>name</th>
                                                <td>{{ ucfirst($user->name) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ ucfirst($user->email) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $user->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ ucfirst($user->address) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>Active</td>
                                            </tr>
                                            <tr>
                                                <th>Date Of Birth</th>
                                                <td>{{date('Y-m-d', strtotime($user->dob))}}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td>
                                                    <?php
                                                        if($user->gender == 1){
                                                            echo ucfirst('male');
                                                        }else{
                                                            echo ucfirst('female');
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Image</th>
                                                <td><img src="{{asset('uploads/staf_images/'.$user->image)}}" style="width:100px;padding:5px;border:3px solid lightgray;" alt="Avatar"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Company</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <tbody>
                                            <tr>
                                                <th>name</th>
                                                <td>{{ ucfirst($company->name) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td>{{ ucfirst($company->email) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $company->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ ucfirst($company->address) }}</td>
                                            </tr>
                                                <th>Company Logo</th>
                                                <td><img src="{{asset('uploads/company_logos/'.$company->logo)}}" style="width:100px;padding:5px;border:3px solid lightgray;" alt="Avatar"></td>
                                            </tr>
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
                            <div class="col-sm-10">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Profile</h3>
                                        <div class="card-options ">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                                        </div>
                                    </div>
                                    <form class="card-body" method="post" action="{{url('/ceo/update-profile')}}" enctype="multipart/form-data">
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
                                                    <input type="email" name="email" id="check-email" value="{{$user->email}}" class="form-control">
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
                                                    <option value="4" <?php echo($user->role == 4)?'selected':'';?>>Ceo</option>
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
        </div>
@endsection
