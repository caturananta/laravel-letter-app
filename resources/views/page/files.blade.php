@extends('layout.base')
@section('body_class')

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
    @include ('layout.sidebar')
    <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('layout.topbar')
                <!-- End of Topbar -->
            </div>

            <!-- Footer -->
        @include ('layout.footer')
        <!-- End of Footer -->
        </div>
    </div>
@stop
