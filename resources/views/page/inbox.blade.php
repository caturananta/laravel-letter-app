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
                                    <form action="{{route('search')}}" method="GET" class="form-inline mr-auto w-100 navbar-search">
                                        @csrf
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
                                <a class="nav-link btn-filter" role="button" aria-expanded="false" href="/inbox">
                                    <i class="fas fa-list fa-sm"></i>
                                    <span class="ml-2 d-none d-lg-inline text-gray-600 small">Semua</span>
                                </a>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <li class="nav-item no-arrow mx-1">
                                <a class="nav-link btn-filter" role="button" aria-expanded="false" data-filter="Y">
                                    <i class="fas fa-glasses fa-sm"></i>
                                    <span class="ml-2 d-none d-lg-inline text-gray-600 small">Belum dibaca</span>
                                </a>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>
                        </ul>

                        <!-- Topbar Search -->
                        <form
                            action="{{route('search')}}" method="GET"
                            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            @csrf
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
                                            @if($inbox != null)
                                                @foreach($inbox as $letter)
                                                    <!-- row -->
                                                    <tr data-href="{{route("detail", ['id' =>$letter->_id])}}" id="tr_inbox"
                                                        @if($letter->review_date == null)
                                                        data-status="Y"
                                                        @else
                                                        data-status="N"
                                                        @endif
                                                        >
                                                        <!-- label -->
                                                        <td class="pl-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                       class="custom-control-input except" id="cst2"/>
                                                                <label class="custom-control-label except" for="cst2">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <!-- label -->
                                                        <td class="pl-3">
                                                            @if($letter->status == 'biasa')
                                                                <span
                                                                    class="badge badge-info">{{$letter->status}}</span>
                                                            @elseif($letter->status == 'penting')
                                                                <span
                                                                    class="badge badge-primary">{{$letter->status}}</span>
                                                            @else <span
                                                                class="badge badge-danger">{{$letter->status}}</span>
                                                            @endif
                                                        </td>
                                                        <!-- User -->
                                                        <td>
                                                            @if(Auth::user()->user_role == 2)
                                                                @if($letter->review_date != null)
                                                                    <span
                                                                        class="mb-0 text-muted font-weight-light">{{$letter->letter_from_name}}</span>
                                                                @else
                                                                    <span
                                                                        class="text-dark font-weight-bold">{{$letter->letter_from_name}}</span>
                                                                @endif
                                                            @elseif(Auth::user()->user_role == 3)
                                                                @if($letter->read_status != null)
                                                                    <span
                                                                        class="mb-0 text-muted font-weight-light">{{$letter->letter_from_name}}</span>
                                                                @else
                                                                    <span
                                                                        class="text-dark font-weight-bold">{{$letter->letter_from_name}}</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <!-- Message -->
                                                        <td>
                                                            <a class="link" href="/detail/{{$letter->_id}}">
                                                                @if(Auth::user()->user_role == 2)
                                                                    @if($letter->review_date != null)
                                                                        <span
                                                                            class="mb-0 text-muted font-weight-light">{{$letter->letter_sub}}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-dark font-weight-bold">{{$letter->letter_sub}}</span>
                                                                    @endif
                                                                @elseif(Auth::user()->user_role == 3)
                                                                    @if($letter->read_status != null)
                                                                        <span
                                                                            class="mb-0 text-muted font-weight-light">{{$letter->letter_sub}}</span>
                                                                    @else
                                                                        <span
                                                                            class="text-dark font-weight-bold">{{$letter->letter_sub}}</span>
                                                                    @endif
                                                                @endif

                                                            </a>
                                                        </td>
                                                        <!-- Time -->
                                                        <td>
                                                            @if(Auth::user()->user_role == 2)
                                                                @if($letter->review_date != null)
                                                                    <span
                                                                        class="mb-0 text-muted font-weight-light">{{$letter->created_date}}</span>
                                                                @else
                                                                    <span
                                                                        class="text-dark font-weight-bold">{{$letter->created_date}}</span>
                                                                @endif
                                                            @elseif(Auth::user()->user_role == 3)
                                                                @if($letter->read_status != null)
                                                                    <span
                                                                        class="mb-0 text-muted font-weight-light">{{$letter->created_date}}</span>
                                                                @else
                                                                    <span
                                                                        class="text-dark font-weight-bold">{{$letter->created_date}}</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- row -->
                                                <tr>
                                                    <!-- label -->
                                                    <td class="pl-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="cst1"/>
                                                            <label class="custom-control-label"
                                                                   for="cst1">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td class="pl-3">
                                                        <span class="badge badge-success">Low</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="mb-0 text-muted font-weight-light ">Hritik Roshan</span>
                                                    </td>
                                                    <!-- Message -->
                                                    <td>
                                                        <a class="link" href="/detail/1">
                                                            <span class="text-muted font-weight-light">Lorem ipsum perspiciatis Lorem ipsum perspiciatis Lorem ipsum perspiciatis</span>
                                                        </a>
                                                    </td>
                                                    <!-- Time -->
                                                    <td class="text-muted font-weight-light">19 Okt</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Pagination Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $inbox->links() }}
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
    <script src="{{asset('js/inbox.js')}}"></script>
@stop


