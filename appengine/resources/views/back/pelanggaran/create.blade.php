@extends('layouts.app')
@section('title', 'Tambah Pelanggaran')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Tambah Pelanggaran</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-ban'></i> Tambah Pelanggaran
            <small>
                Silahkan isi data Pelanggaran
            </small>
        </h1>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'pelanggaran.store', 'method' => 'POST', 'id' => 'form-Pelanggaran', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Pelanggaran</h5>
                                <span>Silahkan mengisi data Pelanggaran Santri :  <strong> {{$data->nama_santri}} </strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input name="id_santri" type="hidden" value="{{$data->id_santri}}">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama Pelanggaran</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nama_pelanggaran', null, ['class' => 'form-control', $errors->has('nama_pelanggaran') ? 'form-control-danger' : '', 'placeholder' => 'Nama pelanggaran']) !!}
                                @error('nama_pelanggaran')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Keterangan Pelanggaran</label>
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
                            <label class="col-12 col-md-4 col-form-label">Jenis Pelanggaran</label>
                            <div class="col-sm-12 col-md-8">
                                <select name="jenis_pelanggaran" class="form-control">
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>

                                @error('jenis_pelanggaran')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
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
                    $('#form-Pelanggaran').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
