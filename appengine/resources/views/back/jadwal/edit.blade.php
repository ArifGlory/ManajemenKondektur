@extends('layouts.app')
@section('title', 'Ubah Jadwal Kedinasan')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Jadwal Kedinasan</a></li>
        <li class="breadcrumb-item active">Ubah Jadwal Kedinasan</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user-circle'></i> Ubah Jadwal Kedinasan
            <small>
                Silahkan isi data jadwal
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('jadwal.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::model($data,['route' => ['jadwal.update', $data->id_jadwal], 'method' => 'PUT', 'id' => 'form-pegawai', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Jadwal</h5>
                                <span>Silahkan mengubah data jadwal yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-form-label">Nama Pegawai</label>
                            <div class="col-md-12">
                                <h4>{{$data->name}} - NIP. {{$data->nip}}</h4>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Tanggal</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::date('tanggal_jadwal', null, ['class' => 'form-control', $errors->has('tanggal_jadwal') ? 'form-control-danger' : '', 'placeholder' => 'Tanggal jadwal']) !!}
                                @error('tanggal_jadwal')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Jam Mulai Kedinasan</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::time('jam_mulai', null, ['class' => 'form-control', $errors->has('jam_mulai') ? 'form-control-danger' : '', 'placeholder' => 'Jam Mulai Dinas']) !!}
                                @error('jam_mulai')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Jam Selesai Kedinasan</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::time('jam_selesai', null, ['class' => 'form-control', $errors->has('jam_selesai') ? 'form-control-danger' : '', 'placeholder' => 'Jam Selesai Dinas']) !!}
                                @error('jam_selesai')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>


                        <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted p-4">
                            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-left"><i
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
