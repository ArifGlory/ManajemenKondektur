@extends('layouts.app')
@section('title', 'Tambah Jadwal')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Jadwal</a></li>
        <li class="breadcrumb-item active">Tambah Jadwal</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file'></i> Tambah Jadwal Kegiatan
            <small>
                Silahkan isi data Jadwal Kegiatan
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('jadwal.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'jadwal.store', 'method' => 'POST', 'id' => 'form-Jadwal', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Jadwal</h5>
                                <span>Silahkan mengisi data Jadwal Kegiatan yang akan berlangsung.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama Jadwal</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nama_jadwal', null, ['class' => 'form-control', $errors->has('nama_jadwal') ? 'form-control-danger' : '', 'placeholder' => 'Nama Jadwal']) !!}
                                @error('nama_jadwal')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Keterangan Jadwal</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::textarea('keterangan', null, ['class' => 'form-control','id' => 'keterangan', 'rows' => 4, 'cols' => 54, 'style' => 'resize:none']) !!}
                                @error('keterangan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Tanggal Jadwal</label>
                            <div class="col-sm-12 col-md-8">
                                <input class="form-control" type="date" name="tanggal_jadwal">
                                @error('tanggal_jadwal')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-right">
                            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                                        class="fal fa-save"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
@push('scripts')
    @include('layouts.partials._helper_js')
    <script src="{{ asset('back-end/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script>
        var jenis;
        //var kelengkapanJadwal = $("#kelengkapan-Jadwal");
        var dokumen = $("#Jadwal");
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
                    $('#form-Jadwal').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
