<div class="modal fade" id="form-edit-karyawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-edit-karyawan" action="/karyawan" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="name-edit" class="col-lg-3 col-md-2">Name</label>
                        <input type="text" class="form-control col-lg-9 col-md-10" name="name" id="name-edit"
                            value="">
                        <div class="invalid-feedback error-name">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username-edit" class="col-lg-3 col-md-2">Username</label>
                        <input type="numeric" class="form-control col-lg-9 col-md-10" name="username" id="username-edit"
                            value="">
                        <div class="invalid-feedback error-username">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_telp-edit" class="col-lg-3 col-md-2">No Telp</label>
                        <input type="numeric" class="form-control col-lg-9 col-md-10" name="no_telp" id="no_telp-edit"
                            value="">
                        <div class="invalid-feedback error-no_telp">

                        </div>
                    </div>

                    {{-- TODO: Lanjut untuk create karyawan baru pake ajax request --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="ajx-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setDatakaryawan(username) {
        $.ajax({
            type: "GET",
            url: "{{ url('/karyawan') }}/" + username,
            dataType: "json",
            beforeSend: function() {

            },
            success: function(response) {
                $('#name-edit').val(response.data.name);
                $('#username-edit').val(response.data.username);
                $('#no_telp-edit').val(response.data.no_telp);
                $('#name-edit').removeClass('is-invalid');
                $('.error-name').html('');
                $('#username-edit').removeClass('is-invalid');
                $('.error-username').html('');
                $('#no_telp-edit').removeClass('is-invalid');
                $('.error-no_telp').html('');
            },
            complete: function() {

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError);
            }
        });
    }

    function edit(username) {
        formToggle = `/karyawan/${username}`;
        method = "put";
        setDatakaryawan(username);
    }

    $(document).ready(function() {
        $('.form-edit-karyawan').submit(function(e) {
            e.preventDefault();
            console.log(formToggle);
            let thisBtn = $("#ajx-simpan");
            $.ajax({
                type: method,
                url: "{{ url('/') }}" + formToggle,
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    thisBtn.attr('disable', 'disabled');
                    thisBtn.html('<i class="fa fa-spin fa-spinner"></i>');
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Data tersimpan',
                        text: response.sukses,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#name-edit').val('');
                    $('#username-edit').val('');
                    $('#no_telp-edit').val('');
                    $('#name-edit').removeClass('is-invalid');
                    $('.error-name').html('');
                    $('#username-edit').removeClass('is-invalid');
                    $('.error-username').html('');
                    $('#no_telp-edit').removeClass('is-invalid');
                    $('#form-edit-karyawan').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    if (response.errors) {
                        if (response.errors.name) {
                            $('#name-edit').addClass('is-invalid');
                            $('.error-name').html(response.errors.name);
                        } else {
                            $('#name-edit').removeClass('is-invalid');
                            $('.error-name').html('');
                        }

                        if (response.errors.username) {
                            $('#username-edit').addClass('is-invalid');
                            $('.error-username').html(response.errors.username);
                        } else {
                            $('#username-edit').removeClass('is-invalid');
                            $('.error-username').html('');
                        }

                        if (response.errors.no_telp) {
                            $('#no_telp-edit').addClass('is-invalid');
                            $('.error-no_telp').html(response.errors.no_telp);
                        } else {
                            $('#no_telp-edit').removeClass('is-invalid');
                            $('.error-no_telp').html('');
                        }
                    }

                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                }
            });
        });

        $('#form-edit-karyawan').on('hidden.bs.modal', function() {
            $('#form-edit-karyawan .form-control').val('');
        });

    });
</script>
