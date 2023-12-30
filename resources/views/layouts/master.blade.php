<!DOCTYPE html>
<html lang="en">
<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('Title','Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('public/assets/css/app.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/bundles/morris/morris.css')}}">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('public/assets/bundles/bootstrap-social/bootstrap-social.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/bundles/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('public/assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href='{{asset('public/assets/img/anp.png')}}' />
  <link rel="stylesheet" href="{{asset('public/assets/bundles/pretty-checkbox/pretty-checkbox.min.css')}}">
  @yield('styles')
</head>

<body>
  <div id="loader"></div>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          @can('sync facebook')
           <div>
             <a href="#"  class="btn btn-icon icon-left btn-primary rounded-sm" id="syncFacebook" type="button">
              
            <i class="fas fa-sync"></i>Facebook</a>
             <a href="#"  class="btn btn-icon icon-left btn-primary rounded-sm" id="syncTwitter" type="button">
              
            <i class="fas fa-sync"></i>Twitter </a>
             <a href="#"  class="btn btn-icon icon-left btn-primary rounded-sm" id="" type="button">
              @php
                $latest = \App\Models\Setting::latest()->first();
                $date = \Carbon\Carbon::parse($latest->sync_date);
              @endphp
            <i class="far fa-clock"></i>{{$date->diffForHumans()}}</a>
           </div>
          @endcan
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{auth()->user()->avatar?auth()->user()->avatar : asset('public/assets/img/user.png')}}"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">{{auth()->user()->name}}</div>
              <div class="dropdown-divider"></div>
               <a href="{{route('users.profile')}}" class="dropdown-item has-icon ">
                 <i class="fa-solid fa-gear"></i>
                Profile
              </a>
              <a href="" class="dropdown-item has-icon" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                 <i class="fa-solid fa-gear"></i>
                Settings
              </a>
              <a href="" class="dropdown-item has-icon" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                 <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                 </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            @php
            @endphp
            <a href="#"> <img alt="image" src="{{asset('public/assets/img/anp.png')}}" class="header-logo" /> <span
                class="logo-name">ANP SMMIS</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            @can('view admin dashboard')
            <li class="dropdown {{request()->routeIs('admin.dashboard') ? 'active' : ''}}">
              <a href="{{route('admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @endcan

            @can('view user')
            <li class="dropdown {{request()->routeIs('dashboard.users.all') ? 'active' : ''}}">
              <a href="{{route('dashboard.users.all')}}" class=" nav-link"><i
                  data-feather="users"></i><span>Users</span></a>
            </li>
            @endcan
            @can('view admin')
             <li class="dropdown {{request()->routeIs('dashboard.admins.all') ? 'active' : ''}}">
              <a href="{{route('dashboard.admins.all')}}" class=" nav-link"><i
                  data-feather="users"></i><span>Admins</span></a>
            </li>
            @endcan

            @can('view facebook posts')
             <li class="dropdown {{request()->routeIs('facebook.posts') ? 'active' : ''}}">
              <a href="{{route('facebook.posts')}}" class=" nav-link"><i
                  data-feather="facebook"></i><span>Facebook Posts</span></a>
            </li>
              <li class="dropdown {{request()->routeIs('twitter.tweets') ? 'active' : ''}}">
              <a href="{{route('twitter.tweets')}}" class=" nav-link"><i
                  data-feather="twitter"></i><span>Twitter Tweets</span></a>
            </li>
              <li class="dropdown {{request()->routeIs('instagram.posts') ? 'active' : ''}}">
              <a href="#" class=" nav-link"><i
                  data-feather="instagram"></i><span>Instagram Posts</span></a>
            </li>
            @endcan

            @can('view user dashboard')
            <li class="dropdown {{request()->routeIs('users.dashboard') ? 'active' : ''}}">
              <a href="{{route('users.dashboard')}}" class=" nav-link"><i
                  data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @endcan

            @can('view own posts')
            <li class="dropdown {{request()->routeIs('user.facebook.posts') ? 'active' : ''}}">
              <a href="{{route('user.facebook.posts')}}" class=" nav-link"><i
                  data-feather="facebook"></i><span>Facebook Posts</span></a>
            </li>
              <li class="dropdown {{request()->routeIs('name.twitter.tweets') ? 'active' : ''}}">
              <a href="{{route('name.twitter.tweets')}}" class=" nav-link"><i
                  data-feather="twitter"></i><span>Twitter Tweets</span></a>
            </li>


            @endcan

            @can('sync facebook')
             <li class="dropdown {{request()->routeIs('dashboard.posts.sync') ? 'active' : ''}}">
              <a href="{{route('dashboard.posts.sync')}}" class=" nav-link">
                <i data-feather="refresh-ccw"></i><span>Synchronization</span></a>
            </li>
            @endcan
              
            @can('view admin dashboard')
             <li class="dropdown {{request()->routeIs('reports.index') ? 'active' : ''}}">
              <a href="{{route('reports.index')}}" class=" nav-link">
                <i data-feather="file-text"></i><span>Reports</span></a>
            </li>
             <li class="dropdown {{request()->routeIs('dashboard.posts.categorize') ? 'active' : ''}}">
              <a href="{{route('dashboard.posts.categorize')}}" class=" nav-link">
                <i data-feather="list"></i><span>Categorize</span></a>
            </li>
             <li class="dropdown {{request()->routeIs('posts.settings') ? 'active' : ''}}">
              <a href="{{route('posts.settings')}}" class=" nav-link">
                <i data-feather="settings"></i><span>Settings</span></a>
            </li>
            @endcan
          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="#">Awami National Party</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


   function showLoader(){
    $('#loader').html(`<div class="loader"></div>`);
  }
  function hideLoader(){
    $('#loader').empty();
  }
  function showSwalMessage(icon,title,message,timeout = 3000){
    Swal.fire({
        icon: icon,
        title: title,
        timer: timeout,
        text: message,
    })
  }

  </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- General JS Scripts -->
  <script src="{{asset('public/assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('public/assets/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('public/assets/js/page/index.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('public/assets/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('public/assets/js/custom.js')}}"></script>
 <script src="{{asset('public/assets/bundles/datatables/datatables.min.js')}}"></script>
 <script src="{{asset('public/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('public/assets/bundles/morris/morris.min.js')}}"></script>
  <script src="{{asset('public/assets/bundles/morris/raphael-min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('public/assets/js/page/chart-morris.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{asset('public/assets/bundles/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('public/assets/bundles/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('public/assets/js/page/datatables.js')}}"></script>



   <script>
       $(document).ready(function(){
     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $("#syncFacebook").click(function(){
    var url='{{ route("sync.facebook.posts") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Sync Facebook Posts",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText:'Cancel',
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        type: 'POST',
        url: url,
        data: {},
        beforeSend: function () {
            showLoader()
        },
        success: function(response)
        {
            console.log(response);
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
                 setTimeout(function(){
                    location.reload(true)
                }, 3000);
            }else{
                showSwalMessage('error', "Error", "Something went Wrong! please try again!s")
            }
        },
        complete: function () {
            hideLoader()
        },
    });
    }
});

});



// Sync Twitter Tweets 
$("#syncTwitter").click(function(){
    var url='{{ route("sync.twitter.tweets") }}';
    Swal.fire({
    title: 'Are You Sure ?',
    text: "You want to Sync Twitter Tweets",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes',
    cancelButtonText:'Cancel',
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        type: 'POST',
        url: url,
        data: {},
        beforeSend: function () {
            showLoader()
        },
        success: function(response)
        {
            if(response.success){
                showSwalMessage('success', 'Success', response.message)
            }else{
                showSwalMessage('error', "Error", response.message)
            }
        },
        complete: function () {
            hideLoader()
             setTimeout(function(){
               location.reload(true)
              }, 3000);
        },
    });
    }
    }); 
  });


});




   </script>

</body>

@yield('scripts')
<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>