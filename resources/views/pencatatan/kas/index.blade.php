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
                <h1>Daftar kas</h1>
                <a href="/kas/create" class="btn btn-success">Catat transaksi kas</a>
            </div>
            {{-- TODO: Lanjut ke kas --}}
            <div class="card-body">
                <table style="width: 100%" id="table-kas" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
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
                        <label for="" class="col-lg-3">Debit</label>
                        <span class="col-lg-9">${rupiah.format(d.pos == 1 ? d.saldo : 0)}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Kredit</label>
                        <span class="col-lg-9">${rupiah.format(d.pos == 0 ? d.saldo : 0)}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <span class="col-lg-9 d-flex justify-content-start">
                            <a href="<?= url('/kas') ?>/${d.id_kas}/edit" class="btn btn-warning">
                                <li class="fa fa-edit"></li>
                            </a>
                            <form action="/kas/${d.id_pencatatan}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger ml-3" onclick="return confirm('Anda yakin?')">
                                    <li class="fa fa-trash"></li>
                                </button>
                            </form>
                        </span>
                    </div>
                </div>
                `;
        }

        $(document).ready(function() {

            let table = $('#table-kas').DataTable({
                "ajax": {
                    "url": "{{ url('/arus-kas') }}",
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
                        "data": "created_at",
                    },
                    {
                        "data": "keterangan"
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
                        "targets": [3, 4],
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
                        "targets": [3, 4],
                        "className": "d-none d-lg-table-cell"
                    },
                ]
            });

            table.on('click', 'td.dt-control', function() {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                // console.log(row.data());
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format_tbl_kas(row.data())).show();
                    tr.addClass('shown');
                }
            });

        });
    </script>
@endsection
