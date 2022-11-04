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
                <h1>Piutang {{ $pelanggan->nama }}</h1>
                <button type="button" class="btn btn-success btn-pembayaran" data-toggle="modal"
                    data-target="#form-pembayaran-piutang" onclick="pembayaran('{{ $piutang->id_piutang }}')">
                    Catat Pembayaran
                </button>
            </div>
            <div class="card-body">
                <table style="width: 100%" id="table-detail-piutang" class="table table-hover table-striped">
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
                        {{-- TODO: Lanjut untuk edit, pembayaran, dan hapus piutang --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // TODO: permasalahan piutang sudah beres, tinggal copy-copy untuk utang
        function pembayaran(id_piutang) {
            $('input[name="id_piutang"]').val(id_piutang);
        }

        function format_tbl_piutang(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">ID pelanggan</label>
                        <span class="col-lg-9">: ${d.id_piutang}</span>
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

        // TODO: detail pembayaran sudah, lanjut untuk penghapusan piutang

        let table;
        // FIXME: si tabel detail pembayaran jadi error karena nambahin fitur hapus, coba cari tau kenapa
        $(document).ready(function() {
            table = $('#table-detail-piutang').DataTable({
                "ajax": {
                    "url": "{{ url('/detail-pembayaran-piutang/' . $piutang->id_piutang) }}",
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
                    row.child(format_tbl_piutang(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });

        function exec_hapus(id_pencatatan) {
            thisBtn = $("button").find(`[data-id="${id_pencatatan}"]`);
            $.ajax({
                type: "DELETE",
                url: "{{ url('/hapus-piutang/') }}/" + id_pencatatan,
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
                    // TODO: Lanjut untuk insert data piutang ke aplikasi
                    $('#form-piutang .form-control').val('');
                    $('#form-piutang').modal('hide');
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
                text: "You won't be able to revert this!",
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

    @include('modalForm.formPembayaranPiutang')
@endsection
