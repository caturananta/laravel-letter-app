@extends('layout.base')
@section('body_class')

<style>
    @media only screen and (max-width: 900px) {
        .table {
            table-layout:fixed;
        }

        .one{
            display: none;
        }

        .two{
            display: block;
        }
    }
</style>

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

                    <!-- Page Heading -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-1 static-top shadow">
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto o-hidden">

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                            <li class="nav-item dropdown no-arrow d-sm-none">
                                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-search fa-fw"></i>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                     aria-labelledby="searchDropdown">
                                    <form action="{{route('sent-search')}}" method="GET" class="form-inline mr-auto w-100 navbar-search">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control bg-light border-0 small"
                                                   placeholder="Search for..." aria-label="Search"
                                                   aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>

                            <li class="nav-item no-arrow mx-1">
                                <a class="nav-link btn-filter" role="button" aria-expanded="false" href="/sent">
                                    <i class="fas fa-list fa-sm"></i>
                                    <span class="ml-2 d-none d-lg-inline text-gray-600 small">Semua</span>
                                </a>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

{{--                            <li class="nav-item no-arrow mx-1">--}}
{{--                                <a class="nav-link btn-filter" role="button" aria-expanded="false" data-filter="Y">--}}
{{--                                    <i class="fas fa-glasses fa-sm"></i>--}}
{{--                                    <span class="ml-2 d-none d-lg-inline text-gray-600 small">Belum dibaca</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <div class="topbar-divider d-none d-sm-block"></div>--}}
                        </ul>

                        <!-- Topbar Search -->
                        <form action="{{route('sent-search')}}" method="GET"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control bg-light border-0 small"
                                       placeholder="Search for..." aria-label="Search"
                                       aria-describedby="basic-addon2">
                            </div>
                        </form>
                    </nav>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-12">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table email-table table-hover v-middle mb-0 text-sm">
                                            <tbody>
                                            @if($letter_sent != null)
                                                @foreach($letter_sent as $letter)
                                            <!-- row -->
                                            <tr data-href="/detail/{{$letter->_id}}">
                                                <!-- label -->
                                                <td class="pl-3 one">
                                                    @if($letter->status == 'biasa')
                                                        <span class="badge badge-info">{{$letter->status}}</span>
                                                    @elseif($letter->status == 'penting')
                                                        <span class="badge badge-primary">{{$letter->status}}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{$letter->status}}</span>
                                                    @endif
                                                </td>
                                                <td class="two">
                                                    <span class="mb-0 text-muted font-weight-light ">To : {{$letter->letter_to_name}}</span>
                                                </td>
                                                <!-- Message -->
                                                <td class="two">
                                                    <a class="link" href="/detail/{{$letter->_id}}">
                                                        <span class="text-muted font-weight-light">{{$letter->letter_sub}}</span>
                                                    </a>
                                                </td>
                                                <!-- Time -->
                                                <td class="text-muted font-weight-light one">{{$letter->created_date}}</td>
                                            </tr>
                                            </tbody>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Pagination Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{ $letter_sent->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

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

@section('scripts')
    <script src="{{asset('js/sent.js')}}"></script>
@stop


