@extends('layouts.dashboard.index')


@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah kas</h3>

            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="/kas" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="created_at">Tanggal</label>
                        <input type="text" name="created_at"
                            class="datetimepicker form-control d-inline @error('created_at') is-invalid @enderror"
                            value="{{ old('created_at', date('Y-m-d H:i')) }}">
                        @error('created_at')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan"
                            cols="30" rows="10">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- radio -->
                    <div class="form-group">
                        <label for="">Arus</label>
                        <div class="form-check">
                            <input class="form-check-input" value="1" id="pos-masuk" type="radio" name="pos"
                                {{ old('pos') == 1 ? 'checked' : '' }}>
                            <label for="pos-masuk" class="form-check-label">Masuk</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" id="pos-keluar" value="0" type="radio" name="pos"
                                {{ old('pos') == 0 ? 'checked' : '' }}>
                            <label for="pos-keluar" class="form-check-label">Keluar</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="saldo">Saldo</label>
                        <input type="hidden" id="saldo_hidden" name="saldo" value="{{ old('saldo') }}">
                        <input type="text" class="form-control @error('saldo') is-invalid @enderror input-mask-uang"
                            id="saldo" placeholder="Saldo" value="{{ old('saldo') }}">
                        @error('saldo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </form>
        </div>

    </div>

    <script>
        $(document).ready(function() {

            $("input[name='saldo']").val($('#saldo').inputmask('unmaskedvalue'));

            $('#saldo').on('input', function() {
                $("input[name='saldo']").val($(this).inputmask('unmaskedvalue'));
            });

        });
    </script>
@endsection
