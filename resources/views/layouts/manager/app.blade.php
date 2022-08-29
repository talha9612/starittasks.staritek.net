<!doctype html>
<html lang="en" dir="ltr">

<!-- soccer/project/  07 Jan 2020 03:36:49 GMT -->
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="icon" href="favicon.ico" type="image/x-icon"/>

<title>TaskManager::@yield('mytitle') </title>

<!-- Bootstrap Core and vandor -->
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Plugins css -->
<link rel="stylesheet" href="{{asset('assets/plugins/charts-c3/c3.min.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<!-- Core css -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/theme1.css')}}"/>
<script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body class="font-montserrat">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
    </div>
</div>

<div id="main_content">

    <div id="header_top" class="header_top">
        <div class="container">
            <div class="hleft">
                <a class="header-brand" href="index-2.html"><i class="fa fa-soccer-ball-o brand-logo"></i></a>
                <div class="dropdown">
                    <a href="javascript:void(0)" class="nav-link user_btn"><img class="avatar" src="{{asset('uploads/staf_images/'.Auth::user()->image)}}" alt="" data-toggle="tooltip" data-placement="right" title="User Menu"/></a>
                  
                </div>
            </div>
            <div class="hright">
                <div class="dropdown">
                    <a href="javascript:void(0)" class="nav-link icon settingbar"><i class="fa fa-gear fa-spin" data-toggle="tooltip" data-placement="right" title="Settings"></i></a>
                    <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i class="fa  fa-align-left"></i></a>
                </div>            
            </div>
        </div>
    </div>

    <div id="rightsidebar" class="right_sidebar">
        <a href="javascript:void(0)" class="p-3 settingbar float-right"><i class="fa fa-close"></i></a>
        <div class="p-4">
            <div class="mb-4">
                <h6 class="font-14 font-weight-bold text-muted">Font Style</h6>
                <div class="custom-controls-stacked font_setting">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-opensans">
                        <span class="custom-control-label">Open Sans Font</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-montserrat" checked="">
                        <span class="custom-control-label">Montserrat Google Font</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="font" value="font-roboto">
                        <span class="custom-control-label">Robot Google Font</span>
                    </label>
                </div>
            </div>
            <hr>
            <div>
                <h6 class="font-14 font-weight-bold mt-4 text-muted">General Settings</h6>
                <ul class="setting-list list-unstyled mt-1 setting_switch">
                    <li>
                        <label class="custom-switch">
                            <span class="custom-switch-description">Night Mode</span>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-darkmode"  data-id="{{ \App\Helpers\AppHelper::instance()->GetTheme()->id}}" {{ \App\Helpers\AppHelper::instance()->GetTheme()->theme_mode == 1? 'checked':''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-switch">
                            <span class="custom-switch-description">Header Dark</span>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-pageheader" data-id="{{ \App\Helpers\AppHelper::instance()->GetTheme()->id}}" {{ \App\Helpers\AppHelper::instance()->GetTheme()->header_dark == 1? 'checked':''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-switch">
                            <span class="custom-switch-description">Min Sidebar Dark</span>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-min_sidebar" data-id="{{ \App\Helpers\AppHelper::instance()->GetTheme()->id}}" {{ \App\Helpers\AppHelper::instance()->GetTheme()->min_sidebar_dark == 1? 'checked':''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-switch">
                            <span class="custom-switch-description">Sidebar Dark</span>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-sidebar" data-id="{{ \App\Helpers\AppHelper::instance()->GetTheme()->id}}" {{ \App\Helpers\AppHelper::instance()->GetTheme()->sidebar_dark == 1? 'checked':''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-switch">
                            <span class="custom-switch-description">Box Shadow</span>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input btn-boxshadow" data-id="{{ \App\Helpers\AppHelper::instance()->GetTheme()->id}}" {{ \App\Helpers\AppHelper::instance()->GetTheme()->box_shadow == 1? 'checked':''}}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </li>
                </ul>
            </div>
            <hr>
           
        </div>
    </div>

    <div class="user_div">
        <h5 class="brand-name mb-4">Manager {{Auth::user()->name}}<a href="javascript:void(0)" class="user_btn"><i class="fa fa-times" aria-hidden="true"></i></a></h5>
        <div class="card-body">
            <a href="page-profile.html"><img class="card-profile-img" src="{{asset('assets/images/sm/avatar1.jpg')}}" alt=""></a>
            <h6 class="mb-0">{{Auth::user()->name}}</h6>
            <span>{{Auth::user()->name}}.{{Auth::user()->email}}</span>
          
            <hr>
           
        </div>
    </div>

    <div id="left-sidebar" class="sidebar ">
        <h5 class="brand-name">Manager {{Auth::user()->name}} <a href="javascript:void(0)" class="menu_option float-right"><i class="fa fa-th-large font-16" data-toggle="tooltip" data-placement="left" title="Grid & List Toggle"></i></a></h5>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul class="metismenu">
                <li class="g_heading">Project</li>
                <li class="active"><a href="/manager/"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                <li><a href="/manager/users"><i class="fa fa-user"></i><span>Team Members</span></a></li>
                <li>
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-lock"></i><span>Work</span></a>
                    <ul>
                        <li><a href="/manager/projects">Project</a></li>
                        <li><a href="/manager/tasks">Tasks</a></li>
                        <!-- <li><a href="forgot-password.html">Tasks Board</a></li> -->
                    </ul>
                </li>
                <!-- <li><a href="app-setting.html"><i class="fa fa-gear"></i><span>Setting</span></a></li> -->
            </ul>
        </nav>        
    </div>

    <div class="page">
        <div id="page_top" class="section-body top_dark">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="left">
                        <a href="javascript:void(0)" class="icon menu_toggle mr-3"><i class="fa  fa-align-left"></i></a>
                        <h1 class="page-title">Dashboard</h1>                        
                    </div>
                    <div class="right">
                        <div class="input-icon xs-hide">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-icon-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        </div>
                        <div class="notification d-flex">
                           
                           
                            <div class="dropdown d-flex">
                                <a class="nav-link icon d-none d-md-flex btn btn-default btn-icon ml-2" data-toggle="dropdown"><i class="fa fa-user"></i></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="page-profile.html"><i class="dropdown-icon fa fa-user"></i> Profile</a>
                                    <a class="dropdown-item" href="app-setting.html"><i class="dropdown-icon fa fa-gear"></i> Settings</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="dropdown-icon fa fa-sign-out"></i> {{ __('Logout') }}
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </a>
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
                    <div class="col-md-12">
                        @include('layouts.flashmsg')
                    </div>
                </div>
            </div>
        </div>
        @yield('content')     
        <div class="section-body">
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <a href="templateshub.net">Star Automation</a>
                        </div>
                       
                    </div>
                </div>
            </footer>
        </div>
    </div>    
</div>

<script src="{{asset('assets/bundles/lib.vendor.bundle.js')}}"></script>

<script src="{{asset('assets/bundles/apexcharts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/counterup.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/knobjs.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/c3.bundle.js')}}"></script>
<script src="{{asset('js/customjs-manager.js')}}"></script>
<script src="{{asset('assets/js/core.js')}}"></script>

<script src="{{asset('assets/js/page/project-index.js')}}"></script>
</body>

<!-- soccer/project/  07 Jan 2020 03:37:22 GMT -->
</html>
