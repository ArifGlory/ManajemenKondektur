@extends('layouts.app')
@section('title', 'Detail Data Jadwal')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/summernote/summernote.css') }}">
@endpush
@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb santri-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cari-jadwal') }}">Jadwal</a></li>
        <li class="breadcrumb-item active">Detail Penukaran Jadwal</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Detail Tukar Jadwal
            <small>
                Detail jadwal ini.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ url('/jadwal/tukar-jadwal') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Detail</strong> <span class="fw-300"><i>Tukar jadwal</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label class="form-label">Nama Pegawai</label>
                                    <h4>{{$data->name}}</h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">NIP</label>
                                    <h4>{{$data->nip}}</h4>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-5 ">
                                    <label class="form-label">Status Ajuan Tukar Jadwal</label>
                                    <h2>{{$data->status}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <h4>Jadwal Lama</h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Hari</label>
                                    <h5>{{$data->hari}}</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <h5>{{ \Carbon\Carbon::parse($data->tanggal_jadwal)->format('d M Y') }}</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Jam Mulai kedinasan</label>
                                            <h5>{{$data->jam_mulai}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Jam Selesai kedinasan</label>
                                    <h5>{{$data->jam_selesai}}</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <h4>Pengajuan Jadwal Baru</h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Hari</label>
                                    <h5>{{$data->hari_tukar}}</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <h5>{{ \Carbon\Carbon::parse($data->tanggal_jadwal_tukar)->format('d M Y') }}</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Jam Mulai kedinasan</label>
                                            <h5>{{$data->jam_mulai_tukar}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Jam Selesai kedinasan</label>
                                    <h5>{{$data->jam_selesai_tukar}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Ubah Status </strong> <span class="fw-300"><i>Tukar jadwal</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                @if(Auth::user()->jenis_user == "admin")
                    {!! Form::model($data,['route' => ['jadwal.update-tukar-jadwal', $data->id_tukar_jadwal], 'method' => 'PUT', 'id' => 'form-pegawai', 'files' => true]) !!}
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mt-2">
                                            <h3>Ubah Status Penukaran Jadwal</h3>
                                        </div>
                                        <div class="form-group row">
                                            <input name="id_tukar_jadwal" type="hidden" value="{{$data->id_tukar_jadwal}}">
                                            <label class="col-12 col-md-4 col-form-label">Status Tukar Jadwal</label>
                                            <div class="col-sm-12">
                                                <select name="status" class="form-control select2">
                                                    <option value="{{$data->status}}">Terpilih - {{$data->status}}</option>
                                                    <option value="Menunggu">Menunggu</option>
                                                    <option value="Diterima">Diterima</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                                @error('status')
                                                <div class="col-form-label">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-left">
                                            <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted p-4">
                                                <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-left"><i
                                                            class="fal fa-save"></i> Simpan Perubahan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.partials._helper_js')
    {{--Fungsi script di tampilan transaksi pengguna--}}
    <script src="{{ asset('back-end/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $(document).ready(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#previewFoto').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            $("#picture").change(function() {
                readURL(this);
            });
        })


    </script>
@endpush
@push('scripts')
    @include('datatable._js')
    {{--Fungsi script di tampilan transaksi pengguna--}}
    <script src="{{ asset('back-end/js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('back-end/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script>
        function saveData() {
            event.preventDefault();
            swal.fire({
                title: "Submit?",
                text: "Pastikan kembali data yang diisi.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "Simpan",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.value) {
                    $('#form-pegawai').submit()
                    showLoading(true);
                }
            })
        }
        $('.select2').select2({
            width: '100%',
            placeholder: "Pilih.."
        })
    </script>
@endpush