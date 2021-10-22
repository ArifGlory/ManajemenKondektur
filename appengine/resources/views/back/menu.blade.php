@extends('layouts.app')
@section('title', 'Menu')

@push('css')
@endpush
@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME')}}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Menu</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cube'></i> Menu
            <small>
                Informasi menu singkat pada front-end aplikasi
            </small>
        </h1>
    </div>
@endsection

@section('content')

{!! Menu::render() !!}

@endsection

@push('scripts')

    {!! Menu::scripts() !!}

@endpush
