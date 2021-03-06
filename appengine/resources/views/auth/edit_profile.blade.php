@extends('layouts.app')
@section('title', 'Ubah Data Profil')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Ubah Profil</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user-circle'></i> Edit Profil Saya
            <small>
                Silahkan ubah data pegawai
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('pegawai.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::model($data,['route' => ['update-profile'], 'method' => 'POST', 'id' => 'form-pegawai', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Profil</h5>
                                <span>Silahkan ubah data profil anda</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id_user" value="{{$data->id}}">
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



                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Lainnya</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group">
                                <div class="align-content-center text-center" style="margin-left: 30px;margin-right: 30px;">
                                    @if($data->foto)
                                        <img id="previewFoto" src="{{ asset('img/pegawai/'.$data->foto) }}" height="250px" alt="">
                                    @else
                                        <img id="previewFoto" width="100%" height="250" src="{{asset('img/pegawai/padrao.png')}}">
                                    @endif
                                </div>
                            </div>
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

                        <div class="text-right">
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
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $(document).ready(function () {
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


    </script>
@endpush
