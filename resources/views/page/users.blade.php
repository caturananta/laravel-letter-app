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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <a href="{{route('user-new')}}" class="btn btn-primary btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                  <i class="fas fa-plus-square"></i>
                                </span>
                                <span class="text">Tambah pengguna</span>
                            </a>
                        </div>
                    </div>

                    <table class="table table-hover table-responsive-sm text-gray-600 small">
                        <thead>
                        <tr class="text-dark">
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users != null)
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>@if($user->user_status == 'Y')
                                            <span class="badge badge-pill badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Non Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route("user-detail", ['id' => $user->id])}}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
        @include ('layout.footer')
        <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
@stop


