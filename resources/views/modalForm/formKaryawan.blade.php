<div class="modal fade" id="form-karyawan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <form class="form-create-karyawan" action="/karyawan" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-lg-3 col-md-2">Name</label>
                        <input type="text" class="form-control col-lg-9 col-md-10" name="name" id="name"
                            value="">
                        <div class="invalid-feedback error-name">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-lg-3 col-md-2">Username</label>
                        <input type="numeric" class="form-control col-lg-9 col-md-10" name="username" id="username"
                            value="">
                        <div class="invalid-feedback error-username">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_telp" class="col-lg-3 col-md-2">No Telp</label>
                        <input type="numeric" class="form-control col-lg-9 col-md-10" name="no_telp" id="no_telp"
                            value="">
                        <div class="invalid-feedback error-no_telp">

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_telp" class="col-lg-3 col-md-2">Password</label>
                        <input type="text" class="form-control col-lg-9 col-md-10" name="password" id="password"
                            value="">
                        <div class="invalid-feedback error-password">

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

    let formToggle = "/karyawan"; // defaultnya ke create
    let method = "post";

    function create() {
        formToggle = `/karyawan`;
        method = "post";
    }

    $(document).ready(function() {
        $('.form-create-karyawan').submit(function(e) {
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
                    $('#name').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#no_telp').val('');
                    $('#name').removeClass('is-invalid');
                    $('.error-name').html('');
                    $('#username').removeClass('is-invalid');
                    $('.error-username').html('');
                    $('#password').removeClass('is-invalid');
                    $('.error-password').html('');
                    $('#no_telp').removeClass('is-invalid');
                    $('#form-karyawan').modal('hide');
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
                            $('#name').addClass('is-invalid');
                            $('.error-name').html(response.errors.name);
                        } else {
                            $('#name').removeClass('is-invalid');
                            $('.error-name').html('');
                        }

                        if (response.errors.username) {
                            $('#username').addClass('is-invalid');
                            $('.error-username').html(response.errors.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.error-username').html('');
                        }

                        if (response.errors.no_telp) {
                            $('#no_telp').addClass('is-invalid');
                            $('.error-no_telp').html(response.errors.no_telp);
                        } else {
                            $('#no_telp').removeClass('is-invalid');
                            $('.error-no_telp').html('');
                        }

                        if (response.errors.password) {
                            $('#password').addClass('is-invalid');
                            $('.error-password').html(response.errors.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.error-password').html('');
                        }
                    }

                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                }
            });
        });

        $('#form-karyawan').on('hidden.bs.modal', function() {
            $('#form-karyawan .form-control').val('');
        });

    });
</script>
