@extends('layouts.app')
@section('title', 'Tambah Kereta')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kereta.index') }}">Kereta</a></li>
        <li class="breadcrumb-item active">Tambah Kereta</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user-circle'></i> Tambah Kereta
            <small>
                Silahkan isi data Kereta
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('kereta.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'kereta.store', 'method' => 'POST', 'id' => 'form-kereta', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Kereta</h5>
                                <span>Silahkan mengisi data Kereta yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama Kereta</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nama_kereta', null, ['class' => 'form-control', $errors->has('nama_kereta') ? 'form-control-danger' : '', 'placeholder' => 'Nama Kereta'
                                , 'required' => 'required']) !!}
                                @error('nama_kereta')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nomor Kereta</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nomor_kereta', null, ['class' => 'form-control', $errors->has('nomor_kereta') ? 'form-control-danger' : '', 'placeholder' => 'Nomor Kereta']) !!}
                                @error('nomor_kereta')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-form-label">Deskripsi</label>
                            <div class="col-sm-12">
                                {!! Form::textarea('deskripsi_kereta', null, ['id' => 'deskripsi_kereta', 'rows' => 4, 'style' => 'resize:none','class' => 'form-control', $errors->has('deskripsi_kereta') ? 'form-control-danger' : '',
                                'placeholder' => 'Deskripsi singkat tentang kereta']) !!}
                                @error('deskripsi_kereta')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-left">
                            <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted p-4">
                                <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-left"><i
                                            class="fal fa-save"></i> Simpan Data
                                </button>
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
                    $('#form-kereta').submit()
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
