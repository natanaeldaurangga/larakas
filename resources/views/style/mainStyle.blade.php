<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ url('/') }}/plugins/fontawesome-free/css/all.min.css">

<!-- DataTables -->
<link rel="stylesheet" href="{{ url('/') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ url('/') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ url('/') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="{{ url('/') }}/dist/css/adminlte.min.css">

<link rel="stylesheet" type="text/css"
    href="{{ url('/') }}/plugins/datetimepicker-master/build/jquery.datetimepicker.min.css" />

<!-- jQuery -->
<script src="{{ url('/') }}/plugins/jquery/jquery.min.js"></script>

<script>
    const rupiah = new Intl.NumberFormat('id-ID', {
        style: "currency",
        currency: "IDR",
    });
</script>

{{-- Meminta laravel untuk memberikan csrf_token --}}
