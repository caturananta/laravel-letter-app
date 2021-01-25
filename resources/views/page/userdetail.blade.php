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

                <div class="col-md-9">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif
                        @if(Session::has('error'))
                            <div class="alert alert-success">
                                {{ Session::get('error') }}
                                @php
                                    Session::forget('error');
                                @endphp
                            </div>
                        @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{route('user-update')}}" method="POST" class="text-gray-600 small">
                                        @csrf
                                        <input type="hidden" value="{{$user->id}}" name="_id">
                                        <div class="form-group row">
                                            <label for="username" class="col-4 col-form-label">Nama</label>
                                            <div class="col-8">
                                                <input id="username" name="name" value="{{$user->name}}" class="form-control form-control-sm here" required="required" type="text">
                                                @if ($errors->has('name'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-4 col-form-label">Email</label>
                                            <div class="col-8">
                                                <input id="name" name="email" value="{{$user->email}}" class="form-control form-control-sm here" required="required" type="text">
                                                @if ($errors->has('email'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastname" class="col-4 col-form-label">Ganti password ?</label>
                                            <div class="form-check" style="margin-left: 12px; margin-top: 2px;">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            </div>
                                        </div>
                                        <div id="newpass" class="form-group row" style="display: none">
                                            <label for="lastname" class="col-4 col-form-label">Password Baru</label>
                                            <div class="col-8">
                                                <input name="password" autocomplete="on" class="form-control form-control-sm here" type="password">
                                                @if ($errors->has('password'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lastname" class="col-4 col-form-label">Aktif</label>
                                            <div class="custom-control custom-switch" style="margin-left: 12px;">
                                                <input name="aktif" type="checkbox" class="custom-control-input" id="customSwitch1"
                                                    @if($user->user_status == 'Y')
                                                    checked
                                                    @else
                                                    @endif
                                                >
                                                <label class="custom-control-label" for="customSwitch1"></label>
                                            </div>
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-sm btn-primary">Update</button>
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
        $("#defaultCheck1").change(function() {
            if(this.checked) {
                $('#newpass').css('display', 'none').fadeIn('slow');
            }
            else {
                $('#newpass').css('display', 'none').fadeOut('slow');
            }
        });
    </script>
@stop

