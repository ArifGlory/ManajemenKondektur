@extends('layouts.app')
@section('title', 'Cari Jadwal Kedinasan')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Cari Jadwal Kedinasan</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-calendar'></i>Cari Jadwal Kedinasan
            <small>
               Silahkan cari Data Jadwal kedinasan pegawai
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right">
            @if(Auth::user()->jenis_user == "admin")
                <a href="{{ url('/jadwal/create') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-plus"></span> Tambah Jadwal</a>
            @endif
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Jadwal</strong> <span class="fw-300"><i>Table</i></span>
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
                        <table class="table table-bordered table-hover table-striped w-100" id="jadwal-table">
                            <thead>
                            <tr>
                                <td width="2%">No</td>
                                <td>Nama</td>
                                <td>NIP</td>
                                <td>Hari</td>
                                <td>Tanggal</td>
                                <td>Jam</td>
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
@endsection

@push('scripts')
@include('datatable._js')
{{--Fungsi script di tampilan transaksi pengguna--}}
<script src="{{ asset('back-end/js/datagrid/datatables/datatables.bundle.js') }}"></script>
<script>
    var table;
    $(function(){
        'use strict';
        table = $('#jadwal-table').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Cari...',
                sSearch: '',
                lengthMenu: '_MENU_ post/halaman',
            },
            processing: true,
            serverSide: true,
            'ajax': {
                'url': '{{ route('jadwal.data-cari-jadwal') }}',
                'type': 'GET',
            },
            columns: [
                {
                    data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: false
                },
                {
                    data: 'name', name: 'name', orderable: true,
                },
                {
                    data: 'nip', name: 'nip', orderable: true,
                },
                {
                    data: 'hari', name: 'hari', orderable: true,
                },
                {
                    data: 'tanggal_jadwal', name: 'tanggal_jadwal', orderable: true,
                },
                {
                    data: 'waktu', name: 'waktu', orderable: true,
                },
                {
                    data: '_action', name: '_action'
                }
            ],
            columnDefs: [
                {
                    className: 'text-center',
                    targets: [0, 1 , 6]
                }
            ],
        });
    });
</script>
@endpush
