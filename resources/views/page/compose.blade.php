@extends('layout.base')
@section('body_class')

    <link href="{{asset('css/compose.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />


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
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @elseif(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                            @php
                                Session::forget('error');
                            @endphp
                        </div>
                @endif

                <!-- Content Row -->
                    <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-8">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-body text-gray-600 small">
                                    <form id="letter-form" method="post" autocomplete="off"
                                          action="{{route('send-letter')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Pengirim</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-sm" type="text" name="sender" required="required">
                                                @if ($errors->has('sender'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('sender') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">No. Surat</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-sm" type="text" name="letterNo" required="required">
                                                @if ($errors->has('letterNo'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('letterNo') }}</span>
                                                @endif
                                            </div>
                                        </div>
{{--                                        <div class="form-group row">--}}
{{--                                            <label for="inputPassword" class="col-sm-2 col-form-label">Kepada</label>--}}
{{--                                            <div class="col-sm-10 autocomplete">--}}
{{--                                                <input type="text" name="destinationEmail"--}}
{{--                                                       class="form-control form-control-sm" id="destinationEmail">--}}
{{--                                                @if ($errors->has('destinationEmail'))--}}
{{--                                                    <span--}}
{{--                                                        class="text-danger">{{ $errors->first('destinationEmail') }}</span>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Surat</label>
                                            <div class="col-sm-10">
                                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                                    <input type="text" class="form-control form-control-sm" name="letter_date" required="required">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('letter_date'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('letter_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Sifat Surat</label>
                                            <div class="col-sm-10">
                                                <select form="letter-form" name="priority" class="form-control form-control-sm">
                                                    <option value="1">Biasa</option>
                                                    <option value="2" selected>Penting</option>
                                                    <option value="3">Sangat Penting</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">No. Agenda</label>
                                            <div class="col-sm-10">
                                                <input class="form-control form-control-sm" type="text" name="agenda_no" required="required">
                                                @if ($errors->has('agenda_no'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('agenda_no') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Tanggal Agenda</label>
                                            <div class="col-sm-10">
                                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy">
                                                    <input type="text" class="form-control form-control-sm" name="agenda_date" required="required">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                                @if ($errors->has('agenda_date'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('agenda_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Perihal</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="subjectEmail"
                                                       class="form-control form-control-sm" id="subjectEmail" required="required">
                                                @if ($errors->has('subjectEmail'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('subjectEmail') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Pesan</label>
                                            <textarea class="form-control" name="msg"
                                                      id="exampleFormControlTextarea1" rows="6"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary"><i
                                                class="fas fa-paper-plane"></i> Send
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Content Column -->
                        <div class="col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <span class="mb-0 font-weight-bold text-dark">Lampiran</span>
                                        </div>
                                        <div class="box-body"></div>
                                    </div>
                                </div>
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="fas fa-paperclip"></i>
                                        <p>Pilih atau tarik kesini</p>
                                    </div>
                                    <input form="letter-form" type="file" name="file_upload" class="dropzone ">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Footer -->
        @include ('layout.footer')
        <!-- End of Footer -->
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{asset('js/compose.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"/>
    <script !src="">
        $('.datepicker').datepicker({
            startDate: '0d'
        });
    </script>
@stop
