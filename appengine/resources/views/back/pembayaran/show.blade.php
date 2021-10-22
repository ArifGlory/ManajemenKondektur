@extends('layouts.app')
@section('title', 'Lihat Detail Pembayaran')

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
        <li class="breadcrumb-item"><a href="{{ route('pembayaran.index') }}">Pembayaran</a></li>
        <li class="breadcrumb-item active">Detail Pembayaran</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Detail Pembayaran
            <small>
                Detail Pembayaran.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            <a href="{{ route('pembayaran.index') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Detail</strong> <span class="fw-300"><i>Pembayaran</i></span>
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
                                    <h5>{{$data->name}}</h5>
                                </div>
                                <div class="form-group mt-4">
                                    <label class="form-label">Nama Santri</label>
                                    <h5>{{$data->nama_santri}}</h5>
                                </div>
                                <div class="form-group mt-4">
                                    <label class="form-label">Jumlah Pembayaran</label>
                                    <h5>Rp. {{ number_format($data->jml_bayar,0,',','.')}}</h5>
                                </div>
                                <div class="form-group mt-4">
                                    <label class="form-label">Tagihan Bulan/Tahun</label>
                                    <h5>{{$data->bulan}} - {{$data->tahun}}</h5>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label">Tagihan Dibuat pada</label>
                                    <h5>{{ \Carbon\Carbon::parse($data->tgl_buat_tagihan)->format('d M Y') }}</h5>
                                    <div id="holder" class="text-center" style="margin-top:15px;max-height:100px;">
                                    </div>
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
