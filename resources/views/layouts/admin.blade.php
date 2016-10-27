<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!--Title and Icon-->
        <title>@yield('title') | Teesside University Archers</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!--Google Fonts-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

        <!--Bootstrap and Main Styles-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/preloader.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/data-tables.css') }}">
        @stack('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-theme.css') }}">
    </head>

    <body class="theme-orange">
        <!--Page Loader-->
        @include('partials.loader')

        <!--Overlay For Sidebars-->
        <div class="overlay"></div>

        <!--Search Bar-->
        {{--<div class="search-bar">--}}
            {{--<div class="search-icon">--}}
                {{--<i class="material-icons">search</i>--}}
            {{--</div>--}}
            {{--<input type="text" placeholder="START TYPING...">--}}
            {{--<div class="close-search">--}}
                {{--<i class="material-icons">close</i>--}}
            {{--</div>--}}
        {{--</div>--}}

        <!--Top Bar-->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="{{ url('/') }}">Teesside University Archers | Committee Tools</a>
                </div>
                {{--<div class="collapse navbar-collapse" id="navbar-collapse">--}}
                    {{--<ul class="nav navbar-nav navbar-right">--}}
                        {{--<!--Show Search-->--}}
                        {{--<li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>--}}

                        {{--<!--Notifications-->--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">--}}
                                {{--<i class="material-icons">notifications</i>--}}
                                {{--<span class="label-count">?</span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li class="header">NOTIFICATIONS</li>--}}
                                {{--<li class="body">--}}
                                    {{--<ul class="menu">--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-light-green">--}}
                                                    {{--<i class="material-icons">person_add</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4>12 new members joined</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> 14 mins ago--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-cyan">--}}
                                                    {{--<i class="material-icons">add_shopping_cart</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4>4 sales made</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> 22 mins ago--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-red">--}}
                                                    {{--<i class="material-icons">delete_forever</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4><b>Nancy Doe</b> deleted account</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> 3 hours ago--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-orange">--}}
                                                    {{--<i class="material-icons">mode_edit</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4><b>Nancy</b> changed name</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> 2 hours ago--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-blue-grey">--}}
                                                    {{--<i class="material-icons">comment</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4><b>John</b> commented your post</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> 4 hours ago--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-light-green">--}}
                                                    {{--<i class="material-icons">cached</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4><b>John</b> updated status</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> 3 hours ago--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<div class="icon-circle bg-purple">--}}
                                                    {{--<i class="material-icons">settings</i>--}}
                                                {{--</div>--}}
                                                {{--<div class="menu-info">--}}
                                                    {{--<h4>Settings updated</h4>--}}
                                                    {{--<p>--}}
                                                        {{--<i class="material-icons">access_time</i> Yesterday--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li class="footer">--}}
                                    {{--<a href="javascript:void(0);">View All Notifications</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}

                        {{--<!--Tasks-->--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">--}}
                                {{--<i class="material-icons">flag</i>--}}
                                {{--<span class="label-count">?</span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu">--}}
                                {{--<li class="header">TASKS</li>--}}
                                {{--<li class="body">--}}
                                    {{--<ul class="menu tasks">--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<h4>--}}
                                                    {{--Footer display issue--}}
                                                    {{--<small>32%</small>--}}
                                                {{--</h4>--}}
                                                {{--<div class="progress">--}}
                                                    {{--<div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<h4>--}}
                                                    {{--Make new buttons--}}
                                                    {{--<small>45%</small>--}}
                                                {{--</h4>--}}
                                                {{--<div class="progress">--}}
                                                    {{--<div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<h4>--}}
                                                    {{--Create new dashboard--}}
                                                    {{--<small>54%</small>--}}
                                                {{--</h4>--}}
                                                {{--<div class="progress">--}}
                                                    {{--<div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<h4>--}}
                                                    {{--Solve transition issue--}}
                                                    {{--<small>65%</small>--}}
                                                {{--</h4>--}}
                                                {{--<div class="progress">--}}
                                                    {{--<div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="javascript:void(0);">--}}
                                                {{--<h4>--}}
                                                    {{--Answer GitHub questions--}}
                                                    {{--<small>92%</small>--}}
                                                {{--</h4>--}}
                                                {{--<div class="progress">--}}
                                                    {{--<div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</li>--}}
                                {{--<li class="footer">--}}
                                    {{--<a href="javascript:void(0);">View All Tasks</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}

                        {{--<!--Menu-->--}}
                        {{--<li class="pull-right">--}}
                            {{--<a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </nav>

        <!--Side Bars-->
        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- User Info -->
                <div class="user-info">
                    <div class="image">
                        <img src="{{ $user && $user->picture_url? $user->picture_url: asset('img/user-profile-default.png') }}" width="48" height="48" alt="User" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $user? $user->name:null }}</div>
                        <div class="email">{{ $user? $user->email:null }}</div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ route('admin.users.show', $user->id) }}"><i class="material-icons">face</i> View Profile</a></li>
                                <li><a href="{{ route('admin.users.edit', $user->id) }}"><i class="material-icons">mode_edit</i> Edit Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/logout') }}"><i class="material-icons">input</i>Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Menu -->
                @include('admin._navigation')

                <!-- Footer -->
                <div class="legal">
                    <div class="copyright">
                        &copy; {{ date('Y') }} <a href="javascript:void(0);">Teesside University Archers</a>
                    </div>
                    <div class="version">
                        <b>Version: </b> {{ json_decode(file_get_contents(base_path() . '/composer.json'))->version }}
                    </div>
                </div>
            </aside>

            <!-- Right Sidebar -->
            <aside id="rightsidebar" class="right-sidebar">
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade" id="settings">
                        <div class="demo-settings">
                            <p>GENERAL SETTINGS</p>
                            <ul class="setting-list">
                                <li>
                                    <span>Report Panel Usage</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                                <li>
                                    <span>Email Redirect</span>
                                    <div class="switch">
                                        <label><input type="checkbox"><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                            <p>SYSTEM SETTINGS</p>
                            <ul class="setting-list">
                                <li>
                                    <span>Notifications</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                                <li>
                                    <span>Auto Updates</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                            <p>ACCOUNT SETTINGS</p>
                            <ul class="setting-list">
                                <li>
                                    <span>Offline</span>
                                    <div class="switch">
                                        <label><input type="checkbox"><span class="lever"></span></label>
                                    </div>
                                </li>
                                <li>
                                    <span>Location Permission</span>
                                    <div class="switch">
                                        <label><input type="checkbox" checked><span class="lever"></span></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>
        </section>

        <!--Content-->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>

        <!--Scripts-->
        <script src="{{ asset('js/vendor.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        @stack('scripts')

        <!--Google Analytics-->
        @include('partials.analytics')
    </body>

</html>