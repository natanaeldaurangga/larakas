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
                <h1>Daftar utang</h1>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#form-utang">Tambah
                    utang</button>
            </div>
            {{-- TODO: Lanjut ke utang --}}
            <div class="card-body">
                <table style="width: 100%" id="table-utang" class="table table-hover table-striped">
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

    @include('modalForm.formutang')

    <script>
        function format_tbl_utang(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">ID pemasok</label>
                        <span class="col-lg-9">${d.id_pemasok}</span>
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
                            <a href="{{ url('/utang-pemasok') }}/${d.id_pemasok}" class="btn btn-info">
                                <li class="fa fa-info"></li>
                            </a>
                            
                        </span>
                    </div>
                </div>
                `;
        }

        let table;

        $(document).ready(function() {
            table = $('#table-utang').DataTable({
                "ajax": {
                    "url": "{{ url('/data-utang') }}",
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
                    row.child(format_tbl_utang(row.data())).show();
                    tr.addClass('shown');
                }
            });

        });
    </script>
@endsection
