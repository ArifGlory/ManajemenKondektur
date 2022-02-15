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
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <h5 class="alert-heading">Status Tukar Jadwal</h5>
                <hr>
                <h3> {{$tukar_jadwal_pemohon->status}} </h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Pemohon 1</strong> <span class="fw-300"><i></i></span>
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
                                    <label class="form-label">Pegawai</label>
                                    <h4>{{$tukar_jadwal_pemohon->name}} - NIP {{$tukar_jadwal_pemohon->nip}} | {{$tukar_jadwal_pemohon->jabatan}}</h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Alasan Penukaran</label>
                                    @if($tukar_jadwal_pemohon->alasan == "Sakit")
                                        <h4>{{$tukar_jadwal_pemohon->alasan}} - <a target="_blank" href="{{asset('img/file_pendukung/'.$tukar_jadwal_pemohon->file_pendukung)}}">Lihat File Pendukung</a> </h4>
                                    @else
                                        <h4>{{$tukar_jadwal_pemohon->alasan}}</h4>
                                    @endif
                                </div>
                                <hr>
                                <h3>Jadwal Asal</h3>
                                <div class="form-group mt-2">
                                    <label class="form-label">Kereta</label>
                                    <h4>{{$jadwal_lama->nama_kereta}} - {{$jadwal_lama->nomor_kereta}} </h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Tanggal</label>
                                    <h4>{{$jadwal_lama->hari}}, {{ \Carbon\Carbon::parse($jadwal_lama->tanggal_jadwal)->format('d M Y') }} </h4>
                                </div>
                                <hr>
                                <h3>Jadwal Diinginkan</h3>
                                <div class="form-group mt-2">
                                    <label class="form-label">Kereta</label>
                                    <h4>{{$jadwal_diinginkan->nama_kereta}} - {{$jadwal_diinginkan->nomor_kereta}} </h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Tanggal</label>
                                    <h4>{{$jadwal_diinginkan->hari}}, {{ \Carbon\Carbon::parse($jadwal_diinginkan->tanggal_jadwal)->format('d M Y') }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Pemohon 2</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    @if($tukar_jadwal_termohon)
                        <div class="panel-content">
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label class="form-label">Pegawai</label>
                                    <h4>{{$tukar_jadwal_termohon->name}} - NIP {{$tukar_jadwal_termohon->nip}} | {{$tukar_jadwal_termohon->jabatan}}</h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Alasan Penukaran</label>
                                    @if($tukar_jadwal_termohon->alasan == "Sakit")
                                        <h4>{{$tukar_jadwal_termohon->alasan}} - <a target="_blank" href="{{asset('img/file_pendukung/'.$tukar_jadwal_termohon->file_pendukung)}}">Lihat File Pendukung</a> </h4>
                                    @else
                                        <h4>{{$tukar_jadwal_termohon->alasan}}</h4>
                                    @endif
                                </div>
                                <hr>
                                <h3>Jadwal Asal</h3>
                                @php

                                    $jadwal_lama_termohon = App\Models\Jadwal::select('jadwal.*','kereta.*')
                                        ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta')
                                        ->where('id_jadwal',$tukar_jadwal_termohon['id_riwayat_jadwal'])
                                        ->first();

                                     $jadwal_diinginkan_termohon = App\Models\Jadwal::select('jadwal.*','kereta.*')
                                        ->join('kereta','kereta.id_kereta','=','jadwal.id_kereta')
                                        ->where('id_jadwal',$tukar_jadwal_termohon['id_jadwal_diinginkan'])
                                        ->first();

                                @endphp
                                <div class="form-group mt-2">
                                    <label class="form-label">Kereta</label>
                                    <h4>{{$jadwal_lama_termohon->nama_kereta}} - {{$jadwal_lama_termohon->nomor_kereta}} </h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Tanggal</label>
                                    <h4>{{$jadwal_lama_termohon->hari}}, {{ \Carbon\Carbon::parse($jadwal_lama_termohon->tanggal_jadwal)->format('d M Y') }} </h4>
                                </div>
                                <hr>
                                <h3>Jadwal Diinginkan</h3>
                                <div class="form-group mt-2">
                                    <label class="form-label">Kereta</label>
                                    <h4>{{$jadwal_diinginkan_termohon->nama_kereta}} - {{$jadwal_diinginkan_termohon->nomor_kereta}} </h4>
                                </div>
                                <div class="form-group mt-2">
                                    <label class="form-label">Tanggal</label>
                                    <h4>{{$jadwal_diinginkan_termohon->hari}}, {{ \Carbon\Carbon::parse($jadwal_diinginkan_termohon->tanggal_jadwal)->format('d M Y') }} </h4>
                                </div>
                            </div>
                        </div>
                        </div>
                    @else
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-center">
                                        <img class="" id="previewFoto" width="30%" height="250" src="{{asset('img/error.png')}}">
                                        <hr>
                                        <h3>Pemohon 2 belum mengajukan penukaran jadwal</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if(Auth::user()->jenis_user == "admin" && $tukar_jadwal_termohon && $tukar_jadwal_pemohon->status != "Diterima")
        <div class="col-sm-12 col-md-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Konfirmasi status </strong> <span class="fw-300"><i>Penukaran jadwal</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                {!! Form::open(['route' => 'jadwal.update-tukar-jadwal', 'method' => 'POST', 'id' => 'form-pegawai', 'files' => true]) !!}
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mt-2">
                                            <h3>Ubah Status Penukaran Jadwal</h3>
                                        </div>
                                        <div class="form-group row">
                                            <input name="id_pemohon1" type="hidden" value="{{$tukar_jadwal_pemohon->id_tukar_jadwal}}">
                                            <input name="id_pemohon2" type="hidden" value="{{$tukar_jadwal_termohon->id_tukar_jadwal}}">
                                            <label class="col-12 col-md-4 col-form-label">Status Tukar Jadwal</label>
                                            <div class="col-sm-12">
                                                <select name="status" class="form-control select2">
                                                    <option value="{{$tukar_jadwal_pemohon->status}}">Terpilih - {{$tukar_jadwal_pemohon->status}}</option>
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

            </div>
        </div>
        @endif
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