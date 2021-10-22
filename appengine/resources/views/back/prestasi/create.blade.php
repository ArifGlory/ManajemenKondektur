@extends('layouts.app')
@section('title', 'Tambah Prestasi')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('prestasi.index') }}">Prestasi</a></li>
        <li class="breadcrumb-item active">Tambah Prestasi</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file'></i> Tambah Prestasi
            <small>
                Silahkan isi data Prestasi
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('prestasi.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                    class="fal fa-save"></i> Simpan Data
            </button>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'prestasi.store', 'method' => 'POST', 'id' => 'form-prestasi', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Prestasi</h5>
                                <span>Silahkan mengisi data Prestasi yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-form-label">Pilih Santri</label>
                            <div class="col-sm-12">
                                <select class="form-control select2" name="id_santri" id="selectSantri" required>
                                    @foreach($santri as $val)
                                        <option value="{{$val->id_santri}}"> {{$val->nama_santri}} </option>
                                    @endforeach
                                </select>
                                @error('santri')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama Prestasi</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nama_prestasi', null, ['class' => 'form-control', $errors->has('nama_prestasi') ? 'form-control-danger' : '', 'placeholder' => 'Nama prestasi']) !!}
                                @error('nama_prestasi')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Hadiah / hasil</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::textarea('hadiah', null, ['class' => 'form-control', $errors->has('hadiah') ? 'form-control-danger' : '','rows' => 3]) !!}
                                @error('hadiah')
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
                    $('#form-prestasi').submit()
                    showLoading(true);
                }
            })
        }
        $('.select2').select2({
            width: '100%',
            placeholder: "Pilih Santri.."
        })
    </script>
@endpush
