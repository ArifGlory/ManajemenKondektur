@extends('layouts.app')
@section('title', 'Edit Dokumen')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <style>
        .fill {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden
        }
        .fill img {
            flex-shrink: 0;
            min-width: 100%;
            min-height: 100%
        }
    </style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Dokumen</a></li>
        <li class="breadcrumb-item active">Edit Dokumen</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file'></i> Edit Dokumen
            <small>
                Silahkan ubah data Dokumen
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('kelas.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                    class="fal fa-save"></i> Ubah Data
            </button>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::model($data, ['route' => ['kelas.update', $data->id_sk], 'method' => 'put', 'id' => 'form-kelas', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Dokumen</h5>
                                <span>Silahkan mengisi data Dokumen yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-4 col-form-label">Nama Dokumen</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('nama_dokumen', null, ['class' => 'form-control', $errors->has('nama_dokumen') ? 'form-control-danger' : '', 'placeholder' => 'No. SK Dokumen']) !!}
                                @error('nama_dokumen')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">No. SK Dokumen</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::text('no_sk', null, ['class' => 'form-control', $errors->has('no_sk') ? 'form-control-danger' : '', 'placeholder' => 'No. SK Dokumen']) !!}
                                @error('no_sk')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Terhitung Mulai Tanggal</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::date('tmt_sk', null, ['class' => 'form-control', $errors->has('tmt_sk') ? 'form-control-danger' : '', 'placeholder' => 'TMT dari Dokumen']) !!}
                                @error('tmt_sk')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Tanggak SK</label>
                            <div class="col-sm-12 col-md-8">
                                {!! Form::date('tanggal_sk', null, ['class' => 'form-control', $errors->has('tanggal_sk') ? 'form-control-danger' : '', 'placeholder' => 'Tanggal dari Dokumen',
                                'id'=>'tanggal_sk']) !!}
                                <span>tanggal yang tercantum di dokumen SK</span>
                                @error('tanggal_sk')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">File Dokumen</label>
                            <div class="col-sm-12 col-md-8">
                                <input type="file" class="form-control" name="path_sk" id="path_sk" accept="application/pdf,image/x-png,image/gif,image/jpeg">
                                <span>Usahakan file berupa PDF atau JPG</span>
                                @error('path_sk')
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
                <div class="panel">
                    <div class="panel-hdr">
                        <h2>
                            <strong id="title-table">Preview Dokumen</strong> <span class="fw-300"><i></i></span>
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
                                        <div class="align-content-center" style="margin-left: 30px;margin-right: 30px;">
                                            @if($extension == "pdf")
                                                @if($data->path_sk)
                                                    <iframe width="100%" height="700px" src="{{ asset('img/kelas/'.$data->path_sk) }}"></iframe>
                                                @else
                                                    <h3>Dokumen belum di upload</h3>
                                                @endif
                                            @else
                                                @if($data->path_sk)
                                                    <div class="fill">
                                                        <img id="previewFoto" src="{{ asset('img/kelas/'.$data->path_sk) }}" alt="">
                                                    </div>
                                                @else
                                                    <img id="previewFoto" width="100%" height="100%" src="{{asset('img/user/no_img.png')}}">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
                    $('#form-kelas').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
