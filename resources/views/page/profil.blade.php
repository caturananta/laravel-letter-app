@extends('layout.base')
@section('body_class')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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

                    <div class="col-md-9">
                        @if(Session::has('success'))
                            <script>
                                Swal.fire({
                                    text: 'Berhasil mengubah password, silahkan login kembali',
                                    icon: 'success',
                                    allowOutsideClick: false,
                                    confirmButtonText: `Ok`,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = "{{URL::to('logout')}}"
                                    }
                                })
                            </script>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                                @php
                                    Session::forget('error');
                                @endphp
                            </div>
                        @endif
                        @if(session('errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{route('profil-update')}}" method="POST"
                                              class="text-gray-600 small">
                                            @csrf
                                            <input type="hidden" name="_id" value="{{Auth::user()->id}}">
                                            <div class="form-group row">
                                                <label for="username" class="col-sm-4 col-form-label">Nama</label>
                                                <div class="col-sm-8">
                                                    <input disabled id="username" name="name"
                                                           value="{{Auth::user()->name}}"
                                                           class="form-control form-control-sm here" required="required"
                                                           type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-4 col-form-label">Email</label>
                                                <div class="col-sm-8">
                                                    <input id="name" disabled name="email"
                                                           value="{{Auth::user()->email}}"
                                                           class="form-control form-control-sm here" required="required"
                                                           type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lastname" class="col-sm-4 col-form-label">Ganti password
                                                    ?</label>
                                                <div class="form-check col-sm-4"
                                                     style="margin-left: 12px; margin-top: 2px; margin-bottom: 10px;">
                                                    <input name="oldpassword" class="form-check-input" type="checkbox"
                                                           id="defaultCheck1">
                                                </div>
                                            </div>
                                            <div class="newpass form-group row" style="display: none">
                                                <label for="lastname" class="col-sm-4 col-form-label">Password
                                                    Lama</label>
                                                <div class="col-sm-8">
                                                    <input name="oldpassword" autocomplete="on" required="required"
                                                           class="form-control form-control-sm here" type="password">
                                                </div>
                                            </div>
                                            <div class="newpass form-group row" style="display: none">
                                                <label for="lastname" class="col-sm-4 col-form-label">Password
                                                    Baru</label>
                                                <div class="col-sm-8">
                                                    <input name="password" autocomplete="on" required="required"
                                                           class="form-control form-control-sm here" type="password">
                                                </div>
                                            </div>
                                            <div class="newpass form-group row" style="display: none">
                                                <label for="lastname" class="col-sm-4 col-form-label">Konfirmasi
                                                    Password </label>
                                                <div class="col-sm-8">
                                                    <input name="password_confirmation" autocomplete="on"
                                                           required="required"
                                                           class="form-control form-control-sm here" type="password">
                                                </div>
                                            </div>
                                            <button id="btnsubmit" name="submit" type="submit"
                                                    class="btn btn-sm btn-primary" style="display: none">Update
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

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

@section('scripts')
    <script !src="">
        $("#defaultCheck1").change(function () {
            if (this.checked) {
                $('.newpass').css('display', 'none').fadeIn('slow');
                $('#btnsubmit').css('display', 'none').fadeIn('slow');
            } else {
                $('#btnsubmit').css('display', 'none').fadeOut('slow');
                $('.newpass').css('display', 'none').fadeOut('slow');
            }
        });
    </script>
@stop
