<table style="width: 100%" id="table-pemasok" class="table table-hover table-striped datatable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemasok as $item)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <th>{{ $item->nama }}</th>
                <th>
                    <input type="radio" name="id_pemasok" class="rd-pilih" value="{{ $item->id_pemasok }}">
                </th>
            </tr>
        @endforeach
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('.rd-pilih').click(function() {
            $('.id_pemasok').val($(this).data('id'));
            $('.nama_pemasok').val($(this).data('nama'));
        });
    });
</script>
