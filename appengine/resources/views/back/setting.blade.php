@extends('layouts.app')
@section('title', 'Seting Website')

@push('css')
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/formplugins/summernote/summernote.css') }}">
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Setting</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-newspaper'></i> Setting
            <small>
                Silahkan isi setting aplikasi.
            </small>
        </h1>
    </div>
@endsection

@section('content')
    {!! Form::open(['route' => 'setting.store', 'method' => 'POST', 'id' => 'form-post', 'files' => true]) !!}
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="panel">
                <div class="panel-hdr">
                    <h2>
                        <strong id="title-table">Setting</strong> <span class="fw-300"><i>Website</i></span>
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
                                    <label class="form-label">Nama Website</label>
                                    {!! Form::text('web_name', $set['web_name'] ?? null,['class' => 'form-control', 'placeholder' => 'Nama Website..']) !!}
                                    @error('web_name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Owner Website</label>
                                    {!! Form::text('web_owner', $set['web_owner'] ?? null,['class' => 'form-control', 'placeholder' => 'Owner Website..']) !!}
                                    @error('web_owner')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keyword Website</label>
                                    {!! Form::text('web_keyword', $set['web_keyword'] ?? null,['class' => 'form-control', 'placeholder' => 'Keyword Website..']) !!}
                                    @error('web_keyword')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi Website</label>
                                    {!! Form::textarea('web_description', $set['web_description'] ?? null,['rows' => 2, 'class' => 'form-control', 'placeholder' => 'Deskripsi Website..']) !!}
                                    @error('web_description')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Alamat Instansi</label>
                                    {!! Form::textarea('address', $set['address'] ?? null,['rows' => 2, 'class' => 'form-control', 'placeholder' => 'Alamat Instansi..']) !!}
                                    @error('address')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    {!! Form::text('email', $set['email'] ?? null,['class' => 'form-control', 'placeholder' => 'Email..']) !!}
                                    <span class="help-block">Gunakan tanda koma (,) apabila terdapat 2 email.</span>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Telephone</label>
                                    {!! Form::text('telephone', $set['telephone'] ?? null,['class' => 'form-control', 'placeholder' => 'Telephone..']) !!}
                                    <span class="help-block">Gunakan tanda koma (,) apabila terdapat 2 nomor telephone.</span>
                                    @error('telephone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Fax</label>
                                    {!! Form::text('fax', $set['fax'] ?? null,['class' => 'form-control', 'placeholder' => 'Fax..']) !!}
                                    <span class="help-block">Gunakan tanda koma (,) apabila terdapat 2 nomor fax.</span>
                                    @error('fax')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
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
                        <strong id="title-table">Setting</strong> <span class="fw-300"><i>Tambahan</i></span>
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
                                @isset($set['logo'])
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <img height="100px" src="{{ url($set['logo']) }}" alt="Logo {{ getSettingData('web_name')->value ?? env('APP_NAME') }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-label">Logo Website</label>
                                    {!! Form::file('logo', null,['class' => 'form-control']) !!}
                                    @error('logo')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                @isset($set['favicon'])
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <img height="100px" src="{{ url($set['favicon']) }}" alt="Favicon {{ getSettingData('web_name')->value ?? env('APP_NAME') }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-label">Favicon Web</label>
                                    {!! Form::file('favicon', null,['class' => 'form-control']) !!}
                                    @error('favicon')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <br>
                                <br>
                                <div class="form-group">
                                    <label class="form-label">Link Facebook</label>
                                    {!! Form::text('facebook', $set['facebook'] ?? null,['class' => 'form-control', 'placeholder' => 'URL Facebook..']) !!}
                                    @error('facebook')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Link Twitter</label>
                                    {!! Form::text('twitter', $set['twitter'] ?? null,['class' => 'form-control', 'placeholder' => 'URL Twitter..']) !!}
                                    @error('twitter')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Link Youtube</label>
                                    {!! Form::text('youtube', $set['youtube'] ?? null,['class' => 'form-control', 'placeholder' => 'URL Youtube..']) !!}
                                    @error('youtube')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Link Instagram</label>
                                    {!! Form::text('instagram', $set['instagram'] ?? null,['class' => 'form-control', 'placeholder' => 'URL Instagram..']) !!}
                                    @error('instagram')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content text-right py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <button onclick="saveData()" class="btn btn-info btn-sm waves-effect text-right"><i
                                class="fal fa-save"></i> Simpan Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@push('scripts')
    @include('layouts.partials._helper_js')
    {{--Fungsi script di tampilan transaksi pengguna--}}
    <script src="{{ asset('back-end/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ asset('back-end/js/formplugins/summernote/summernote.js') }}"></script>
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
                    $('#form-post').submit()
                    showLoading(true);
                }
            })
        }
    </script>
@endpush
