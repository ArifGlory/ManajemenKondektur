@extends('layouts.app')
@section('title', 'Edit Wali Santri')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wali-santri.index') }}">wali-santri</a></li>
        <li class="breadcrumb-item active">Tambah Wali Santri</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file'></i> Ubah wali-santri
            <small>
                Silahkan isi data wali-santri
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('wali-santri.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                    class="fal fa-save"></i> Simpan Perubahan Data
            </button>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::model($data,['route' => ['wali-santri.update', $data->id], 'method' => 'PUT', 'id' => 'form-wali-santri', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data wali santri</h5>
                                <span>Silahkan mengisi data wali santri yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama wali santri</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('name', null, ['class' => 'form-control', $errors->has('name') ? 'form-control-danger' : '', 'placeholder' => 'Nama wali santri']) !!}
                                @error('name')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Email</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('email', null, ['class' => 'form-control', $errors->has('email') ? 'form-control-danger' : '', 'placeholder' => 'email wali santri']) !!}
                                @error('email')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Telepon</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('phone', null, ['class' => 'form-control', $errors->has('phone') ? 'form-control-danger' : '', 'placeholder' => 'telepon wali santri']) !!}
                                @error('phone')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
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
        //var kelengkapanwali-santri = $("#kelengkapan-wali-santri");
        var dokumen = $("#wali-santri");
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
                    $('#form-wali-santri').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
