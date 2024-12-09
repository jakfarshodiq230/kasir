<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/mata.png')}}">
    <title>{{strtoupper(session('toko_nama')).' '.strtoupper(session('cabang_nama'))}} </title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="{{ asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ asset('vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        }
        ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
        border: 2px solid #f1f1f1;
        }
        ::-webkit-scrollbar-thumb:hover {
        background: #555;
        }
    </style>
    {{-- select2 --}}
    @yield('styles')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="#" class="site_title"><i class="fas fa-cash-register"></i> <span>POS(OPTIK)</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="{{ asset('images/user.png') }}" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{ Auth::user()->name }}</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        @if(auth()->user() && auth()->user()->level_user === 'owner')
                            <div class="menu_section">
                                <h3>Owner</h3>
                                <ul class="nav side-menu">
                                    <li><a href="{{ route('owner-dashboard.index')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                                    <li><a><i class="fa fa-database"></i> Master <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('kategori.index') }}">Kategori</a></li>
                                            <li><a href="{{ route('jenis.index') }}">Jenis</a></li>
                                            <li><a href="{{ route('type.index') }}">Type</a></li>
                                            <li><a href="{{ route('lensa.index') }}">Lensa</a></li>
                                            <li><a href="{{ route('gudang.index') }}">Gudang</a></li>
                                            <li><a href="{{ route('suplaier.index') }}">Suplaier</a></li>
                                            <li><a href="{{ route('cabang.index') }}">Toko Cabang</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('karyawan.index')}}"><i class="fa fa-users"></i> Karyawan</a></li>
                                    <li><a><i class="fa fa-bookmark"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('owner-laporan.penjualan')}}">Penjualan</a></li>
                                            <li><a href="{{ route('owner-laporan.pemesanan')}}">Pemesanan</a></li>
                                            <li><a href="{{ route('owner-laporan.utang')}}">Utang</a></li>
                                            <li><a href="{{ route('owner-laporan.stock')}}">Stock</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('owner-kas.index')}}"><i class="fa fa-usd"></i>Kas</a></li>
                                    <li><a href="{{ route('owner-toko.index')}}"><i class="fa fa-home"></i>Toko</a></li>
                                    <li><a href="{{ route('owner-divace-login.index')}}"><i class="fa fa-laptop"></i>Divace Login</a></li>
                                </ul>
                            </div>
                        @endif
                        @if(auth()->user() && auth()->user()->level_user === 'gudang')
                            <div class="menu_section">
                                <h3>Gudang</h3>
                                <ul class="nav side-menu">
                                    <li><a href="{{ route('gudang-dashboard.index')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                                    <li><a><i class="fa fa-shopping-bag"></i> Barang <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('gudang-barang.index') }}">Barang</a></li>
                                            <li><a href="{{ route('gudang-barang.add') }}">Tambah Barang</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-shopping-basket"></i> Stock <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('gudang-stock.index') }}">Barang</a></li>
                                            <li><a href="{{ route('gudang-stock.add') }}">Stock</a></li>
                                            <li><a href="{{ route('gudang-stock.log') }}">Riwayat</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('gudang-permintaan.index')}}"><i class="fa fa-truck"></i> Permintaan Barang</a></li>
                                    <li><a href="{{ route('gudang-selesai.index')}}"><i class="fa fa-check"></i> Permintaan Selesai</a></li>
                                </ul>
                            </div>
                        @endif

                        @if(auth()->user() && auth()->user()->level_user === 'admin')
                            <div class="menu_section">
                                <h3>Admin</h3>
                                <ul class="nav side-menu">
                                    <li><a href="{{ route('admin-dashboard.index')}}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                                    <li><a><i class="fa fa-shopping-basket"></i> Stock <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('admin-stock.index') }}">Barang</a></li>
                                            <li><a href="{{ route('admin-stock.add') }}">Stock</a></li>
                                            <li><a href="{{ route('admin-stock.log') }}">Riwayat</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-paypal"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('admin-penjualan.index') }}">Penjualan</a></li>
                                            <li><a href="{{ route('admin-pemesanan.index') }}">Pemesanan</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('admin-kas.index')}}"><i class="fa fa-credit-card-alt"></i> Kas</a></li>
                                    <li><a><i class="fa fa-bookmark"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="{{ route('admin-laporan.penjualan')}}">Penjualan</a></li>
                                            <li><a href="{{ route('admin-laporan.pemesanan')}}">Pemesanan</a></li>
                                            <li><a href="{{ route('admin-laporan.utang')}}">Utang</a></li>
                                            <li><a href="{{ route('admin-laporan.stock')}}">Stock</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small text-center">
                        <span class="version-info font-italic"><b>Version 0.0.10</b></span>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/user.png') }}" alt="...">{{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#emailModal">
                                        <i class="fa fa-key pull-right"></i>Password
                                    </a>
                                    <a class="dropdown-item" href="{{route('logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true" data-bs-backdrop="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="emailForm" method="POST" action="#">
                                                @csrf
                                                <!-- Header Modal -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="emailModalLabel">Masukkan Email</h5>
                                                </div>
                                                <!-- Body Modal -->
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                                        @if ($errors->has('email'))
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div id="statusMessage"></div>
                                                </div>
                                                <!-- Footer Modal -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            @yield('konten')
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    @if (strtoupper(Auth::user()->level_user) === 'OWNER')
                    {{ strtoupper(Auth::user()->toko->nama_toko) }}
                @else
                    {{ strtoupper(Auth::user()->toko->nama_toko) }}
                    ( {{ strtoupper(Auth::user()->level_user) . ' ' . strtoupper(Auth::user()->cabang->nama_toko_cabang) }} )
                @endif
                    @
                @php
                     echo date('Y');
                @endphp
                </div>
                <div class="clearfix"></div>
            </footer>

            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- gauge.js -->
    <script src="{{ asset('vendors/gauge.js/dist/gauge.min.js') }}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{ asset('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Skycons -->
    <script src="{{ asset('vendors/skycons/skycons.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
    <script src="{{ asset('vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    {{-- modal --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- swal alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    	<!-- jQuery autocomplete -->
	<script src="{{ asset('vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>

    @yield('scripts')
    <script>
        $(document).ready(function() {
            $('#emailForm').submit(function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                var form = $(this);
                var formData = form.serialize(); // Serialize the form data

                $.ajax({
                    url: '/forgot-password',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                    console.log(response);

                        $('#statusMessage').html('<div class="alert alert-success mt-3">' + response.message + '</div>');
                        form[0].reset(); // Optionally reset the form
                    },
                    error: function(xhr) {
                        // Handle error
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += '<div class="alert alert-danger mt-2">' + value[0] + '</div>';
                        });
                        $('#statusMessage').html(errorMessages);
                    }
                });
            });
        });
    </script>
</body>

</html>
