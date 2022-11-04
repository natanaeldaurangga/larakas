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
                <h1>utang {{ $pemasok->nama }}</h1>
                <button type="button" class="btn btn-success btn-pembayaran" data-toggle="modal"
                    data-target="#form-pembayaran-utang" onclick="pembayaran('{{ $utang->id_utang }}')">
                    Catat Pembayaran
                </button>
            </div>
            <div class="card-body">
                <table style="width: 100%" id="table-detail-utang" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- TODO: Lanjut untuk edit, pembayaran, dan hapus utang --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // TODO: utang sudah beres, tinggal lanjut untuk authorisasi, gate dan policy
        function pembayaran(id_utang) {
            $('input[name="id_utang"]').val(id_utang);
        }

        function format_tbl_utang(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">ID pemasok</label>
                        <span class="col-lg-9">: ${d.id_utang}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Tanggal</label>
                        <span class="col-lg-9">: ${d.tanggal}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Keterangan</label>
                        <span class="col-lg-9">: ${d.keterangan}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Debit</label>
                        <span class="col-lg-9">: ${rupiah.format(d.pos == 1 ? d.saldo : 0)}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Kredit</label>
                        <span class="col-lg-9">: ${rupiah.format(d.pos == 0 ? d.saldo : 0)}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <button type="button" class="btn btn-danger ml-3 btn-hapus" data-id="${d.id_pencatatan}" onclick="hapus('${d.id_pencatatan}');">
                        <li class="fa fa-trash"></li>
                    </button>
                    </div>
                </div>
                `;
        }

        // TODO: detail pembayaran sudah, lanjut untuk penghapusan utang

        let table;
        // FIXME: si tabel detail pembayaran jadi error karena nambahin fitur hapus, coba cari tau kenapa
        $(document).ready(function() {
            table = $('#table-detail-utang').DataTable({
                "ajax": {
                    "url": "{{ url('/detail-pembayaran-utang/' . $utang->id_utang) }}",
                    "type": "GET",
                },
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "order": [
                    [1, 'asc'] // DI ORDER BERDASARKAN TANGGAL yaitu column ke 1
                ],
                "columns": [{
                        "className": 'dt-control ml-2',
                        "orderable": true,
                        "data": null,
                        "defaultContent": '',
                    },
                    {
                        "data": "tanggal",
                        "orderable": true,
                    },
                    {
                        "data": "keterangan",
                    },
                    {
                        "data": "saldo",
                        "render": function(data, type, row, meta) {
                            return rupiah.format(row.pos == 1 ? data : 0);
                        }
                    },
                    {
                        "data": "saldo",
                        "render": function(data, type, row, meta) {
                            return rupiah.format(row.pos == 0 ? data : 0);
                        }
                    },
                ],
                "columnDefs": [{
                        "targets": [2],
                        "className": "d-none d-lg-table-cell",
                    },
                    {
                        "targets": [3, 4],
                        "className": "d-none d-md-table-cell text-right",
                    },
                    {
                        "targets": [1],
                        "className": "d-sm-table-cell",
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
                    row.child(format_tbl_utang(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });

        function exec_hapus(id_pencatatan) {
            thisBtn = $("button").find(`[data-id="${id_pencatatan}"]`);
            $.ajax({
                type: "DELETE",
                url: "{{ url('/hapus-utang/') }}/" + id_pencatatan,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                dataType: "json",
                beforeSend: function() {
                    thisBtn.attr('disable', 'disabled');
                    thisBtn.html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function(response) {
                    console.log(response); // TODO: kenapa response nya 0?
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Data tersimpan',
                        text: response.success,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    // TODO: Lanjut untuk insert data utang ke aplikasi
                    $('#form-utang .form-control').val('');
                    $('#form-utang').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    console.log(response);
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

        function hapus(id_pencatatan) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Data akan dihapus",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // console.log('test');
                    exec_hapus(id_pencatatan);
                }
            });
        }
    </script>

    @include('modalForm.formPembayaranutang')
@endsection
