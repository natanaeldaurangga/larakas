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
            </div>
            <div class="card-body">
                <table style="width: 100%" id="table-detail-piutang" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Saldo</th>
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
        function pembayaran(id_piutang) {
            $('input[name="id_piutang"]').val(id_piutang);
        }

        // TODO: Fitur selanjutnya untuk pencatatan penghapusan piutang
        function hapus(id_piutang) {

        }

        function format_tbl_piutang(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">ID pelanggan</label>
                        <span class="col-lg-9">: ${d.id_piutang}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Nama</label>
                        <span class="col-lg-9">: ${d.tanggal}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Keterangan</label>
                        <span class="col-lg-9">: ${d.keterangan}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Saldo</label>
                        <span class="col-lg-9">: ${rupiah.format(d.saldo)}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <span class="col-lg-9 d-flex justify-content-start">
                            <button type="button" class="btn btn-warning btn-pembayaran" data-toggle="modal" data-target="#form-pembayaran-piutang" onclick="pembayaran('${d.id_piutang}');">
                                <li class="fa fa-edit"></li>
                            </button>
                            <a href="{{ url('/page-detail-pembayaran-piutang') }}/${d.id_piutang}" class="btn btn-info ml-3">
                                <li class="fa fa-info"></li>
                            </a>
                        </span>
                    </div>
                </div>
                `;
        }

        let table;

        $(document).ready(function() {
            table = $('#table-detail-piutang').DataTable({
                "ajax": {
                    "url": "{{ url('/data-piutang-pelanggan/' . $pelanggan->id_pelanggan) }}",
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
                        "className": 'dt-control ml-2',
                        "orderable": true,
                        "data": null,
                        "defaultContent": '',
                    },
                    {
                        "data": "tanggal",
                    },
                    {
                        "data": "keterangan",
                    },
                    {
                        "data": "saldo",
                        "render": function(data, type, row, meta) {
                            return rupiah.format(data);
                        }
                    },
                ],
                "columnDefs": [{
                        "targets": [2],
                        "className": "d-none d-lg-table-cell",
                    },
                    {
                        "targets": [3],
                        "className": "d-none d-md-table-cell",
                    },
                    {
                        "targets": [1],
                        "className": "d-sm-table-cell",
                    },
                ]
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
    </script>

    @include('modalForm.formPembayaranPiutang')
@endsection
