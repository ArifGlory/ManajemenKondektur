@extends('layouts.app')
@section('title', 'Pesantren')

@push('css')
@endpush

@section('breadcrumb')
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><strong>{{  getSettingData('web_name')->value ?? env('APP_NAME') }}</strong> WebApp</a></li>
        <li class="breadcrumb-item active">Pesantren</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-images'></i> Pesantren
            <small>
                List Pesantren untuk ditampilkan ke aplikasi.
            </small>
        </h1>
        <div class="btn-group btn-group-sm text-center float-right" role="group">
            {{--<a href="{{ route('pesantren') }}" class="btn btn-primary btn-mini waves-effect waves-light"><span class="fal fa-plus"></span> Tambah Pesantren</a>--}}
            {{--<a target="_blank" href="{{ route('pesantren.print') }}" class="btn btn-success btn-mini waves-effect waves-light"><span class="fal fa-print"></span> Cetak Daftar Pesantren</a>--}}
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-info-600 bg-info-gradient">
                    <h2>
                        <strong id="title-table">List</strong> <span class="fw-300"><i>Pesantren</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <select class="custom-select custom-select-sm" id="status">
                            <option selected="" value="">Status</option>
                            <option value="Y">Aktif</option>
                            <option value="terhapus">Terhapus</option>
                        </select>
                    </div>
                    <div class="panel-toolbar ml-2">
                        <div class="d-flex position-relative ml-auto" style="max-width: 8rem;">
                            <i class="fal fa-search position-absolute pos-left fs-lg px-2 py-1 mt-1 fs-xs color-black"></i>
                            <input type="text" id="filter" class="form-control form-control-sm pl-5" placeholder="Filter">
                        </div>
                    </div>
                </div>
                <div class="panel-container show" id="list-Pesantren">
                    @include('back.pesantren._list_pesantren')
                </div>
            </div>
        </div>
    </div>
@endsection

@push ('scripts')
    <script !src="">
        var page = 1;
        $(document).ready(function() {
            $('#status').on('change', function () {
                getData(page)
            })
            $('#filter').keydown(function (e){
                if(e.keyCode == 13) {
                    getData(page)
                }
            })

            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var myurl = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                getData(page);
            });
        });
        function getData(page){
            showLoading(true);
            $.ajax(
                {
                    url: '?page=' + page,
                    type: "get",
                    data: {
                        'search': $('#filter').val(),
                        'status': $('#status').val(),
                        'posisi': $('#posisi').val(),
                    },
                    datatype: "html"
                }).done(function(data){
                showLoading(false);
                $('#list-Pesantren').empty().html(data);
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                showLoading(false)
                Swal.fire("Error", "Terjadi kesalahan pada server!", "error");
            });
        }
        function gantiStatus(id) {
            var status
            if(!$('#status-'+id).prop("checked")) {
                status = 'on'
            } else {
                status = 'off'
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ URL('/pesantren') }}/status/'+id,
                type: 'POST',
                data: {
                    '_method': 'PUT',
                    'active': status
                },
                success (res) {
                    if (res.status) {
                        Swal.fire("Berhasil!", res.pesan, "success");
                    } else {
                        Swal.fire("Gagal!", res.pesan, "error");
                    }
                },
                error (res) {
                    console.log(res)
                }
            })
        }
        function deleteData(url) {
            Swal.fire({
                    title: "Yakin ingin menghapus data ini?",
                    text: "Data yang dihapus tidak dapat dikembalikan lagi!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    cancelButtonClass: "btn-danger",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Tidak",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        return new Promise(function(resolve) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: 'DELETE',
                                success (res) {
                                    if (res.status) {
                                        Swal.fire("Terhapus!", res.pesan, "success");
                                        getData(page)
                                    } else {
                                        Swal.fire("Gagal menghapus!", res.pesan, "error");
                                    }
                                },
                                error (res) {
                                    console.log(res)
                                }
                            })
                        });
                    },
                },
            );
        }
        function restoreData(url) {
            Swal.fire({
                    title: "Restore?",
                    text: "Yakin ingin mengembalikan data ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    cancelButtonClass: "btn-danger",
                    confirmButtonText: "Restore",
                    cancelButtonText: "Tidak",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        return new Promise(function(resolve) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                type: 'POST',
                                success (res) {
                                    if (res.status) {
                                        Swal.fire("Terhapus!", res.pesan, "success");
                                        getData(page)
                                    } else {
                                        Swal.fire("Gagal menghapus!", res.pesan, "error");
                                    }
                                },
                                error (res) {
                                    console.log(res)
                                }
                            })
                        });
                    },
                },
            );
        }
    </script>
@endpush
