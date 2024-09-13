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
                                                class="fa fa-list-ul"></i>Company List</a></li>
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
                                                            @if ($user->status == 1)
                                                                <label class="custom-switch m-0">
                                                                    <input type="checkbox" value="0"
                                                                        class="custom-switch-input developer-change-status-company"
                                                                        data-id="{{ $user->id }}" data-toggle="toggle"
                                                                        data-onstyle="outline-success" checked>
                                                                    <span class="custom-switch-indicator"></span>
                                                                </label>
                                                            @else
                                                                <label class="custom-switch m-0">
                                                                    <input type="checkbox" value="0"
                                                                        class="custom-switch-input developer-change-status-company"
                                                                        data-id="{{ $user->id }}" data-toggle="toggle"
                                                                        data-onstyle="outline-success">
                                                                    <span class="custom-switch-indicator"></span>
                                                                </label>
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
    <script>
        $(document).ready(function() {
            $('.developer-change-status-company').change(function() {
                var checkbox = $(this);
                var userId = checkbox.data('id'); // Get user ID from data attribute
                var status = checkbox.is(':checked') ? 1 : 0; // Determine the new status

                console.log('User ID:', userId);
                console.log('Status:', status);

                $.ajax({
                    url: '/update-company-status',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId,
                        status: status
                    },
                    success: function(response) {
                        console.log('Response:', response);
                        if (response.success) {
                            console.log('Status updated successfully.');
                        } else {
                            console.log('Failed to update status:', response.error);
                            checkbox.prop('checked', !checkbox.is(':checked'));
                        }
                    },
                    error: function(xhr) {
                        console.log('An error occurred:', xhr.statusText, xhr.responseText);
                    }
                });

            });
        });
    </script>

@endsection
