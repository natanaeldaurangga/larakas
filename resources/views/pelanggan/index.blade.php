@extends('layouts.dashboard.index')

@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" onclick="create()" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h1>Daftar Pelanggan</h1>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#form-pelanggan">Tambah
                    Pelanggan</a>
            </div>
            {{-- TODO: Lanjut ke pelanggan --}}
            <div class="card-body">
                <table style="width: 100%" id="table-pelanggan" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No Telp</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script>
        function format_tbl_pelanggan(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">No Telp</label>
                        <span class="col-lg-9">${d.no_telp}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Alamat</label>
                        <span class="col-lg-9">${d.alamat}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <span class="col-lg-9 d-flex justify-content-start">
                            <button type="button" class="btn btn-warning" onclick="edit(${d.id_pelanggan})" data-id="${d.id_pelanggan}" data-toggle="modal" data-target="#form-pelanggan">
                                <li class="fa fa-edit"></li>
                            </button>
                            <button type="button" class="btn btn-danger btn-delete ml-2" onclick="hapus(${d.id_pelanggan})">
                                <li class="fa fa-trash"></li>
                            </button>
                        </span>
                    </div>
                </div>
                `;
        }

        let table;

        $(document).ready(function() {

            table = $('#table-pelanggan').DataTable({
                "ajax": {
                    "url": "{{ url('/data-pelanggan') }}",
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
                        "data": "alamat"
                    },
                    {
                        "data": "no_telp"
                    }
                ],
                "columnDefs": [{
                    "targets": [2, 3],
                    "className": "d-none d-md-table-cell d-lg-table-cell"
                }, ],
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
                    row.child(format_tbl_pelanggan(row.data())).show();
                    tr.addClass('shown');
                }
            });


            // TODO: Lanjut untuk delete




        });

        function hapus(id) {
            let thisBtn = $(`button[data-id=${id}]`);
            Swal.fire({
                title: 'Do you want to save the changes?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                denyButtonText: `Batal`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire('Data berhasil dihapus!', '', 'success');
                    // let thisBtn = $(this);
                    // console.log(`{{ url('/pelanggan/') }}/${id}`);
                    $.ajax({
                        type: "DELETE",
                        url: `{{ url('/pelanggan/') }}/${id}`,
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
                        },
                        complete: function() {
                            thisBtn.removeAttr('disable');
                            thisBtn.html('<li class="fa fa-trash"></li>');
                            table.ajax.reload();
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            let response = (JSON.parse(xhr.responseText));
                            if (response.errors) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan',
                                })
                            }

                        }
                    });
                }
            })
        }
    </script>

    @include('modalForm.formPelanggan')
@endsection
