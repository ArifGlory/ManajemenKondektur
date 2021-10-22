@extends('layouts.app')
@section('title', 'Cloud Messaging')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Buat Pesan Cloud Messaging Baru</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file-pdf'></i> Tambah Cloud message
            <small>
                Silahkan isi data pesan
            </small>
        </h1>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'cloud_message.send', 'method' => 'POST', 'id' => 'form-kitab', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Pesan</h5>
                                <span>Silahkan mengisi data pesan</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Token pengguna</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('device_token', null, ['class' => 'form-control', $errors->has('device_token') ? 'form-control-danger' : '', 'placeholder' => 'Token pengguna (terdiri dari teks acak)']) !!}
                                @error('device_token')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Judul Pesan</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('judul_pesan', null, ['class' => 'form-control', $errors->has('judul_pesan') ? 'form-control-danger' : '', 'placeholder' => 'Judu dari pesan broadcast']) !!}
                                @error('judul_pesan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Isi Pesan</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::textarea('isi_pesan', null, ['class' => 'form-control','id' => 'isi_pesan', 'rows' => 4, 'cols' => 54, 'style' => 'resize:none']) !!}
                                @error('isi_pesan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm text-center float-right">
                            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                                        class="fal fa-send"></i> Kirim pesan
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
                    $('#form-kitab').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
