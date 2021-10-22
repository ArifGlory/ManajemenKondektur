@extends('layouts.app')
@section('title', 'Edit Data pegawai')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/summernote/summernote.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb pegawai-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">pegawai</a></li>
        <li class="breadcrumb-item active">Edit pegawai</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Edit pegawai
            <small>
                Silahkan edit pegawai ke dalam aplikasi.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ route('pegawai.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
            {!! Form::model($data,['route' => ['pesantren', $user_id], 'method' => 'post', 'id' => 'form-reset', 'files' => false]) !!}
            <button onclick="resetPassword()" class="btn btn-success btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                    class="fal fa-repeat"></i> Reset Password
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('content')
    {!! Form::model($data,['route' => ['pesantren', $user_id], 'method' => 'put', 'id' => 'pesantren', 'files' => true]) !!}
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Data</strong> <span class="fw-300"><i>pegawai</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Username Pegawai</label>
                                    {!! Form::text('username', null,['class' => ['form-control',($errors->has('username') ? ' is-invalid': '')], 'placeholder' => 'username..','required' => 'required']) !!}
                                    <span class="help-block">
                                                    Username yang digunakan pegawai untuk login
                                                </span>
                                    @error('username')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Nama pegawai</label>
                                    {!! Form::text('name', null,['class' => ['form-control',($errors->has('name') ? ' is-invalid': '')], 'placeholder' => 'Nama pegawai..','required' => 'required']) !!}
                                    <span class="help-block">
                                            Nama Pegawai harus lengkap
                                        </span>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NIP Pegawai</label>
                                            {!! Form::text('nik', null,['class' => ['form-control',($errors->has('nik') ? ' is-invalid': '')], 'placeholder' => 'NIP pegawai..']) !!}
                                            <span class="help-block">

                                                </span>
                                            @error('nik')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Foto Pegawai</label>
                                            <div class="input-group">
                                                <input accept="image/*" required id="picture" class="form-control @error('picture') is-invalid @enderror" type="file" name="picture">
                                            </div>
                                            <span class="help-block">
                                                Sebaiknya menggunakan ukuran gambar yang berkualitas baik. tidak lebih dari 5MB. (resolusi 300x800)
                                            </span>
                                            @error('picture')
                                            <div class="is-error">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <div id="holder" class="text-center" style="margin-top:15px;max-height:100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tempat Lahir</label>
                                            {!! Form::text('tempat_lahir', null,['class' => ['form-control',($errors->has('tempat_lahir') ? ' is-invalid': '')], 'placeholder' => 'Tempat lahir pegawai..','required' => 'required']) !!}
                                            <span class="help-block">

                                                </span>
                                            @error('tempat_lahir')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <div class="input-group">
                                                <input value="{{$data->tanggal_lahir}}" required  class="form-control" type="date" name="tanggal_lahir">
                                            </div>
                                            <span class="help-block">
                                                Tanggal Lahir sesuai KTP
                                            </span>
                                            @error('tanggal_lahir')
                                            <div class="is-error">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                            <div id="holder" class="text-center" style="margin-top:15px;max-height:100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Email Pegawai</label>
                                            {!! Form::text('email', null,['class' => ['form-control',($errors->has('email') ? ' is-invalid': '')], 'placeholder' => 'Email..','required' => 'required']) !!}
                                            <span class="help-block">
                                                    Sebaiknya gunakan email yang aktif
                                                </span>
                                            @error('email')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">No. Handphone Pegawai</label>
                                            {!! Form::text('telepon', null,['class' => ['form-control',($errors->has('telepon') ? ' is-invalid': '')], 'placeholder' => 'Telepon..','required' => 'required']) !!}
                                            <span class="help-block">
                                                    Sebaiknya gunakan telepon yang aktif
                                                </span>
                                            @error('telepon')
                                            <div class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea placeholder="Alamat lengkap pegawai" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{$data->alamat}}</textarea>
                                    @error('alamat')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Jabatan</label>
                                    <select name="id_jabatan" class="form-control select2">
                                        <option value="{{$data->id_jabatan}}">Terpilih {{$data->nama_jabatan}}</option>
                                        @foreach($jabatan as $val)
                                            <option value="{{$val->id}}">{{$val->nama_jabatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Pangkat dan Golongan</label>
                                    <select name="id_pangkat_golongan" class="form-control select2">
                                        <option value="{{$data->id_pangkat_golongan}}">Terpilih {{$data->nama_pangkat}} - {{$data->golongan}}</option>
                                        @foreach($pangkat_golongan as $val)
                                            <option value="{{$val->id}}">{{$val->nama_pangkat}} - {{$val->golongan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">pegawai</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Foto Pegawai</label>
                                    <div class="align-content-center" style="margin-left: 30px;margin-right: 30px;">
                                        @if($data->picture)
                                            <img id="previewFoto" src="{{ asset('img/user/'.$data->picture) }}" height="250px" alt="">
                                        @else
                                            <img id="previewFoto" width="100%" height="250" src="{{asset('img/user/no_img.png')}}">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jenis Pegawai</label>
                                    <select name="jenis_pegawai" class="form-control">
                                        <option value="{{$data->jenis_pegawai}}">Terpilih {{$data->jenis_pegawai}}</option>
                                        <option value="PNS">PNS</option>
                                        <option value="Honor Daerah">Honor Daerah</option>
                                        <option value="Honor Dinas">Honor Dinas</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Tanggal Mulai Kerja</label>
                                    <div class="input-group">
                                        <input value="{{$data->waktu_mulai_kerja}}" required  class="form-control" type="date" name="waktu_mulai_kerja">
                                    </div>
                                    <span class="help-block">
                                                Tanggal SK Mulai Bekerja
                                            </span>
                                    @error('waktu_mulai_kerja')
                                    <div class="is-error">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                    <div id="holder" class="text-center" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-right"><i
                                    class="fal fa-save"></i> Simpan Perubahan
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
    {{--Fungsi script di tampilan transaksi pengguna--}}
    <script src="{{ asset('back-end/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('input[name="title"]').blur(function() {
                $('input[name="seotitle"]').val(name_to_url($(this).val()));
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewFoto').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            $("#picture").change(function() {
                readURL(this);
            });
        })
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

        function resetPassword(){            
            event.preventDefault();
            swal.fire({
                title: "Submit?",
                text: "Anda yakin ingin melakukan reset password ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "Simpan",
                cancelButtonText: "Tidak",
            }).then((result) => {
                if (result.value) {
                    console.log('{{ $user_id }}');
                    $('#form-reset').submit()
                    showLoading(true);
                }
            })
        }
        $('.select2').select2({
            width: '100%',
            placeholder: "Pilih Kategori.."
        })
    </script>
@endpush