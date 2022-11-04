<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ url('/') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><strong>Lara</strong>KAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('/') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Kas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/') }}/kas" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Arus Kas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}/kas/create" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Catat Kas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/pelanggan" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pelanggan
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/pemasok" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pemasok
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/piutang" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Piutang
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/utang" class="nav-link">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Utang
                        </p>
                    </a>
                </li>

                @can('admin')
                    <li class="nav-item">
                        <a href="/karyawan" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Karyawan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/pencatatan" class="nav-link">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>
                                Riwayat Pencatatan
                            </p>
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <form action="{{ url('/logout') }}" class="form-logout nav-link" method="post">
                        @csrf
                        <a id="logout" class="d-block" style="cursor: pointer">
                            <i class="nav-icon fas fa-arrow-left"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<script>
    $(document).ready(function() {
        $('#logout').click(function() {
            $('.form-logout').submit();
        });
    });
</script>
