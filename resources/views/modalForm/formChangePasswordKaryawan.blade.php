<div class="modal fade" id="form-password-karyawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form class="form-password-karyawan" action="/karyawan" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="name-edit" class="col-lg-3 col-md-2">Password Baru</label>
                        <input type="text" class="form-control col-lg-9 col-md-10" name="password" id="new-password"
                            value="">
                        <div class="invalid-feedback error-new-password">

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
    let username;

    function changePassword(arg_username) {
        username = arg_username;
    }

    $(document).ready(function() {
        $('.form-password-karyawan').submit(function(e) {
            e.preventDefault();
            console.log(formToggle);
            let thisBtn = $("#ajx-simpan");
            $.ajax({
                type: "put",
                url: "{{ url('/change-password-karyawan/') }}/" + username,
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
                    $('#new-password').val('');
                    $('#new-password').removeClass('is-invalid');
                    $('.error-new-password').html('');
                    $('#form-password-karyawan').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    if (response.errors) {
                        if (response.errors.password) {
                            $('#new-password').addClass('is-invalid');
                            $('.error-new-password').html(response.errors.password);
                        } else {
                            $('#new-password').removeClass('is-invalid');
                            $('.error-new-password').html('');
                        }
                    }
                    // TODO: Lanjut untuk ngehapus karyawawn
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                }
            });
        });

        $('#form-password-karyawan').on('hidden.bs.modal', function() {
            $('#form-password-karyawan .form-control').val('');
        });

    });
</script>
