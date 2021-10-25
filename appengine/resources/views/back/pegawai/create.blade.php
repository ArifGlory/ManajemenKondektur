@extends('layouts.app')
@section('title', 'Tambah Pegawai')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
        <li class="breadcrumb-item active">Tambah Pegawai</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user-circle'></i> Tambah Pegawai & Kondektur
            <small>
                Silahkan isi data pegawai
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('pegawai.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'pegawai.store', 'method' => 'POST', 'id' => 'form-pegawai', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Pegawai</h5>
                                <span>Silahkan mengisi data Pegawai yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama Pegawai</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('name', null, ['class' => 'form-control', $errors->has('name') ? 'form-control-danger' : '', 'placeholder' => 'Nama Pegawai'
                                , 'required' => 'required']) !!}
                                @error('name')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Telepon</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('phone', null, ['class' => 'form-control', $errors->has('phone') ? 'form-control-danger' : '', 'placeholder' => 'Telepon']) !!}
                                @error('phone')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">NIP</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nip', null, ['class' => 'form-control', $errors->has('nip') ? 'form-control-danger' : '', 'placeholder' => 'NIP']) !!}
                                @error('nip')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Pangkat</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('pangkat', null, ['class' => 'form-control', $errors->has('pangkat') ? 'form-control-danger' : '', 'placeholder' => 'pangkat']) !!}
                                @error('pangkat')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Foto Pegawai</label>
                            <div class="col-sm-12 col-md-8">
                                <input accept="image/*" required id="foto" class="form-control @error('foto') is-invalid @enderror" type="file" name="foto">
                                @error('foto')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Jabatan</label>
                            <div class="col-sm-12 col-md-8">
                                <select name="jabatan" class="form-control select2">
                                    <option value="KDT">Kondektur</option>
                                    <option value="LIA">Penyelia</option>
                                    <option value="KUPT">Kepala UPT</option>
                                </select>
                                @error('jabatan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Login</h5>
                                <span>Dibutuhkan agar user dapat login ke aplikasi.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Email Pegawai</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('email', null, ['class' => 'form-control', $errors->has('email') ? 'form-control-danger' : '', 'placeholder' => 'Email pegawai']) !!}
                                @error('email')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Password</label>
                            <div class="col-sm-12 col-md-8">
                                <input type="password" name="password" class="form-control" required placeholder="password pengguna">
                                @error('password')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
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
