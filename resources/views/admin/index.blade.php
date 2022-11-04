@extends('layouts.dashboard.index')

@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h1>Soft Delete Pencatatan</h1>
                <a href="/kas/create" class="btn btn-success">Catat transaksi kas</a>
            </div>

            <div class="card-body">
                <table style="width: 100%" id="table-pencatatan" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal dihapus</th>
                            <th>Kelompok</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function format_tbl_kas(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">Tanggal</label>
                        <span class="col-lg-9">${d.created_at}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Keterangan</label>
                        <span class="col-lg-9">${d.keterangan}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">User pencatat</label>
                        <span class="col-lg-9">${d.user}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Tanggal Penghapusan</label>
                        <span class="col-lg-9">${d.deleted_at}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <span class="col-lg-9 d-flex justify-content-start">
                            <button type="button" title="Restore" class="btn btn-success ml-3 btn-restore" data-id="${d.id_pencatatan}" onclick="restore('${d.id_pencatatan}');">
                                <li class="fa fa-recycle"></li>
                            </button>
                            <button type="button" title="Permanent Delete" class="btn btn-danger ml-3 btn-hapus" data-id="${d.id_pencatatan}" onclick="hapus('${d.id_pencatatan}');">
                                <li class="fa fa-trash"></li>
                            </button>
                        </span>
                    </div>
                </div>
                `;
        }

        let table;

        $(document).ready(function() {
            table = $('#table-pencatatan').DataTable({
                "ajax": {
                    "url": "{{ url('/riwayat-pencatatan') }}",
                    "type": "GET",
                },
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "columns": [{
                        "className": 'dt-control',
                        "orderable": true,
                        "data": null,
                        "defaultContent": '',
                    },
                    {
                        "data": "deleted_at",
                    },
                    {
                        "data": "group_pencatatan"
                    },
                    {
                        "data": "keterangan",
                    },
                ],
                "columnDefs": [{
                        "targets": [3],
                        "className": "d-none d-lg-table-cell"
                    },
                    {
                        "targets": [2],
                        "className": "d-none d-md-table-cell",
                    },
                    {
                        "targets": [1],
                        "className": "d-sm-table-cell"
                    },
                    {
                        "targets": [3],
                        "className": "d-none d-lg-table-cell"
                    },
                ],
            });

            table.on('click', 'td.dt-control', function() {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format_tbl_kas(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });

        function restore(id_pencatatan) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Data akan dipulihkan dan akan masuk ke transaksi lain",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Pulihkan!',
            }).then((result) => {
                if (result.isConfirmed) {
                    exec_restore(id_pencatatan);
                }
            });
        }

        function hapus(id_pencatatan) {
            Swal.fire({
                title: "Anda yakin?",
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
            }).then((result) => {
                if (result.isConfirmed) {
                    exec_hapus(id_pencatatan);
                }
            });
        }

        // TODO: hapus permanen dan update data pencatatn sudah beres tinggal lanjut laporan keuangan
        function exec_hapus(id_pencatatan) {
            thisBtn = $(".btn-hapus").find(`[data-id="${id_pencatatan}"]`);
            $.ajax({
                type: "DELETE",
                url: "{{ url('/delete-pencatatan/') }}/" + id_pencatatan,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                beforeSend: function() {
                    thisBtn.attr('disable', 'disabled');
                    thisBtn.html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function(response) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Data berhasil dihapus',
                        text: response.success,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#form-piutang .form-control').val('');
                    $('#form-piutang').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('<li class="fa fa-trash"></li>');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    if (response.errors) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan',
                            'error',
                        );
                    }
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                }
            });
        }

        function exec_restore(id_pencatatan) {
            thisBtn = $(".btn-restore").find(`[data-id="${id_pencatatan}"]`);
            $.ajax({
                type: "PUT",
                url: "{{ url('/restore-pencatatan/') }}/" + id_pencatatan,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                beforeSend: function() {
                    thisBtn.attr('disable', 'disabled');
                    thisBtn.html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function(response) {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Data berhasil dipulihkan',
                        text: response.success,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#form-piutang .form-control').val('');
                    $('#form-piutang').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('<li class="fa fa-recycle"></li>');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    if (response.errors) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan',
                            'error',
                        );
                    }
                    thisBtn.removeAttr('disable');
                    thisBtn.html('<li class="fa fa-recycle"></li>');
                }
            });

        }
    </script>
@endsection
