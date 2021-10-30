@extends('layouts.app')
@section('title', 'Dashboard Pegawai')
@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/datagrid/datatables/datatables.bundle.css') }}">
@endpush

@push('css')
@endpush
@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href=""><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Dashboard Pegawai</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cube'></i> Dashboard
            <small>
                Informasi singkat dari aplikasi
            </small>
        </h1>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-6 col-xl-6">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{$jml_pegawai}}
                        <small class="m-0 l-h-n">Jumlah Kondektur Terdaftar</small>
                    </h3>
                </div>
                <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-6">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{$jml_jadwal}}
                        <small class="m-0 l-h-n">Jumlah Jadwal</small>
                    </h3>
                </div>
                <i class="fa fa-file-pdf position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 sortable-grid ui-sortable">
            <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
                <div class="panel-hdr" role="heading">
                    <h2 class="ui-sortable-handle">
                        Data Jadwal Terbaru
                    </h2>
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
    <div class="row">
       

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('back-end/js/statistics/sparkline/sparkline.bundle.js') }}"></script>
    <script src="{{ asset('back-end/js/statistics/easypiechart/easypiechart.bundle.js') }}"></script>
    <script src="{{ asset('back-end/js/statistics/chartjs/chartjs.bundle.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
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
