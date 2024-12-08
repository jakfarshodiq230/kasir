@extends('template.kasir')
@section('styles')
    <style>
        .dataTables_wrapper .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dataTables_length {
            margin-right: 20px;
            margin-top: 20px;
            margin-bottom: -50px;
        }
        .dataTables_wrapper .dt-buttons {
            margin-top: 10px;
        }
        .dataTables_filter {
            margin-left: 20px;
        }
        .panel_toolbox {
            float: right;
            min-width: 0px;
        }
    </style>
        <!-- Datatables -->
        <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('konten')
<div class="right_col" role="main">
    {{-- isi conten --}}
    <div class="col-md- col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>LIST TRANSAKSI</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="text-center">DAFTAR TRANSAKSI PESANAN</h4>
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons1" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Ketrangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12 mt-2">
                        <h4 class="text-center">DAFTAR TRANSAKSI HUTANG</h4>
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Ketrangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12 mt-4">
                        <h4 class="text-center">DAFTAR TRANSAKSI CASH DAN TRANSFER</h4>
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons3" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Harga</th>
                                        <th>Rincian</th>
                                        <th>Ketrangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal detail transaksi -->
        <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="addDataForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDataModalLabel">Tambah Data Cabang</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 p-0">
                                        <label class="col-form-label col-md-1 col-sm-1 ">R</label>
                                        <input type="number" step="1" name="r_sph" id="r_sph"  class="form-control form-control-sm col-md-2 mr-2" placeholder="SPH" readonly>
                                        <input type="number" step="1" name="r_cyl" id="r_cyl"  class="form-control form-control-sm col-md-2 mr-2" placeholder="CYL" readonly>
                                        <input type="number" step="1" name="r_axs" id="r_axs"  class="form-control form-control-sm col-md-2 mr-2" placeholder="AXS" readonly>
                                        <input type="number" step="1" name="r_add" id="r_add"  class="form-control form-control-sm col-md-2 mr-2" placeholder="ADD" readonly>
                                        <input type="number" step="1" name="pd" id="pd" class="form-control form-control-sm col-md-2 mr-2" placeholder="PD" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 p-0">
                                        <label class="col-form-label col-md-1 col-sm-1 ">L</label>
                                        <input type="number" step="1" name="l_sph" id="l_sph"  class="form-control form-control-sm col-md-2 mr-2" placeholder="SPH" readonly>
                                        <input type="number" step="1" name="l_cyl" id="l_cyl"  class="form-control form-control-sm col-md-2 mr-2" placeholder="CYL" readonly>
                                        <input type="number" step="1" name="l_axs" id="l_axs"  class="form-control form-control-sm col-md-2 mr-2" placeholder="AXS" readonly>
                                        <input type="number" step="1" name="l_add" id="l_add"  class="form-control form-control-sm col-md-2 mr-2" placeholder="ADD" readonly>
                                        <input type="number" step="1" name="pd2" id="pd2" class="form-control form-control-sm col-md-2 mr-2" placeholder="PD" readonly>
                                    </div>
                                </div>
                                <div class="table mt-4">
                                  <table id="detail-penjualan" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>No.</th>
                                        <th>Rincian</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.col -->
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-sm print-btn" id="print-btn">PRINT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- bayar hutang --}}
        <div class="modal fade" id="bayarDataModal" tabindex="-1" aria-labelledby="bayarDataModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="addDataForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bayarDataModalLabel">Baayar Hutang</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 ">
                                    <div class="form-group row">
                                        <input type="hidden" name="id" id="barang_id" value="">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Nomor Transaksi</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control form-control-sm" id="nomor_transaksi" name="nomor_transaksi" placeholder="Nomor Transaksi" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Nama</label>
                                        <div class="col-md-0 col-sm-9 ">
                                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Nama" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Alamat<span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <textarea type="text" name="alamat" id="alamat" class="form-control form-control-sm" placeholder="Alamat" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Petugas</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control form-control-sm" value="<?=  Auth::user()->name ?>" placeholder="Nama Petugas" readonly>
                                            <input type="hidden" name="id_user" id="id_user" value="<?=  Auth::user()->id ?>" class="form-control form-control-sm" placeholder="Nama Petugas">
                                            <input type="hidden" name="id_penjualan" id="id_penjualan"  class="form-control form-control-sm" placeholder="Nama Petugas">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Phone TLF/WA</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="phone_transaksi" id="phone_transaksi" class="form-control form-control-sm form-control form-control-sm-sm" placeholder="Phone TLF/WA" readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 col-sm-6  bg-white">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Diamater</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="diameter" id="diameter" class="form-control form-control-sm" placeholder="Diamater" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Warna</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="warna" id="warna" class="form-control form-control-sm" placeholder="warna" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Total Hutang</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="total_beli" id="total_beli" class="form-control form-control-sm" placeholder="Total Hutang" readonly>
                                            <input type="hidden" name="total_beli2" id="total_beli2" class="form-control form-control-sm" placeholder="Total Hutang" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Total DP</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="jumlah_bayar_dp" id="jumlah_bayar_dp" class="form-control form-control-sm" placeholder="Total DP" readonly>
                                            <input type="hidden" name="jumlah_bayar_dp2" id="jumlah_bayar_dp2" class="form-control form-control-sm" placeholder="Total DP" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Sisa Hutang</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="jumlah_sisa_dp" id="jumlah_sisa_dp" class="form-control form-control-sm" placeholder="Sisa Hutang" readonly>
                                            <input type="hidden" name="jumlah_sisa_dp2" id="jumlah_sisa_dp2" class="form-control form-control-sm" placeholder="Sisa Hutang" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-3 col-sm-3 ">Jumlah Bayar</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" name="jumlah_pelunasan" id="jumlah_pelunasan" value="0" class="form-control form-control-sm" placeholder="jumlah Bayar">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <span class="text-danger font-weight-bold" style="font-style: italic;">*Pelunasana hanya bisa di lakukan hanya satu kali pembayaran,<br> sistem membaca hanya satu kali pelunasan.</span>
                            <div>
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary btn-sm proses-btn" id="proses-btn">Proses Transaksi Utang</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
    <script>
        function formatRupiah(amount) {
            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });
            return formatter.format(amount);
        }

        $(document).ready(function() {
            $('#addDataModal').on('hidden.bs.modal', function() {
                $('#r_sph').val('');
                $('#r_cyl').val('');
                $('#r_axs').val('');
                $('#r_add').val('');
                $('#pd').val('');

                $('#l_sph').val('');
                $('#l_cyl').val('');
                $('#l_axs').val('');
                $('#l_add').val('');
                $('#pd2').val('');

                $('#detail-penjualan tbody').empty();
            });
            function formatRupiah(value) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
            }
            // non hutang
            let transaksi3 = 'non_hutang';
            $('#datatable-buttons3').DataTable({
                responsive: true,
                processing: true,
                ajax: {
                    url: "/kasir/data-penjualan-langsung/" + transaksi3, // Replace with your actual endpoint
                    type: "GET",
                    dataSrc: function (json) {
                        // You can process the JSON response here before returning it to DataTable
                        return json.data;
                    }
                },
                columns: [
                    {
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Menampilkan nomor urut
                        }
                    },
                    {
                        data: null,
                        title: "Tanggal",
                        render: function(data, type, row) {
                            let tanggal_transaksi = new Date(row.tanggal_transaksi).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            let tanggal_selesai = new Date(row.tanggal_selesai).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            let tanggal_ambil = new Date(row.tanggal_ambil).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            return `
                                <ul>
                                    <li><strong>Tanggal Transaksi:</strong> ${tanggal_transaksi}</li>
                                    <li><strong>Tanggal Selesai:</strong> ${tanggal_selesai}</li>
                                    <li><strong>Tanggal Ambil:</strong> ${tanggal_ambil}</li>
                                </ul>
                            `;
                        }
                    },
                    { data: 'nomor_transaksi', name: 'Nomor Transaksi' },
                    { data: 'nama', name: 'Nama' },
                    {
                        data: 'total_beli',
                        name: 'jumlah',
                        render: function (data, type, row) {
                            return `
                                <ul>
                                    <li><strong>Total:</strong> ${formatRupiah(row.total_beli)}</li>
                                    <li><strong>Diskon:</strong> ${row.diskon} %</li>
                                    <li><strong>Pembayaran:</strong> ${formatRupiah(row.jumlah_bayar)}</li>
                                    <li><strong>Sisa Pembayaran:</strong> ${formatRupiah(row.sisa_bayar)}</li>
                                </ul>
                            `;
                        }
                    },
                    {
                        data: null,
                        name: 'pembayaran',
                        render: function(data, type, row, meta) {
                            const pembayaran = row.pembayaran;
                            const jenis_transaksi = row.jenis_transaksi === 'non_hutang' ? 'Cash' : 'Hutang';
                            return pembayaran + '<br>' + jenis_transaksi;
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        render: function(data, type, row) {
                            // Tombol untuk membuka modal detail
                            return `
                                <button class="btn btn-sm btn-info view-btn" data-id="${row.nomor_transaksi}">
                                    <i class="fas fa-eye"></i>
                                </button>
                            `;
                        }
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: "btn-sm btn-primary mr-2",
                    },
                    {
                        extend: "csv",
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: "btn-sm btn-warning mr-2",
                    },
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: "btn-sm btn-success mr-2",
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: "btn-sm btn-danger mr-2",
                    },
                    {
                        extend: "print",
                        text: '<i class="fas fa-print"></i> Print',
                        className: "btn-sm btn-info mr-2",
                    },
                ],
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            $(document).on('click', '.view-btn', function() {

                var dataId = $(this).data('id');
                $('#addDataForm').data('id', dataId);
                $('#addDataForm').data('jenis', 'langsung');
                $('#addDataModalLabel').text('DETAIL TRANSAKSI ' + dataId);
                $('#detail-penjualan tbody').empty();
                $.ajax({
                    url: '/kasir/detail-penjualan-langsung/' + dataId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let totalSubTotal = 0;
                        // Loop melalui data dan tambahkan baris ke tabel
                        response.data.forEach(item => {
                            const subTotal = parseFloat(item.sub_total_transaksi) || 0;
                            const rincian = `${item.kode_produk} <br> ${item.barang.nama_produk}`;
                            const row = `
                            <tr>
                                <td>${item.jumlah_barang}</td>
                                <td>${rincian}</td>
                                <td>${formatRupiah(item.harga_barang)}</td>
                                <td>${item.jumlah_barang}</td>
                                <td>${formatRupiah(item.sub_total_transaksi)}</td>
                            </tr>
                            `;
                            $('#detail-penjualan tbody').append(row);
                            totalSubTotal += subTotal;
                        });

                        // Tambahkan baris untuk total ke tabel
                        const totalRow = `
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Total</td>
                            <td style="font-weight: bold;">${formatRupiah(totalSubTotal)}</td>
                        </tr>
                        `;
                        $('#detail-penjualan tbody').append(totalRow);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
                var modalElement = document.getElementById('addDataModal');
                var modal = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });

                modal.show();
            });

            $(document).on('click', '.print-btn', function() {
                var dataId = $('#addDataForm').data('id');
                var jenis = $('#addDataForm').data('jenis');
                let url = '';
                if (jenis === 'langsung') {
                     url = `/kasir/transaksi-langsung-cetak/${dataId}`;
                } else {
                     url = `/kasir/transaksi-pemesanan-cetak/${dataId}`;
                }
                window.location.href = url;
            });

            // hutang
            function checkJumlahBayar() {
                var jumlahPelunasan = parseInt($('#jumlah_pelunasan').val().replace(/[^\d]/g, '')) || 0;
                var jumlahSisaDP = parseInt($('#jumlah_sisa_dp').val().replace(/[^\d]/g, '')) || 0;
                if (jumlahPelunasan !== jumlahSisaDP || jumlahPelunasan === 0) {
                    $('#proses-btn').prop('disabled', true);
                } else {
                    $('#proses-btn').prop('disabled', false);
                }
            }

            $('#jumlah_pelunasan').on('keyup change', function() {
                checkJumlahBayar();
            });

            $('#jumlah_sisa_dp').on('change', function() {
                checkJumlahBayar();
            });
            checkJumlahBayar();

            let transaksi2 = 'hutang';
            $('#datatable-buttons2').DataTable({
                responsive: true,
                processing: true,
                ajax: {
                    url: "/kasir/data-penjualan-langsung/" + transaksi2, // Replace with your actual endpoint
                    type: "GET",
                    dataSrc: function (json) {
                        // You can process the JSON response here before returning it to DataTable
                        return json.data;
                    }
                },
                columns: [
                    {
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Menampilkan nomor urut
                        }
                    },
                    {
                        data: null,
                        title: "Tanggal",
                        render: function(data, type, row) {
                            let tanggal_transaksi = new Date(row.tanggal_transaksi).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            let tanggal_selesai = new Date(row.tanggal_selesai).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            let tanggal_ambil = new Date(row.tanggal_ambil).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            return `
                                <ul>
                                    <li><strong>Tanggal Transaksi:</strong> ${tanggal_transaksi}</li>
                                    <li><strong>Tanggal Selesai:</strong> ${tanggal_selesai}</li>
                                    <li><strong>Tanggal Ambil:</strong> ${tanggal_ambil}</li>
                                </ul>
                            `;
                        }
                    },
                    { data: 'nomor_transaksi', name: 'Nomor Transaksi' },
                    { data: 'nama', name: 'Nama' },
                    {
                        data: 'total_beli',
                        name: 'jumlah',
                        render: function (data, type, row) {
                            return formatRupiah(row.total_beli);
                        }
                    },
                    {
                        data: null,
                        name: 'Bayar',
                        render: function (data, type, row) {
                            var jumlah_dp = row.jumlah_bayar_dp;
                            var siswa_hutang = row.jumlah_sisa_dp;
                            var jumlah_lunas_dp = row.jumlah_lunas_dp;
                            return `
                                <ul>
                                    <li>DP Hutang: ${formatRupiah(jumlah_dp)}</li>
                                    <li class="text-danger">Sisa Hutang: ${formatRupiah(siswa_hutang)}</li>
                                    <li class="text-success">Lunas Pembayarann: ${formatRupiah(jumlah_lunas_dp)}</li>
                                </ul>
                            `;
                        }
                    },
                    {
                        data: null,
                        name: 'pembayaran',
                        render: function(data, type, row, meta) {
                            const pembayaran = row.pembayaran;
                            const jenis_transaksi = row.jenis_transaksi === 'non_hutang' ? 'Cash' : 'Hutang';
                            const status_penjualan = row.status_penjualan === 'lunas' ? 'Selesai' : 'Belum Selesai';
                            return pembayaran + '<br>' + jenis_transaksi +'<br><span class="badge badge-warning">'+status_penjualan+'</span>';
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        render: function(data, type, row) {
                            const bayarButtonDisabled = row.status_penjualan === 'lunas' ? 'disabled' : '';
                            return `
                                <button class="btn btn-sm btn-info view-btn" data-id="${row.nomor_transaksi}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary bayar-btn" data-id="${row.id}" data-nomor="${row.nomor_transaksi}" ${bayarButtonDisabled}>
                                    <i class="fa fa-credit-card"></i>
                                </button>
                            `;
                        }
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: "btn-sm btn-primary mr-2",
                    },
                    {
                        extend: "csv",
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: "btn-sm btn-warning mr-2",
                    },
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: "btn-sm btn-success mr-2",
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: "btn-sm btn-danger mr-2",
                    },
                    {
                        extend: "print",
                        text: '<i class="fas fa-print"></i> Print',
                        className: "btn-sm btn-info mr-2",
                    },
                ],
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });
            $(document).on('click', '.bayar-btn', function() {
                var dataId = $(this).data('id');
                var nomor = $(this).data('nomor');
                $('#bayarDataForm').data('id', nomor);
                $('#bayarDataModalLabel').text('DETAIL TRANSAKSI HUTANG ' + nomor);
                $.ajax({
                    url: '/kasir/update-pembayaran-hutang/' + dataId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const responseData = response.data;
                        $('#id_penjualan').val(responseData.id);
                        $('#nomor_transaksi').val(responseData.nomor_transaksi);
                        $('#nama').val(responseData.nama);
                        $('#alamat').val(responseData.alamat);
                        $('#phone_transaksi').val(responseData.phone_transaksi);
                        $('#diameter').val(responseData.diameter);
                        $('#warna').val(responseData.warna);

                        $('#total_beli2').val(responseData.total_beli);
                        $('#jumlah_bayar_dp2').val(responseData.jumlah_bayar_dp);
                        $('#jumlah_sisa_dp2').val(responseData.jumlah_sisa_dp);

                        $('#total_beli').val(formatRupiah(responseData.total_beli));
                        $('#jumlah_bayar_dp').val(formatRupiah(responseData.jumlah_bayar_dp));
                        $('#jumlah_sisa_dp').val(formatRupiah(responseData.jumlah_sisa_dp));

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
                var modalElement = document.getElementById('bayarDataModal');
                var modal = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });

                modal.show();
            });
            $('#bayarDataModal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
            });

            // pesanan
            $('#datatable-buttons1').DataTable({
                responsive: true,
                processing: true,
                ajax: {
                    url: "/kasir/data-pemesanan",
                    type: "GET",
                    dataSrc: function (json) {
                        console.log(json);
                        return json.data;
                    }
                },
                columns: [
                    {
                        data: null,
                        name: 'no',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: null,
                        title: "Tanggal",
                        render: function(data, type, row) {
                            let tanggal_transaksi = new Date(row.tanggal_transaksi).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            let tanggal_selesai = new Date(row.tanggal_selesai).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                            let tanggal_ambil = new Date(row.tanggal_ambil).toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            return `
                                <ul>
                                    <li><strong>Tanggal Transaksi:</strong> ${tanggal_transaksi}</li>
                                    <li><strong>Tanggal Selesai:</strong> ${tanggal_selesai}</li>
                                    <li><strong>Tanggal Ambil:</strong> ${tanggal_ambil}</li>
                                </ul>
                            `;
                        }
                    },
                    {
                        data: null,
                        name: 'Nomor Transaksi',
                        render: function(data, type, row, meta) {
                            const nomor = row.nomor_transaksi;
                            const status = '<span class="badge badge-warning">'+row.status_pemesanan.toUpperCase()+'</span>';
                            const gudang = '<span class="badge badge-info">'+row.gudang.nama_gudang.toUpperCase()+'</span>';
                            return nomor + '<br>' + status + '<br>' + gudang;
                        }
                    },
                    { data: 'nama', name: 'Nama' },
                    { data: 'total_beli_barang', name: 'jumlah' },
                    {
                        data: 'total_beli',
                        name: 'Bayar',
                        render: function(data, type, row) {
                            return formatRupiah(row.total_beli);
                        }
                    },
                    {
                        data: null,
                        name: 'pembayaran',
                        render: function(data, type, row, meta) {
                            const pembayaran = row.pembayaran;
                            const jenis_transaksi = row.jenis_transaksi === 'non_hutang' ? 'Cash' : 'Hutang';
                            return pembayaran + '<br>' + jenis_transaksi;
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        render: function(data, type, row) {
                            // Tombol untuk membuka modal detail
                            return `
                                <button class="btn btn-sm btn-info view2-btn" data-id="${row.nomor_transaksi}" >
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning status-btn" data-id="${row.id}" ${(row.status_pemesanan === 'selesai' || row.status_pemesanan !== 'kirim') ? 'disabled' : ''}>
                                    <i class="fa fa-check-square-o"></i> Selesai
                                </button>
                            `;
                        }
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: "btn-sm btn-primary mr-2",
                    },
                    {
                        extend: "csv",
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: "btn-sm btn-warning mr-2",
                    },
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: "btn-sm btn-success mr-2",
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: "btn-sm btn-danger mr-2",
                    },
                    {
                        extend: "print",
                        text: '<i class="fas fa-print"></i> Print',
                        className: "btn-sm btn-info mr-2",
                    },
                ],
                responsive: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            $(document).on('click', '.view2-btn', function() {
                var dataId = $(this).data('id');
                $('#addDataForm').data('id', dataId);
                $('#addDataForm').data('jenis', 'pemesanan');
                $('#addDataModalLabel').text('DETAIL TRANSAKSI ' + dataId);
                $('#detail-penjualan tbody').empty();
                $.ajax({
                    url: '/kasir/detail-pemesanan/' + dataId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let totalSubTotal = 0;
                        let no =0;

                        const data = response.data[0]; // Assuming the first item in the response is the relevant one

                        // Set form values
                        $('#r_sph').val(data.pesanan.R_SPH);
                        $('#r_cyl').val(data.pesanan.R_CYL);
                        $('#r_axs').val(data.pesanan.R_AXS);
                        $('#r_add').val(data.pesanan.R_ADD);
                        $('#pd').val(data.pesanan.PD);

                        $('#l_sph').val(data.pesanan.L_SPH);
                        $('#l_cyl').val(data.pesanan.L_CYL);
                        $('#l_axs').val(data.pesanan.L_AXS);
                        $('#l_add').val(data.pesanan.L_ADD);
                        $('#pd2').val(data.pesanan.PD2);

                        // Loop melalui data dan tambahkan baris ke tabel
                        response.data.forEach(item => {
                            const subTotal = parseFloat(item.sub_total_transaksi) || 0;
                            const rincian = `${item.kode_produk} <br> ${item.barang.nama_produk}`;
                            const row = `
                            <tr>
                                <td>${no + 1}</td>
                                <td>${rincian}</td>
                                <td>${formatRupiah(item.harga_barang)}</td>
                                <td>${item.jumlah_barang}</td>
                                <td>${formatRupiah(item.sub_total_transaksi)}</td>
                            </tr>
                            `;
                            $('#detail-penjualan tbody').append(row);
                            totalSubTotal += subTotal;
                        });

                        // Tambahkan baris untuk total ke tabel
                        const totalRow = `
                        <tr>
                            <td colspan="4" style="text-align: right; font-weight: bold;">Total</td>
                            <td style="font-weight: bold;">${formatRupiah(totalSubTotal)}</td>
                        </tr>
                        `;
                        $('#detail-penjualan tbody').append(totalRow);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
                var modalElement = document.getElementById('addDataModal');
                var modal = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });

                modal.show();
                });
            });

            $(document).on('click', '.status-btn', function () {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will mark the status as 'Selesai'.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, mark as Selesai!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform AJAX request
                        $.ajax({
                            url: '/kasir/update-status-pemesanan/'+ id, // Replace with your endpoint
                            type: 'PUT',
                            data: {
                                id: id,
                                status: 'selesai',
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                $("#datatable-buttons1").DataTable().ajax.reload();
                                Swal.fire(
                                    'Success!',
                                    'Status has been updated to Selesai.',
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to update the status. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.proses-btn', function () {
                const id = $('#id_penjualan').val();
                const jumlah_lunas_dp = $('#jumlah_pelunasan').val();
                const jumlah_bayar_dp = $('#jumlah_bayar_dp2').val();
                const nomor_transaksi = $('#nomor_transaksi').val();
                const total_beli = $('#total_beli2').val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Is there enough money to settle the debt?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, mark as Selesai!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform AJAX request
                        $.ajax({
                            url: '/kasir/simpan-pembayaran-hutang/'+ id, // Replace with your endpoint
                            type: 'PUT',
                            data: {
                                id: id,
                                jumlah_lunas_dp: jumlah_lunas_dp,
                                total_beli:total_beli,
                                jumlah_bayar_dp:jumlah_bayar_dp,
                                nomor_transaksi:nomor_transaksi,
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                $('#bayarDataModal').modal('hide');
                                $("#datatable-buttons2").DataTable().ajax.reload();
                                Swal.fire(
                                    'Success!',
                                    'Status has been updated to Selesai.',
                                    'success'
                                );

                            },
                            error: function (xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to update the debt payment. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

    </script>

@endsection
