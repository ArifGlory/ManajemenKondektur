@extends('layouts.app')
@section('title', 'Tukar Jadwal Kedinasan')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cari-jadwal') }}">Jadwal Kedinasan</a></li>
        <li class="breadcrumb-item active">Ajukan Tukar Jadwal Kedinasan</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-calendar'></i> Ajukan Tukar Jadwal Kedinasan
            <small>
                Silahkan isi data jadwal
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" jabatan="group">
            <a href="{{ route('cari-jadwal') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-backward"></span> Kembali</a>
        </div>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'jadwal.store-penukaran', 'method' => 'POST', 'id' => 'form-pegawai', 'files' => true]) !!}
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Data Penukaran Jadwal</h5>
                                <span>Silahkan mengisi data penukaran jadwal yang akan digunakan dalam fungsi aplikasi ini.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-form-label">Nama Pegawai</label>
                            <div class="col-sm-12">
                                <input name="id_pegawai" value="{{$data->id}}" type="hidden">
                                <input name="id_jadwal" value="{{$data->id_jadwal}}" type="hidden">
                                <h4>{{$data->name}} - NIP. {{$data->nip}}</h4>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-form-label">Pilih Jadwal Kereta Yang Dapat Ditukar</label>
                            <div class="col-sm-12">
                                <select class="form-control select2" name="id_jadwal_tukar" id="select_jadwal" required>
                                    @foreach($available_kereta as $val)
                                        @if($val->id_jadwal != $data->id_jadwal)
                                            <option value="{{$val->id_jadwal}}"> {{$val->nama_kereta}} - {{$val->nomor_kereta}}  &nbsp;|&nbsp;  {{$val->hari}}, {{ \Carbon\Carbon::parse($val->tanggal_jadwal)->format('d M Y') }} </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('id_kereta')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-form-label">Alasan Tukar Jadwal</label>
                            <div class="col-sm-12">
                                <select class="form-control select2" name="select_alasan" id="select_alasan" required>
                                    <option value="sakit">Sakit</option>
                                    <option value="lainnya">Lainnya (Deskripsikan Alasan)</option>
                                </select>
                                @error('select_alasan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-form-label">Deskripsi Alasan</label>
                            <div class="col-sm-12">
                                {!! Form::textarea('deskripsi_alasan', null, ['id' => 'deskripsi_alasan', 'rows' => 4, 'style' => 'resize:none','class' => 'form-control', $errors->has('deskripsi_alasan') ? 'form-control-danger' : '',
                                'placeholder' => 'Alasan penukaran jadwal','disabled'=> 'disabled']) !!}
                                @error('deskripsi_alasan')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div id="container-file" class="form-group row">
                            <label class="col-12 col-form-label">Surat Keterangan Sakit (Jika Alasan Sakit)</label>
                            <div class="col-sm-12">
                                <input accept="image/*" required id="file_pendukung" class="form-control @error('file_pendukung') is-invalid @enderror" type="file" name="file_pendukung">
                                @error('file_pendukung')
                                <div class="col-form-label">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        </div>


                        <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted p-4">
                            <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-left"><i
                                        class="fal fa-save"></i> Simpan Data
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-white">Jadwal Lama</h5>
                                <span>Berikut adalah jadwal yang ingin ditukar.</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Kereta</label>
                            <h2>{{$data->nama_kereta}} - {{$data->nomor_kereta}} </h2>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Tanggal</label>
                            <h5>{{ \Carbon\Carbon::parse($data->tanggal_jadwal)->format('d M Y') }}</h5>
                        </div>

                        <div class="form-group row">
                            <label class="col-12 col-md-4 col-form-label">Hari</label>
                            <h5>{{$data->hari}}</h5>
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
        $('#select_alasan').on('change', function() {
           var alasan = $(this).val();
           console.log("alasan : "+alasan);
           if (alasan == "lainnya"){
               $('#deskripsi_alasan').attr('disabled', false).focus();

               $('#container-file').addClass('d-none');
           }else{
               $('#deskripsi_alasan').val("");
               $('#deskripsi_alasan').attr('disabled', true);

               $('#container-file').removeClass('d-none');
           }
        });
    </script>
@endpush
