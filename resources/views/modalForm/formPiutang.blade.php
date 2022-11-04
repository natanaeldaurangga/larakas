<div class="modal fade" id="form-piutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pencatatan Piutang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/piutang" class="form-create-piutang" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="created_at">Tanggal</label>
                            <input type="text" id="created_at" name="created_at"
                                class="datetimepicker form-control d-inline @error('created_at') is-invalid @enderror"
                                value="{{ old('created_at', date('Y-m-d H:i')) }}">
                            <div class="error-created_at invalid-feedback">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                            <div class="error-keterangan invalid-feedback">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="saldo">Saldo</label>
                            {{-- FIXME: Kenapa si saldo ini nggak di unmask --}}
                            <input type="hidden" id="saldo_hidden" name="saldo" value="{{ old('saldo') }}">
                            <input type="text" class="form-control input-mask-uang" id="saldo"
                                placeholder="Saldo" value="{{ old('saldo') }}">
                            <div class="error-saldo invalid-feedback">

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Pelanggan</label>
                            <div class="error-id_pelanggan text-danger">

                            </div>
                            @include('modalOpsi.pelanggan')
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#saldo').on('input', function() {
            $("input[name='saldo']").val($(this).inputmask('unmaskedvalue'));
        });

        $('.form-create-piutang').submit(function(e) {
            e.preventDefault();
            let thisBtn = $("#ajx-simpan");
            $.ajax({
                type: "post",
                url: "{{ url('/piutang') }}",
                data: $(this).serialize(),
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
                        title: 'Data tersimpan',
                        text: response.success,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    // TODO: Lanjut untuk insert data piutang ke aplikasi
                    $('#form-piutang .form-control').val('');
                    $('#form-piutang').modal('hide');
                },
                complete: function() {
                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                    table.ajax.reload();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    let response = (JSON.parse(xhr.responseText));
                    console.log(response);
                    if (response.errors) {
                        if (response.errors.created_at) {
                            $('#created_at').addClass('is-invalid');
                            $('.error-created_at').html(response.errors.created_at);
                        } else {
                            $('#created_at').removeClass('is-invalid');
                            $('.error-created_at').html('');
                        }

                        if (response.errors.keterangan) {
                            $('#keterangan').addClass('is-invalid');
                            $('.error-keterangan').html(response.errors.keterangan);
                        } else {
                            $('#keterangan').removeClass('is-invalid');
                            $('.error-keterangan').html('');
                        }

                        if (response.errors.saldo) {
                            $('#saldo').addClass('is-invalid');
                            $('.error-saldo').html(response.errors.saldo);
                        } else {
                            $('#saldo').removeClass('is-invalid');
                            $('.error-saldo').html('');
                        }

                        if (response.errors.id_pelanggan) {
                            $('#id_pelanggan').addClass('is-invalid');
                            $('.error-id_pelanggan').html(response.errors.id_pelanggan);
                        } else {
                            $('#id_pelanggan').removeClass('is-invalid');
                            $('.error-id_pelanggan').html('');
                        }
                    }

                    thisBtn.removeAttr('disable');
                    thisBtn.html('Simpan');
                }
            });
        });

    });
</script>
