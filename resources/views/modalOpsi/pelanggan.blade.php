<table style="width: 100%" id="table-pelanggan" class="table table-hover table-striped datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pelanggan as $item)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <th>{{ $item->nama }}</th>
                <th>
                    <input type="radio" name="id_pelanggan" class="rd-pilih" value="{{ $item->id_pelanggan }}">
                </th>
            </tr>
        @endforeach
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('.rd-pilih').click(function() {
            $('.id_pelanggan').val($(this).data('id'));
            $('.nama_pelanggan').val($(this).data('nama'));
        });
    });
</script>
