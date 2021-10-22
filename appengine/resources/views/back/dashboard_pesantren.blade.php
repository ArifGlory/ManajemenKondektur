@extends('layouts.app')
@section('title', 'Dashboard')

@push('css')
@endpush
@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href=""><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cube'></i> Dashboard
            <small>
                Informasi singkat dari aplikasi
            </small>
        </h1>
        <h2 class="pull-right">Saldo : Rp.  {{ number_format($saldo,0,',','.')}}</h2>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{$jml_santri}}
                        <small class="m-0 l-h-n">Jumlah Santri Terdaftar</small>
                    </h3>
                </div>
                <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{$jml_kelas}}
                        <small class="m-0 l-h-n">Jumlah Kelas</small>
                    </h3>
                </div>
                <i class="fa fa-file-pdf position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{$jml_jadwal}}
                        <small class="m-0 l-h-n">Jumlah Jadwal</small>
                    </h3>
                </div>
                <i class="fa fa-star position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6  sortable-grid ui-sortable">
            <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
                <div class="panel-hdr" role="heading">
                    <h2 class="ui-sortable-handle">
                        Santri Terbaru
                    </h2>
                </div>
                <div class="col-sm-12">
                    <div id="panel-1" class="panel">
                        <div class="panel-container show">
                            <div class="panel-content">
                                <!-- datatable start -->
                                @php
                                    $no = 1;
                                @endphp
                                <table class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                    <tr>
                                        <td width="2%">No</td>
                                        <td>Nama Santri</td>
                                        <td>Asal Santri</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($santri_new as $val)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$val->nama_santri}}</td>
                                            <td>{{$val->asal_santri}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-2 text-center">
                                    @if(count($santri_new) == 0)
                                        <h5>Belum ada santri</h5>
                                    @endif
                                </div>
                                <!-- datatable end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6  sortable-grid ui-sortable">
            <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
                <div class="panel-hdr" role="heading">
                    <h2 class="ui-sortable-handle">
                        Jadwal Kegiatan Terbaru
                    </h2>
                </div>
                <div class="col-sm-12">
                    <div id="panel-1" class="panel">
                        <div class="panel-container show">
                            <div class="panel-content">
                                <!-- datatable start -->
                                @php
                                    $no = 1;
                                @endphp
                                <table class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                    <tr>
                                        <td width="2%">No</td>
                                        <td>Nama Jadwal</td>
                                        <td>Tanggal</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jadwal_new as $val)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$val->nama_jadwal}}</td>
                                            <td>{{ \Carbon\Carbon::parse($val->tanggal_jadwal)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-2 text-center">
                                    @if(count($santri_new) == 0)
                                        <h5>Belum ada santri</h5>
                                    @endif
                                </div>
                                <!-- datatable end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6  sortable-grid ui-sortable">
            <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
                <div class="panel-hdr" role="heading">
                    <h2 class="ui-sortable-handle">
                        Cara Isi  Saldo
                    </h2>
                </div>
                <div class="panel-container show" role="content"><div class="loader"><i class="fal fa-spinner-third fa-spin-4x fs-xxl"></i></div>
                    <div class="panel-content p-0">
                        <div class="col-md-12">
                            <table class="table table-borderless table-responsive">
                                <tr>
                                    <th>No.</th>
                                    <th>Deskripsi</th>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>
                                        Melakukan transfer sejumlah saldo yang diinginkan ke <strong> No. Rekening Nyantri BCA 3749022222 A.N Kreasi multi teknologi pt </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Simpan Bukti Transfer</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Hubungi Admin Nyantri dengan menekan tombol di bagian sidebar (menu sebelah kiri)</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Jendela Whatsapp akan terbuka dan isi format untuk melakukan Top-up saldo sebagai berikut
                                    </td>
                                </tr>
                                <tr>
                                    <td>5.</td>
                                    <td>Format Isi saldo : <br><br>
                                        Nama Pesantren : <br>
                                        Jumlah Pengisian : <br>
                                        Nama Pengirim : <br>
                                        <br>
                                        Serta melampirkan Bukti Bayar
                                    </td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td>Admin Nyantri akan memproses permintaan anda (akan membutuhkan waktu beberapa menit)
                                    </td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td>Setelah pembayaran dikonfirmasi, saldo anda akan segera terisi
                                    </td>
                                </tr>
                                <tr>
                                    <td>8.</td>
                                    <td>Selesai
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6  sortable-grid ui-sortable">
            <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
                <div class="panel-hdr" role="heading">
                    <h2 class="ui-sortable-handle">
                        Prosedur Input Data Pertama Kali (dengan input data Massal)
                    </h2>
                </div>
                <div class="panel-container show" role="content"><div class="loader"><i class="fal fa-spinner-third fa-spin-4x fs-xxl"></i></div>
                    <div class="panel-content p-0">
                        <div class="col-md-12">
                            <table class="table table-borderless table-responsive">
                                <tr>
                                    <th>No.</th>
                                    <th>Deskripsi</th>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>
                                        Inputkan data Wali Santri terlebih dahulu, karena email wali santri dibutuhkan <br>
                                        untuk input data santri nantinya
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Inputkan data Santri-nya</td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Inputkan Data Kelas</td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>Selesai
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
@endpush
