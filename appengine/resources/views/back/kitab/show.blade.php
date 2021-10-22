@extends('layouts.app')
@section('title', 'Lihat Kitab')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/summernote/summernote.css') }}">
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
    <ol class="breadcrumb dokumen-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kitab.index') }}">Kitab</a></li>
        <li class="breadcrumb-item active">Detail Kitab</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Detail Kitab
            <small>
                Detail Kitab ini.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ route('kitab.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Detail</strong> <span class="fw-300"><i>Kitab</i></span>
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
                                    <label class="form-label">Nama Kitab</label>
                                    <h5>{{ $data->nama_kitab }}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Keterangan</label>
                                    <h5>{{$data->keterangan}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Santri di Kitab ini</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="pull-right">
                        @if(Auth::user()->jenis_user != "admin")
                           <a href="{{ route('kitab.add-santri',$data->id_kitab) }}" class="btn btn-success btn-sm waves-effect text-sm-center"><i
                                        class="fal fa-plus-circle"></i> Tambah Santri Untuk Kitab ini
                            </a>
                        @endif
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        @php
                            $no = 1;
                        @endphp
                        <table class="table table-bordered table-hover table-striped w-100" id="Kitab-table">
                            <thead>
                            <tr>
                                <td width="2%">No</td>
                                <td>Nama Santri</td>
                                <td>Status</td>
                                <td width="30%">Aksi</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($santri_dikitab as $val)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$val->nama_santri}}</td>
                                    <td class="text-center">{{$val->status}}</td>
                                    <td class="text-center align-items-center">
                                        <a href="{{ route('santri.show',$val->id_santri) }}" class="button btn-sm btn-success text-white"> Lihat Santri</a>
                                        <a href="{{ route('kitab.edit-status',$val->id_kms) }}" class="button btn-sm btn-primary text-white"> Ubah Status</a>
                                        <a href="{{ route('kitab.remove-santri',$val->id_kms) }}" class="button btn-sm btn-danger text-white"> Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- datatable end -->
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
    <script src="{{ asset('back-end/js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        var table;
        $(function(){
            'use strict';
            table = $('#Kitab-table').DataTable({
                responsive: true,
            });
        });
    </script>
@endpush
