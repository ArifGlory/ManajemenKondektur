@extends('layouts.app')
@section('title', 'Detail Data santri')

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
        <li class="breadcrumb-item"><a href="{{ route('santri.index') }}">Santri</a></li>
        <li class="breadcrumb-item active">Detail Santri</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Detail santri
            <small>
                Detail Santri ini.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ route('santri.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
            <a href="{{ route('pegawai', $data->primary_santri) }}" class="btn btn-success btn-sm waves-effect text-right"><i
                        class="fal fa-edit"></i> Edit
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Detail</strong> <span class="fw-300"><i>santri</i></span>
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
                                    <label class="form-label">Nama Pesantren</label>
                                    <h5>{{$data->nama_pesantren}}</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama santri</label>
                                    <h5>{{$data->nama_santri}}</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">Asal Santri</label>
                                            <h5>{{$data->asal_santri}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Status Kesehatan</label>
                                    <h5>{{$data->status_kesehatan}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Nama Wali Santri</label>
                                    @if($data->nama_wali == null)
                                        <h5>Belum Dipilih</h5>
                                    @else
                                        <h5>{{$data->nama_wali}}</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Kitab Santri ini</strong> <span class="fw-300"><i></i></span>
                    </h2>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        @php
                            $no = 1;
                        @endphp
                        <table class="table table-bordered table-hover table-striped w-100" id="dokumen-table">
                            <thead>
                            <tr>
                                <td width="2%">No</td>
                                <td>Nama Kitab</td>
                                <td>Status</td>
                                <td>Keterangan</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($kitab as $val)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$val->nama_kitab}}</td>
                                    <td>{{$val->status}}</td>
                                    <td>{{$val->keterangan}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Pelanggaran yang telah dilakukan</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="pull-right">
                        <a href="{{ route('pelanggaran.make', $data->primary_santri) }}" class="btn btn-success btn-sm waves-effect text-sm-center"><i
                                    class="fal fa-plus-square"></i> Tambah Pelanggaran
                        </a>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        @php
                            $no = 1;
                        @endphp
                        <table class="table table-bordered table-hover table-striped w-100" id="dokumen-table">
                            <thead>
                            <tr>
                                <td width="2%">No</td>
                                <td>Nama Pelanggaran</td>
                                <td>Jenis Pelanggaran</td>
                                <td>Keterangan</td>
                                <td>Tanggal</td>
                                <td width="20%">Aksi</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pelanggaran as $val)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$val->nama_pelanggaran}}</td>
                                    <td>{{$val->jenis_pelanggaran}}</td>
                                    <td>{{$val->keterangan}}</td>
                                    <td>{{ \Carbon\Carbon::parse($val->created_at)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pelanggaran.hapus',$val->id_pelanggaran) }}" class="button btn-sm btn-danger text-white"> Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Prestasi Santri ini</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="pull-right">
                        <a href="{{ route('prestasi.create') }}" class="btn btn-success btn-sm waves-effect text-sm-center"><i
                                    class="fal fa-plus-square"></i> Tambah Prestasi
                        </a>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- datatable start -->
                        @php
                            $no = 1;
                        @endphp
                        <table class="table table-bordered table-hover table-striped w-100" id="dokumen-table">
                            <thead>
                            <tr>
                                <td width="2%">No</td>
                                <td>Nama Prestasi</td>
                                <td>Hadiah</td>
                                <td>Tanggal</td>
                                <td width="20%">Aksi</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prestasi as $val)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$val->nama_prestasi}}</td>
                                    <td>{{$val->hadiah}}</td>
                                    <td>{{ \Carbon\Carbon::parse($val->created_at)->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('prestasi.show',$val->id_prestasi) }}" class="button btn-sm btn-success text-white"> Lihat</a>
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
        <div class="col-sm-12 col-md-4">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">santri</strong> <span class="fw-300"><i></i></span>
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
                                    <label class="form-label">Foto Santri</label>
                                    <div class="align-content-center text-center" style="margin-left: 30px;margin-right: 30px;">
                                        @if($data->foto_santri)
                                            <img id="previewFoto" src="{{ asset('img/santri/'.$data->foto_santri) }}" height="250px" alt="">
                                        @else
                                            <img id="previewFoto" width="100%" height="250" src="{{asset('pegawai')}}">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Ditambahkan pada</label>
                                    <h5>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</h5>
                                    <div id="holder" class="text-center" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    @if($data->status_aktivasi == 1)
                                        <h2>
                                            <span class="badge badge-success">Sudah Aktivasi Premium</span>
                                        </h2>
                                    @endif
                                </div>
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