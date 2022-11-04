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
                <h1>Daftar karyawan</h1>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#form-karyawan">Tambah
                    karyawan</a>
            </div>
            {{-- TODO: Lanjut ke karyawan --}}
            <div class="card-body">
                <table style="width: 100%" id="table-karyawan" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Username</th>
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
        // TODO: tambah fitur untuk ganti password karyawan
        function format_tbl_karyawan(d) {
            return `
                <div>
                    <div class="row">
                        <label for="" class="col-lg-3">Nama</label>
                        <span class="col-lg-9">${d.name}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Username</label>
                        <span class="col-lg-9">${d.username}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">No. Telp</label>
                        <span class="col-lg-9">${d.no_telp}</span>
                    </div>
                    <div class="row">
                        <label for="" class="col-lg-3">Aksi</label>
                        <span class="col-lg-9 d-flex justify-content-start">
                            <button type="button" class="btn btn-warning" onclick="edit('${d.username}')" data-username="${d.username}" data-toggle="modal" data-target="#form-edit-karyawan">
                                <li class="fa fa-edit"></li>
                            </button>
                            <button type="button" class="btn btn-danger btn-delete ml-2"  data-toggle="modal" data-target="#form-password-karyawan" onclick="changePassword('${d.username}')">
                                <li class="fa fa-unlock"></li>
                            </button>
                            <button type="button" class="btn btn-danger btn-delete ml-2" onclick="hapus('${d.username}')">
                                <li class="fa fa-trash"></li>
                            </button>
                        </span>
                    </div>
                </div>
                `;
        }

        let table;

        $(document).ready(function() {
            table = $('#table-karyawan').DataTable({
                "ajax": {
                    "url": "{{ url('/data-karyawan') }}",
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
                        "data": "name",
                    },
                    {
                        "data": "username",
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
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format_tbl_karyawan(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });

        function hapus(username) {
            let thisBtn = $(`button[data-username=${username}]`);
            Swal.fire({
                title: 'Anda yakin?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                denyButtonText: `Batal`,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Data berhasil dihapus!', '', 'success');
                    $.ajax({
                        type: "DELETE",
                        url: `{{ url('/karyawan/') }}/${username}`,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType: "json",
                        beforeSend: function() {
                            thisBtn.attr('disable', 'disabled');
                            thisBtn.html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        success: function(response) {
                            // console.log(response);
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
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>

    @include('modalForm.formKaryawan')
    @include('modalForm.formEditKaryawan')
    @include('modalForm.formChangePasswordKaryawan')
@endsection
