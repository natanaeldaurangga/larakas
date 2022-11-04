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
                <h1>Daftar piutang</h1>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#form-piutang">Catat
                    Piutang</button>
                <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#form-piutang">Cetak
                    Laporan</button>
            </div>
            {{-- TODO: Lanjut ke piutang --}}
            <div class="card-body">
                <table style="width: 100%" id="table-piutang" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('modalForm.formPiutang')

    <script>
        function format_tbl_piutang(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">ID pelanggan</label>
                        <span class="col-lg-9">${d.id_pelanggan}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Nama</label>
                        <span class="col-lg-9">${d.nama}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Saldo</label>
                        <span class="col-lg-9">${rupiah.format(d.saldo)}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <span class="col-lg-9 d-flex justify-content-start">
                            <a href="{{ url('/piutang-pelanggan') }}/${d.id_pelanggan}" class="btn btn-info">
                                <li class="fa fa-info"></li>
                            </a>
                            
                        </span>
                    </div>
                </div>
                `;
        }

        let table;

        $(document).ready(function() {
            table = $('#table-piutang').DataTable({
                "ajax": {
                    "url": "{{ url('/data-piutang') }}",
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
                        "data": "nama",
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
                    "className": "d-none d-md-table-cell d-lg-table-cell",
                }, ]
            });

            table.on('click', 'td.dt-control', function() {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format_tbl_piutang(row.data())).show();
                    tr.addClass('shown');
                }
            });

        });
    </script>
@endsection
