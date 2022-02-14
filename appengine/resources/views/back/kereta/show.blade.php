@extends('layouts.app')
@section('title', 'Detail Data Kereta')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/summernote/summernote.css') }}">
@endpush
@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb santri-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kereta.index') }}">Kereta</a></li>
        <li class="breadcrumb-item active">Detail Kereta</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Detail Kereta
            <small>
                Detail Kereta ini.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ url('/kereta') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Detail</strong> <span class="fw-300"><i>Kereta</i></span>
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
                                <div class="form-group mt-3">
                                    <label class="form-label">Nama Kereta</label>
                                    <h5>{{$data->nama_kereta}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Nomor Kereta</label>
                                    <h5>{{$data->nomor_kereta}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Kelas Kereta</label>
                                    <h5>{{$data->kelas_kereta}}</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Relasi Kereta</label>
                                    <h5>{{$data->deskripsi_kereta}}</h5>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.partials._helper_js')
    {{--Fungsi script di tampilan transaksi pengguna--}}
    <script src="{{ asset('back-end/js/formplugins/select2/select2.bundle.js') }}"></script>
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
@push('scripts')
    @include('datatable._js')
    {{--Fungsi script di tampilan transaksi pengguna--}}
    <script src="{{ asset('back-end/js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        /*var table;
        $(function(){
            'use strict';
            table = $('#dokumen-table').DataTable();
        });*/
    </script>
@endpush