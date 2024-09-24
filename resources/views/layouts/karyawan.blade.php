<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan Dashboard</title>
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/png">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <style>
        /* Custom Modal Styles */
        .custom-modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .custom-modal-content {
            background: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 600px;
        }

        .close-btn {
            float: right;
            font-size: 1.5em;
            cursor: pointer;
        }

        #camera,
        #edit_camera {
            width: 320px;
            height: 240px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #000;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .custom-modal-content {
                width: 90%;
            }

            .text-white {
                font-size: 20px;
            }

            .text-dark {
                font-size: 20px;
            }

            .canvas {
                width: 150px;
            }

            .main-footer {
                margin-top: 70px;
            }
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        /* Custom Styles */
        body {
            background-color: #f5f5f5;
            color: #333;
        }

        .main-header {
            background-color: #e53935;
            /* Red */
            color: #fff;
        }

        .main-header .navbar-nav .nav-link {
            color: #fff;
        }

        .main-sidebar {
            background-color: #000;
            /* Black */
        }

        .brand-link {
            background-color: #e53935;
            /* Red */
        }

        .nav-link {
            color: #fff;
        }

        .nav-link:hover {
            color: #ddd;
        }

        .main-footer {
            background-color: #000;
            /* Black */
            color: #fff;
        }

        .main-footer a {
            color: #e53935;
            /* Red */
        }

        .alert-success {
            background-color: #e53935;
            /* Red */
            color: #fff;
        }

        .alert-danger {
            background-color: #f44336;
            /* Slightly different red */
            color: #fff;
        }

        .btn-primary {
            background-color: #e53935;
            /* Red */
            border-color: #e53935;
        }

        .btn-primary:hover {
            background-color: #c62828;
            /* Darker red */
            border-color: #c62828;
        }

        .btn-warning {
            background-color: #f57f17;
            /* Orange */
            border-color: #f57f17;
        }

        .btn-danger {
            background-color: #d32f2f;
            /* Dark red */
            border-color: #d32f2f;
        }

        .custom-modal-content {
            border-color: #e53935;
            /* Red border */
        }

        .custom-modal-content h2 {
            color: #e53935;
            /* Red */
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Logout -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('img/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
                    style="opacity: .8" width="100">
                <span class="brand-text font-weight-light">BAST</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset(Auth::user()->foto) }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->nama }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('karyawan.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('karyawan.absensi.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p>
                                    Absensi
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('karyawan.laporan_hasil.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Laporan Hasil
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>


                        <!-- Add more menu items as needed -->
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->


                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Your content here -->
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="#">Your Company</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table-ok').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });

            $('#table-ya').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
            $('#table-nya').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
