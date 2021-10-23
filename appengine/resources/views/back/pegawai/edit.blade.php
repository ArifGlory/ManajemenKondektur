@extends('layouts.app')
@section('title', 'Edit Santri')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('santri.index') }}">Santri</a></li>
        <li class="breadcrumb-item active">Tambah Santri</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user-circle'></i> Tambah Santri
            <small>
                Silahkan isi data Santri
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('santri.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::model($data,['route' => ['santri.update', $data->primary_santri], 'method' => 'PUT', 'id' => 'form-Santri', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Santri</h5>
                                <span>Silahkan mengisi data Santri yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Nama Santri</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nama_santri', null, ['class' => 'form-control', $errors->has('nama_santri') ? 'form-control-danger' : '', 'placeholder' => 'Nama Santri']) !!}
                                @error('nama_santri')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Asal Santri</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('asal_santri', null, ['class' => 'form-control', $errors->has('asal_santri') ? 'form-control-danger' : '', 'placeholder' => 'Asal Santri']) !!}
                                @error('asal_santri')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Status Kesehatan</label>
                            <div class="col-sm-12 col-md-8">
                                <select name="status_kesehatan" class="form-control">
                                    <option value="{{$data->status_kesehatan}}">Terpilih - {{$data->status_kesehatan}}</option>
                                    <option value="Sehat">Sehat</option>
                                    <option value="Sakit">Sakit</option>
                                </select>
                                @error('status_kesehatan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Foto Santri <strong>diisi jika ingin mengubah foto santri</strong> </label>
                            <div class="col-sm-12 col-md-8">
                                <input accept="image/*" required id="foto_santri" class="form-control @error('foto_santri') is-invalid @enderror" type="file" name="foto_santri">
                                @error('foto_santri')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Wali Santri</label>
                            <div class="col-sm-12 col-md-8">
                                <select name="email_wali_santri" class="form-control select2">
                                    @if($data->email_wali_santri != null)
                                        <option value="{{$data->email}}"> Terpilih -  {{$data->name}} </option>
                                    @endif
                                    @foreach($wali_santris as $val)
                                        <option value="{{$val->email}}"> {{$val->name}} </option>
                                    @endforeach
                                </select>
                                @error('email_wali_santri')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-right"><i
                                        class="fal fa-save"></i> Simpan Perubahan Data
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
                    $('#form-Santri').submit()
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
