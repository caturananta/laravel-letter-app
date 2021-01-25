<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Sidora <sup>App</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

@if(Auth::user()->user_role == 1)

    <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/compose">
                <i class="fas fa-feather-alt"></i>
                <span>Compose</span></a>
        </li>

@endif

<!-- Divider -->
    <hr class="sidebar-divider">

@if(Auth::user()->user_role == 2 || Auth::user()->user_role == 3)
    <!-- Heading -->
        <div class="sidebar-heading">
            MAIL
        </div>

        <!-- Nav Item - Inbox -->
        <li class="nav-item">
            <a class="nav-link" href="/inbox">
                <i class="fas fa-envelope"></i>
                <span>Inbox</span></a>
        </li>

@endif

@if(Auth::user()->user_role == 1)
    <!-- Heading -->
        <div class="sidebar-heading">
            MAIL
        </div>
        <!-- Nav Item - Sent -->
        <li class="nav-item">
            <a class="nav-link" href="/sent">
                <i class="fas fa-paper-plane"></i>
                <span>Sent</span></a>
        </li>
@endif

@if(Auth::user()->user_role == 0)
    <!-- Heading -->
        <div class="sidebar-heading">
            MANAGEMEN
        </div>
        <!-- Nav Item - Sent -->
        <li class="nav-item">
            <a class="nav-link" href="/user-management">
                <i class="fas fa-users"></i>
                <span>Pengguna</span></a>
        </li>
@endif

    <li class="nav-item">
        <a class="nav-link" href="{{route('profil')}}">
            <i class="fas fa-user"></i>
            <span>Profil</span></a>
    </li>

<!-- Nav Item - Files -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link" href="/files">--}}
{{--            <i class="fas fa-folder-open"></i>--}}
{{--            <span>Files</span></a>--}}
{{--    </li>--}}

<!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<script src="{{asset('js/sidebar.js')}}"></script>
