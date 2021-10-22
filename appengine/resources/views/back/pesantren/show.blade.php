@extends('layouts.app')
@section('title', 'Edit Data pesantren')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/summernote/summernote.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb pesantren-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/pesantren.index') }}">Pesantren</a></li>
        <li class="breadcrumb-item active">Detail pesantren</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Detail pesantren
            <small>
                Detail pesantren ini.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ route('pesantren.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
            {!! Form::model($data,['route' => ['pesantren.resetpass', $user_id], 'method' => 'post', 'id' => 'form-reset', 'files' => false]) !!}
            <button onclick="resetPassword()" class="btn btn-success btn-sm waves-effect pull-right mx-1 d-none d-sm-inline-block"><i
                    class="fal fa-repeat"></i> Reset Password
            </button>
            {!! Form::close() !!}
            <a href="{{ route('pesantren.add-saldo',$user_id) }}" class="btn btn-warning btn-mini waves-effect waves-light"><span class="fal fa-dollar-sign"></span> Tambah Saldo</a>
            {{--<a href="#" class="btn btn-success btn-mini waves-effect waves-light"><span class="fal fa-file"></span>  Dokumen pesantren Ini</a>--}}
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Detail</strong> <span class="fw-300"><i>pesantren</i></span>
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
                                    <label class="form-label">Email pesantren</label>
                                    <h5>{{$data->email}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Nama pesantren</label>
                                    <h5>{{$data->name}}</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Pengasuh</label>
                                            <h5>{{$data->nama_pengasuh}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">No. Handphone pesantren</label>
                                            <h5>{{$data->phone}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Alamat</label>
                                    <h5>{{$data->alamat}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Keterangan</label>
                                    <h5>{{$data->keterangan}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Jumlah Santri</label>
                                    <h5>{{$data->jml_santri}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Provinsi</label>
                                    <h5>{{$data->nama_provinsi}}</h5>
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
                        <strong id="title-table">pesantren</strong> <span class="fw-300"><i></i></span>
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
                                    <label class="form-label">Foto Utama Pesantren</label>
                                    <div class="align-content-center" style="margin-left: 30px;margin-right: 30px;">
                                        @if($data->foto != null)
                                            <img id="previewFoto" src="https://api.nyantri.net/img/sekolah/{{$data->foto}}" height="250px" class="card-img-top" alt="{{ $data->name }}">
                                        @else
                                            <img id="previewFoto" src="{{ asset('img/padrao.png') }}" class="card-img-top" alt="{{ $data->name }}">
                                        @endif
                                       {{-- @if($data->picture)
                                            <img id="previewFoto" src="{{ asset('img/user/'.$data->picture) }}" height="250px" alt="">
                                        @else
                                            <img id="previewFoto" width="100%" height="250" src="{{asset('img/user/no_img.png')}}">
                                        @endif--}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Saldo pesantren</label>
                                    <h4> <strong> Rp.  {{ number_format($data->saldo,0,',','.')}} </strong> </h4>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Kategori pesantren</label>
                                    <h5>{{$data->nama_kategori}}</h5>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Terdaftar pada</label>
                                    <h5>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</h5>
                                    <div id="holder" class="text-center" style="margin-top:15px;max-height:100px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        {{--<a href="{{ route('pesantren.edit', $user_id) }}" class="btn btn-success btn-sm waves-effect text-right"><i
                                    class="fal fa-edit"></i> Edit
                        </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Foto lain dari pesantren ini</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
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
                                <td width="80%">Gambar</td>
                                {{--<td width="20%">Aksi</td>--}}
                            </tr>
                            </thead>
                            <tbody id="kelengkapan-dokumen">
                            @foreach($image_pesantren as $val)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>
                                        <img src="https://api.nyantri.net/img/sekolah/{{$val->nama}}" class="img-fluid" alt="{{ $val->nama }}">
                                    </td>
                                   {{-- <td class="text-center">
                                        <a href="{{ route('kelas.show',$val->id_dokumen) }}" class="button btn-sm btn-success text-white"> Lihat</a>
                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- datatable end -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Kelas di Pesantren ini</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="pull-right">
                        <a href="{{ route('kelas.create') }}" class="btn btn-success btn-sm waves-effect text-sm-center"><i
                                        class="fal fa-plus-circle"></i> Tambah Kelas
                        </a>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-content">
                            <!-- datatable start -->
                            <table class="table table-bordered table-hover table-striped w-100" id="kelas-table">
                                <thead>
                                <tr>
                                    <td width="2%">No</td>
                                    <td>Nama Kelas</td>
                                    <td width="20%">Action</td>
                                </tr>
                                </thead>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Santri di Pesantren ini</strong> <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="pull-right">
                        <a href="{{ route('santri.create') }}" class="btn btn-success btn-sm waves-effect text-sm-center"><i
                                    class="fal fa-plus-circle"></i> Tambah Santri
                        </a>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-content">
                            <!-- datatable start -->
                            <table class="table table-bordered table-hover table-striped w-100" id="santri-table">
                                <thead>
                                <tr>
                                    <td width="2%">No</td>
                                    <td>Nama</td>
                                    <td>Asal</td>
                                    <td>Status Kesehatan</td>
                                    <td>Wali Santri</td>
                                    <td>Status</td>
                                    <td width="20%">Action</td>
                                </tr>
                                </thead>
                            </table>
                            <!-- datatable end -->
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
    <script src="{{ asset('back-end/js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script>
        var table;
        var table2;
        $(function(){
            'use strict';
            table = $('#kelas-table').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Cari...',
                    sSearch: '',
                    lengthMenu: '_MENU_ post/halaman',
                },
                processing: true,
                serverSide: true,
                'ajax': {
                    'url': '{{ route('kelas.data') }}',
                    'type': 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false
                    },
                    {
                        data: 'nama_kelas', name: 'nama_kelas', orderable: true,
                    },
                    {
                        data: '_action', name: '_action'
                    }
                ],
                columnDefs: [
                    {
                        className: 'text-center',
                        targets: [0, 2]
                    }
                ],
            });
        });
        $(function(){
            'use strict';
            table2 = $('#santri-table').DataTable({
                responsive: true,
                language: {
                    searchPlaceholder: 'Cari...',
                    sSearch: '',
                    lengthMenu: '_MENU_ post/halaman',
                },
                processing: true,
                serverSide: true,
                'ajax': {
                    'url': '{{ route('santri.data') }}',
                    'type': 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false
                    },
                    {
                        data: 'nama_santri', name: 'nama_santri', orderable: true,
                    },
                    {
                        data: 'asal_santri', name: 'asal_santri', orderable: true,
                    },
                    {
                        data: 'status_kesehatan', name: 'status_kesehatan', orderable: true,
                    },
                    {
                        data: 'name', name: 'name', orderable: true,
                    },
                    {
                        data: 'status_aktivasi', name: 'status_aktivasi', orderable: true,
                    },
                    {
                        data: '_action', name: '_action'
                    }
                ],
                columnDefs: [
                    {
                        className: 'text-center',
                        targets: [0, 4,5,6]
                    }
                ],
            });
        });

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

    </script>
@endpush
