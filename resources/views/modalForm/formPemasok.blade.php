<div class="modal fade" id="form-pemasok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pemasok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-create-pemasok" action="/pemasok" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group row">
                        <label for="nama" class="col-lg-3 col-md-2">Nama</label>
                        <input type="text" class="form-control col-lg-9 col-md-10" name="nama" id="nama"
                            value="">
                        <div class="invalid-feedback error-nama">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_telp" class="col-lg-3 col-md-2">Nomor Telepon</label>
                        <input type="numeric" class="form-control col-lg-9 col-md-10" name="no_telp" id="no_telp"
                            value="">
                        <div class="invalid-feedback error-no_telp">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-lg-3 col-md-2">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control col-lg-9 col-md-10" cols="20" rows="5"></textarea>
                        <div class="invalid-feedback error-alamat">

                        </div>
                    </div>
                    {{-- TODO: Lanjut untuk create pemasok baru pake ajax request --}}
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
    function setDatapemasok(idpemasok) {
        $.ajax({
            type: "GET",
            url: `{{ url('/pemasok/${idpemasok}') }}`,
            dataType: "json",
            beforeSend: function() {

            },
            success: function(response) {
                $('#nama').val(response.data.nama);
                $('#no_telp').val(response.data.no_telp);
                $('#alamat').val(response.data.alamat);
                $('#nama').removeClass('is-invalid');
                $('.error-nama').html('');
                $('#no_telp').removeClass('is-invalid');
                $('.error-no_telp').html('');
                $('#form-pemasok').modal('hide');
            },
            complete: function() {

            },
            error: function(xhr, ajaxOptions, thrownError) {
                let response = (JSON.parse(xhr.responseText));
                if (response.errors) {
                    if (response.errors.nama) {
                        $('#nama').addClass('is-invalid');
                        $('.error-nama').html(response.errors.nama);
                    } else {
                        $('#nama').removeClass('is-invalid');
                        $('.error-nama').html('');
                    }

                    if (response.errors.no_telp) {
                        $('#no_telp').addClass('is-invalid');
                        $('.error-no_telp').html(response.errors.no_telp);
                    } else {
                        $('#no_telp').removeClass('is-invalid');
                        $('.error-no_telp').html('');
                    }
                }
            }
        });
    }

    let formToggle = "/pemasok"; // defaultnya ke create
    let method = "post";

    function edit(idpemasok) {
        formToggle = `/pemasok/${idpemasok}`;
        method = "put";
        setDatapemasok(idpemasok);
    }

    $(document).ready(function() {
        $('.btn-create').click(function() {
            formToggle = `/pemasok`;
            method = "post";
        });

        $('.form-create-pemasok').submit(function(e) {
            e.preventDefault();
            let thisBtn = $("#ajx-simpan");
            // createpemasok(thisBtn);
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
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Data tersimpan',
                        text: response.sukses,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#nama').val('');
                    $('#no_telp').val('');
                    $('#alamat').val('');
                    $('#nama').removeClass('is-invalid');
                    $('.error-nama').html('');
                    $('#no_telp').removeClass('is-invalid');
                    $('.error-no_telp').html('');
                    $('#form-pemasok').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    if (response.errors) {
                        if (response.errors.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.error-nama').html(response.errors.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.error-nama').html('');
                        }

                        if (response.errors.no_telp) {
                            $('#no_telp').addClass('is-invalid');
                            $('.error-no_telp').html(response.errors.no_telp);
                        } else {
                            $('#no_telp').removeClass('is-invalid');
                            $('.error-no_telp').html('');
                        }
                    }

                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                }
            });
        });

        $('#form-pemasok').on('hidden.bs.modal', function() {
            $('#form-pemasok .form-control').val('');
        });

    });
</script>
