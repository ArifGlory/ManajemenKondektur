@extends('layouts.app')
@section('title', 'Tambah Santri Massal')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('santri.index') }}">Santri</a></li>
        <li class="breadcrumb-item active">Tambah Santri Secara Massal</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user-circle'></i> Tambah Santri Secara Massal
            <small>
                Silahkan pilih file excel data Santri
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('pegawai') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'santri.store-multi', 'method' => 'POST', 'id' => 'form-Santri', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Import Data Santri</h5>
                                <span>Silahkan pilih file Excel yang akan di import.</span>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">File Excel Santri</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::file('file_excel', null, ['class' => 'form-control', $errors->has('file_excel') ? 'form-control-danger' : '', 'placeholder' => 'File Excel Santri']) !!}
                                @error('file_excel')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-right"><i
                                        class="fal fa-save"></i> Import
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Petunjuk Import Data Santri</h5>
                                <span>Pastikan isi file excel seperti gambar berikut.</span>
                                <h2 class="mt-3">Jika Email wali santri belum ada, kosongkan saja kolom ke 3 (Kolom C)</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <img src="{{ asset('img/import_santri_massal.PNG') }}" class="card-img-top" alt="Petunjuk">
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
                    $('#form-Santri').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
