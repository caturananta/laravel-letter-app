@extends('layout.base')
@section('body_class')

    <link href="{{asset('css/timeline.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/comment.css')}}" rel="stylesheet" type="text/css">

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
            @if($data['letter_detail'] != null)
                <!-- Begin Page Content -->
                    <div class="container-fluid">
                        @if(Auth::user()->user_role == 2 || Auth::user()->user_role == 1)
                            @if($data['letter_detail']->forward_status=='Y')
                                <div class="alert alert-success">
                                    Diteruskan ke {{$data['letter_detail']->letter_to_name}}
                                </div>
                            @elseif($data['letter_detail']->forward_status=='N')
                                <div class="alert alert-danger">
                                    Tidak Diteruskan ke Kepala Biro
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Belum Diteruskan ke Kepala Biro
                                </div>
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <form id="sec-form" method="post" action="{{route('manage-letter')}}">
                                            @csrf
                                            <input name="_id" type="hidden" value={{$data['letter_detail']->status_id}}>
                                            <input name="_rid" type="hidden" value={{$data['letter_detail']->rid}}>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Pengirim</label>
                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="{{$data['letter_detail']->sender}}"
                                                           class="form-control form-control-sm" id="email_pelapor"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">No. Surat</label>
                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="{{$data['letter_detail']->letter_no}}"
                                                           class="form-control form-control-sm" id="email_pelapor"
                                                           disabled>
                                                </div>
                                            </div>
{{--                                            <div class="form-group row">--}}
{{--                                                <label for="inputPassword" class="col-sm-4 col-form-label">Kepada</label>--}}
{{--                                                <div class="col-sm-8">--}}
{{--                                                    <input type="text" placeholder="{{$data['letter_detail']->letter_to_name}}"--}}
{{--                                                           class="form-control form-control-sm" id="email_pelapor"--}}
{{--                                                           disabled>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Tanggal Surat</label>
                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="{{$data['letter_detail']->letter_date}}"
                                                           class="form-control form-control-sm" id="subjek_laporan"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-4 col-form-label">Disposisi ke</label>
                                                <div class="col-sm-8">
                                                    @if($data['letter_detail']->forward_status== null)
                                                        <select name="forward_email" class="form-control form-control-sm">
                                                            <option value=></option>
                                                            @foreach($data['users'] as $user)
                                                                <option value={{$user->id}}>{{$user->email}}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <input type="text" placeholder="{{$data['letter_detail']->letter_to_name}}"
                                                               class="form-control form-control-sm"
                                                               disabled>
                                                    @endif
                                                        @if ($errors->has('forward_email'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('forward_email') }}</span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-4 col-form-label">Sifat Surat</label>
                                                <div class="col-sm-8">
                                                    @if($data['letter_detail']->letter_to_name == 1)
                                                        <input type="text" placeholder="Biasa"
                                                               class="form-control form-control-sm"
                                                               disabled>
                                                    @elseif($data['letter_detail']->letter_to_name == 2)
                                                        <input type="text" placeholder="Penting"
                                                               class="form-control form-control-sm"
                                                               disabled>
                                                    @else
                                                        <input type="text" placeholder="Sangat Penting"
                                                               class="form-control form-control-sm"
                                                               disabled>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Tanggal Agenda</label>
                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="{{$data['letter_detail']->agenda_date}}"
                                                           class="form-control form-control-sm" id="agenda_date"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">No. Agenda</label>
                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="{{$data['letter_detail']->agenda_no}}"
                                                           class="form-control form-control-sm" id="agenda_no"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPassword"
                                                       class="col-sm-4 col-form-label">Perihal</label>
                                                <div class="col-sm-8">
                                                    <input type="text" placeholder="{{$data['letter_detail']->letter_sub}}"
                                                           class="form-control form-control-sm" id="subjek_laporan"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Pesan</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"
                                                          disabled>{{$data['letter_detail']->letter_msg}}</textarea>
                                            </div>

                                            <hr>
                                            @if($data['letter_detail']->file_loc != null)
                                            <h6><i class="fa fa-paperclip mr-2"></i> Lampiran <span>(1)</span></h6>
                                            <div class="row">
                                                <div class="col-sm-4 col-md-3">
                                                    <a target="_blank" href="{{$data['letter_detail']->file_loc."/".$data['letter_detail']->file_name}}">
                                                        <img
                                                            @if(strpos($data['letter_detail']->file_name, '.xls') !== false || strpos($data['letter_detail']->file_name, '.xlsx') !== false)
                                                            src="{{asset('/img/excel.png')}}"
                                                            @elseif(strpos($data['letter_detail']->file_name, '.pdf') !== false)
                                                            src="{{asset('/img/pdf.png')}}"
                                                            @elseif(strpos($data['letter_detail']->file_name, '.docx') !== false || strpos($data['letter_detail']->file_name, '.doc') !== false)
                                                            src="{{asset('/img/word.png')}}"
                                                            @elseif(strpos($data['letter_detail']->file_name, '.png') !== false || strpos($data['letter_detail']->file_name, '.jpg') !== false || strpos($data['letter_detail']->file_name, '.jpeg') !== false)
                                                            src="{{asset('/img/gallery.png')}}"
                                                            @else
                                                            src="{{asset('/img/document.png')}}"
                                                            @endif
                                                            alt="attachment" class="img-thumbnail"> </a>
                                                    {{$data['letter_detail']->file_name}}
                                                </div>
                                            </div>
                                            @endif
                                            <hr>
                                            @if(Auth::user()->user_role == 2)
                                                @if($data['letter_detail']->forward_status == 'N' || $data['letter_detail']->forward_status == 'Y')
                                                    <button name="submit" type="submit"
                                                            class="btn btn-sm btn-outline-primary" disabled><i
                                                            class="fas fa-paper-plane"></i> Teruskan
                                                    </button>
{{--                                                    <button name="cancel" type="submit"--}}
{{--                                                            class="btn btn-sm btn-outline-danger" disabled>Batalkan--}}
{{--                                                    </button>--}}
                                                @else
                                                    <button name="submit" type="submit"
                                                            class="btn btn-sm btn-outline-primary"><i
                                                            class="fas fa-paper-plane"></i> Teruskan
                                                    </button>
{{--                                                    <button name="cancel" type="submit"--}}
{{--                                                            class="btn btn-sm btn-outline-danger">Batalkan--}}
{{--                                                    </button>--}}
                                                @endif
                                            @endif
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <ul class="timeline" style="margin-right: 0px">
                                    <li class="event" data-date="{{$data['letter_detail']->created_date}}">
                                        <h3>Terkirim</h3>
                                    </li>
                                    @if($data['letter_detail']->review_date!=null)
                                        <li class="event" data-date="{{$data['letter_detail']->review_date}}">
                                            <h3>Review Sekretaris Utama</h3>
                                        </li>
                                    @endif
                                    @if($data['letter_detail']->forward_status=='N')
                                        <li class="event" data-date="{{$data['letter_detail']->forward_date}}">
                                            <h3>Tidak diteruskan</h3>
                                        </li>
                                    @endif
                                    @if($data['letter_detail']->forward_status=='Y')
                                        <li class="event" data-date="{{$data['letter_detail']->forward_date}}">
                                            <h3>Disposisi ke {{$data['letter_detail']->letter_to_name}}</h3>
                                        </li>
                                    @endif
                                    @if($data['letter_detail']->read_status=='Y')
                                        <li class="event" data-date="{{$data['letter_detail']->read_date}}">
                                            <h3>Diterima {{$data['letter_detail']->letter_to_name}}</h3>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 col-sm-12">
                            <div class="comment-wrapper">
                                <div class="panel panel-info">
                                    <div class="panel-body">
                                        <form method="post" action="{{route('discuss-letter')}}">
                                            @csrf
                                            <input name="disc_id" type="hidden" value={{$data['letter_detail']->_id}}>
                                            <textarea name="disc_msg" class="form-control" placeholder="tambahkan catatan..."
                                                      rows="3"></textarea>
                                            <br>
                                            <button type="submit" class="btn btn-info pull-right">Post</button>
                                        </form>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <ul class="media-list">
                                            @if($data['comments'] !=null)
                                                @foreach($data['comments'] as $data)
                                                    <li class="media">
                                                        <div class="media-body">
                                                            @if($data->author == Auth::user()->email)
                                                                <strong class="text-success pull-right">
                                                                    You
                                                                </strong>
                                                            @else
                                                                <strong class="text-primary">
                                                                    {{$data->author}}
                                                                </strong>
                                                            @endif
                                                            <span class="text-muted pull-right">
                                                        <small class="text-muted">{{$data->created_date}}</small>
                                                    </span>
                                                            <p>
                                                                {{$data->discuss_message}}</a>.
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
        @include ('layout.footer')
        <!-- End of Footer -->
        </div>
    </div>
@stop
