<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title') | {{  getSettingData('web_name')->value ?? env('APP_NAME') }}
    </title>
    <meta name="description" content="{{  getSettingData('web_name')->value ?? env('APP_NAME') }} WebApp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/vendors.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/app.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/style_chartdrill.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url(getSettingData('favicon')->value ?? '') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{  url(getSettingData('favicon')->value ?? '') }}">
    <link rel="mask-icon" href="{{ url(getSettingData('favicon')->value ?? '') }}" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/notifications/toastr/toastr.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('back-end/css/statistics/chartjs/chartjs.css') }}">
    <style>
        .is-error {
            color: #fd3995;
            font-size: 0.7rem;
        }
        #loading {
            opacity:0.8;
            background-color:#fff;
            position:fixed;
            width:100%;
            height:100%;
            top:0px;
            left:0px;
            z-index:999999999;
        }
        .swal2-container {
            z-index: 4000!important;
        }
    </style>
    @stack("css")
</head>
<body class="mod-bg-1 ">

<div class="d-flex align-items-center justify-content-center h-100" id="loading" style="display: none!important;">
    <div class="spinner-border text-danger" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <span class="ml-2 text-danger font-weight-bold">Memuat...</span>
</div>
<script>
    'use strict';

    var classHolder = document.getElementsByTagName("BODY")[0],
        themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {},
        themeURL = themeSettings.themeURL || '',
        themeOptions = themeSettings.themeOptions || '';
    if (themeSettings.themeOptions)
    {
        classHolder.className = themeSettings.themeOptions;
    }
    else
    {
    }
    if (themeSettings.themeURL && !document.getElementById('mytheme'))
    {
        var cssfile = document.createElement('link');
        cssfile.id = 'mytheme';
        cssfile.rel = 'stylesheet';
        cssfile.href = themeURL;
        document.getElementsByTagName('head')[0].appendChild(cssfile);
    }
    var saveSettings = function()
    {
        themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
        {
            return /^(nav|header|mod|display)-/i.test(item);
        }).join(' ');
        if (document.getElementById('mytheme'))
        {
            themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
        };
        localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
    };
    var resetSettings = function()
    {
        localStorage.setItem("themeSettings", "");
    }

</script>
<div class="page-wrapper">
    <div class="page-inner">
        <!-- BEGIN Left Aside -->
        <aside class="page-sidebar">
            <div class="page-logo">
                <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
                    <img src="{{ asset(getSettingData('logo')->value) }}" alt="" aria-roledescription="logo" style="width: 28px">
                    <span class="page-logo-text mr-1"><strong>Manajemen Kondektur</strong></span>
                    <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
                </a>
            </div>
            <!-- BEGIN PRIMARY NAVIGATION -->
            <nav id="js-primary-nav" class="primary-nav" role="navigation">
                <div class="nav-filter">
                    <div class="position-relative">
                        <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                        <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                            <i class="fal fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="info-card">
                    <img src="{{ asset('img/pegawai/'.Auth::user()->foto) }}" class="profile-image rounded-circle" alt="User">
                    <div class="info-card-text">
                        <a href="#" class="d-flex align-items-center text-white">
                                    <span class="font-weight-bold text-truncate text-truncate-sm d-inline-block">
                                        {{ Auth::user()->name}}
                                    </span>
                        </a>
                        <span class="d-inline-block text-truncate text-truncate-sm">{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</span>
                    </div>
                    <img src="{{ asset('back-end/img/card-backgrounds/cover-2-lg.png') }}" class="cover" alt="cover">
                    <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                        <i class="fal fa-angle-down"></i>
                    </a>
                </div>
                @include('layouts.partials.left')
                <div class="filter-message js-filter-message bg-success-600"></div>
            </nav>
            <!-- END PRIMARY NAVIGATION -->
            <!-- NAV FOOTER -->
            <div class="nav-footer shadow-top">
                <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
                    <i class="ni ni-chevron-right"></i>
                    <i class="ni ni-chevron-right"></i>
                </a>
            </div>
        </aside>
        <div class="page-content-wrapper">
            @include('layouts.partials.top')
            <main id="js-page-content" role="main" class="page-content">
                @yield('breadcrumb')
                @yield('content', 'Hello')
            </main>
            <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
            <!-- BEGIN Page Footer -->
            <footer class="page-footer" r7ole="contentinfo">
                <div class="d-flex align-items-center flex-1 text-muted">
                    <span class="hidden-md-down fw-700">2021 © Manajemen Kondektur</span>
                </div>
                {{--<div>
                    <ul class="list-table m-0">
                        <li><a href="intel_introduction.html" class="text-secondary fw-700">About</a></li>
                        <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">License</a></li>
                        <li class="pl-3"><a href="info_app_docs.html" class="text-secondary fw-700">Documentation</a></li>
                        <li class="pl-3 fs-xl"><a href="https://wrapbootstrap.com/user/MyOrange" class="text-secondary" target="_blank"><i class="fal fa-question-circle" aria-hidden="true"></i></a></li>
                    </ul>
                </div>--}}
            </footer>
            <!-- END Page Footer -->
            <!-- BEGIN Shortcuts -->

            <div class="modal fade" id="modal-ganti-password" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                Ganti Password <i class="fal fa-key"></i>
                            </h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <div class="input-group input-group-sm bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                            <i class="fal fa-reply"></i>
                                                        </span>
                                            </div>
                                            <input required name="change-old-password" type="password" class="form-control bg-transparent pl-0" placeholder="Password lama..">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="input-group input-group-sm bg-white shadow-inset-2\">
                                            <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                            <i class="fal fa-key"></i>
                                                        </span>
                                            </div>
                                            <input required name="change-password" type="password" class="form-control bg-transparent pl-0" placeholder="Password baru..">
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div class="input-group input-group-sm bg-white shadow-inset-2">
                                            <div class="input-group-prepend">
                                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                            <i class="fal fa-redo"></i>
                                                        </span>
                                            </div>
                                            <input required name="change-re-password" type="password" class="form-control bg-transparent pl-0" placeholder="Ketik Ulang Password baru..">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary waves-effect waves-themed" data-dismiss="modal">Close</button>
                            <button id="btn-password" type="button" class="btn btn-sm btn-primary waves-effect waves-themed"><i class="fal fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Shortcuts -->
            <!-- BEGIN Color profile -->
            <!-- this area is hidden and will not be seen on screens or screen readers -->
            <!-- we use this only for CSS color refernce for JS stuff -->
            <p id="js-color-profile" class="d-none">
                <span class="color-primary-50"></span>
                <span class="color-primary-100"></span>
                <span class="color-primary-200"></span>
                <span class="color-primary-300"></span>
                <span class="color-primary-400"></span>
                <span class="color-primary-500"></span>
                <span class="color-primary-600"></span>
                <span class="color-primary-700"></span>
                <span class="color-primary-800"></span>
                <span class="color-primary-900"></span>
                <span class="color-info-50"></span>
                <span class="color-info-100"></span>
                <span class="color-info-200"></span>
                <span class="color-info-300"></span>
                <span class="color-info-400"></span>
                <span class="color-info-500"></span>
                <span class="color-info-600"></span>
                <span class="color-info-700"></span>
                <span class="color-info-800"></span>
                <span class="color-info-900"></span>
                <span class="color-danger-50"></span>
                <span class="color-danger-100"></span>
                <span class="color-danger-200"></span>
                <span class="color-danger-300"></span>
                <span class="color-danger-400"></span>
                <span class="color-danger-500"></span>
                <span class="color-danger-600"></span>
                <span class="color-danger-700"></span>
                <span class="color-danger-800"></span>
                <span class="color-danger-900"></span>
                <span class="color-warning-50"></span>
                <span class="color-warning-100"></span>
                <span class="color-warning-200"></span>
                <span class="color-warning-300"></span>
                <span class="color-warning-400"></span>
                <span class="color-warning-500"></span>
                <span class="color-warning-600"></span>
                <span class="color-warning-700"></span>
                <span class="color-warning-800"></span>
                <span class="color-warning-900"></span>
                <span class="color-success-50"></span>
                <span class="color-success-100"></span>
                <span class="color-success-200"></span>
                <span class="color-success-300"></span>
                <span class="color-success-400"></span>
                <span class="color-success-500"></span>
                <span class="color-success-600"></span>
                <span class="color-success-700"></span>
                <span class="color-success-800"></span>
                <span class="color-success-900"></span>
                <span class="color-fusion-50"></span>
                <span class="color-fusion-100"></span>
                <span class="color-fusion-200"></span>
                <span class="color-fusion-300"></span>
                <span class="color-fusion-400"></span>
                <span class="color-fusion-500"></span>
                <span class="color-fusion-600"></span>
                <span class="color-fusion-700"></span>
                <span class="color-fusion-800"></span>
                <span class="color-fusion-900"></span>
            </p>
            <!-- END Color profile -->
        </div>
    </div>
</div>
<!-- END Page Wrapper -->
<!-- BEGIN Quick Menu -->
<!-- END Quick Menu -->
<script src="{{ asset('back-end/js/vendors.bundle.js') }}"></script>
<script src="{{ asset('back-end/js/app.bundle.js') }}"></script>
<script src="{{ asset('back-end/js/notifications/toastr/toastr.js') }}"></script>
<script src="{{ asset('back-end/js/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>
<script !src="">
    function showLoading(bool) {
        if(bool) {
            $('#loading').show();
        } else {
            $('#loading').attr("style", "display: none !important");
        }
    }
    $(document).ready(function () {
        $('#btn-pass').on('click', function () {
            event.preventDefault();
            $('#modal-ganti-password').modal('show')
        })
        $('#btn-password').on('click', function () {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '',
                data: {
                  'change-old-password': $('input[name="change-old-password"]').val(),
                  'change-password': $('input[name="change-password"]').val(),
                  'change-re-password': $('input[name="change-re-password"]').val(),
                },
                success (res) {
                    if(res.status) {
                        swal.fire("Berhasil!", res.pesan, "success");
                    } else {
                        swal.fire("Gagal!", res.pesan, "error");
                    }
                },
                error: function (err) {
                    if (err.status == 422) {
                        $( ".invalid-feedback" ).remove();
                        $("input").removeClass("is-invalid");
                        $.each(err.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="'+i+'"]');
                            el.addClass('is-invalid')
                            el.after($('<div class="invalid-feedback"><strong>'+error[0]+'</strong></span></div>'));
                        });
                    }
                }
            })
        })
    @if(session('pesan_status'))
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 100,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr['{{session('pesan_status.tipe')}}']('{{session('pesan_status.desc')}}', '{{session('pesan_status.judul')}}');
    @endif

    @if($errors->any())
        toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 100,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
        toastr['error']('Silahkan pilih waktu yang lain', '{{$errors->first()}}');
    @endif
    });
</script>
<script src="{{ asset('js/helper.js') }}"></script>
@stack('scripts')
</body>
</html>
