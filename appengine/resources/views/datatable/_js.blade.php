<script>
    function deleteTableData(url) {
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
                                    table.ajax.reload()
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
    function aktivasiTableData(url) {
        Swal.fire({
                title: "Yakin ingin mengaktivasi premium santri ini?",
                text: "Saldo pesantren anda akan dikurangi Rp. 10.000",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "Aktivasi",
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
                            type: 'GET',
                            success (res) {
                                if (res.status) {
                                    Swal.fire("Berhasil Aktivasi!", res.pesan, "success");
                                    table.ajax.reload()
                                } else {
                                    Swal.fire("Gagal Aktivasi!", res.pesan, "error");
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
    function restoreTableData(url) {
        Swal.fire({
                title: "Yakin ingin mengembalikan data ini?",
                text: "Data yang restore dapat dihapus lagi!",
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
                                    swal.fire("Restored!", res.pesan, "success");
                                    table.ajax.reload()
                                } else {
                                    swal.fire("Gagal menghapus!", res.pesan, "error");
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
    function gantiKontenTable (title, url) {
        $('#title-table').text(title);
        table.ajax.url(url).load()
    }
</script>
