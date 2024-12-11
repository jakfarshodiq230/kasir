@extends('template.master')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        .x_panel {
            position: relative;
        }
        #loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }
    </style>
@endsection

@section('konten')
<div class="right_col" role="main">
    {{-- isi conten --}}
    <div class="col-md-12 col-sm-12">
        <div class="x_panel dashboard_graph">
            <div class="x_title">
                <div class="col-md-6">
                    <h3><small>Rekap Penjualan</small></h3>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center" style="background: #fff; padding: 5px 10px; border: 1px solid #ccc;">
                        <!-- Cabang Dropdown -->
                        <div class="me-1">
                            <select class="form-control form-control-sm col-12" id="id_cabang" name="id_cabang">
                                <option selected>PILIH</option>
                                @foreach ($cabang as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_toko_cabang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tahun Picker -->
                        <div class="me-1">
                            <div class="d-flex align-items-center">
                                <select id="selectYear" class="form-control form-control-sm mr-4 col-12"></select>
                            </div>
                        </div>
                        <button id="applyYearFilter" class="btn btn-primary btn-sm">Terapkan</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="text-center">Rekap Penjualan Tidak Hutang (Laba Kotor)</h4>
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons1" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Total Modal</th>
                                        <th>Total Hasil Penjualan</th>
                                        <th>Total Pieces Penjualan</th>
                                        <th>Laba Kotor</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <span class="text-danger" style="font-style: italic;">* Data ditampilkan merupakan data penjualan (Tunai dan Transfer) berdasarkan cabang, tahun dan juga bukan termasuk penjualan hutang</span>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12 mt-4">
                        <h4 class="text-center">Rekap Penjualan Hutang (Laba Kotor)</h4>
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Total Modal</th>
                                        <th>Total Penjualan</th>
                                        <th>Total Pembayaran DP</th>
                                        <th>Total Sisa DP</th>
                                        <th>Total Pelunasan DP</th>
                                        <th>Total Picese</th>
                                        <th>Laba Kotor</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <span class="text-danger" style="font-style: italic;">* Data ditampilkan merupakan data penjualan berdasarkan cabang, tahun dan penjualan hutang</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    }

    // Inisialisasi Dropdown Tahun
    function initYearPicker() {
        const yearSelect = $('#selectYear');
        const currentYear = new Date().getFullYear();
        const startYear = 2015;

        // Populate dropdown with years from 2015 to current year
        for (let year = startYear; year <= currentYear; year++) {
            yearSelect.append(`<option value="${year}">${year}</option>`);
        }

        // Set default year to current year
        yearSelect.val(currentYear);

        // Event for Apply button
        $('#applyYearFilter').on('click', function () {
            const selectedYear = yearSelect.val();
            const id_cabang = $('#id_cabang').val();

            // Send AJAX requests for both 'non_hutang' and 'hutang' types
            fetchData(selectedYear, id_cabang, 'non_hutang', '#datatable-buttons1');
            fetchData(selectedYear, id_cabang, 'hutang', '#datatable-buttons2');
        });
    }

    // Function to fetch data and initialize DataTable
    function fetchData(year, cabang, transaksiType, tableId) {
        $.ajax({
            url: "/laporan-kas/penjualan-rekap-data",
            method: "POST",
            data: {
                tahun: year,
                id_cabang: cabang,
                jenis_transaksi: transaksiType,
                _token: '{{ csrf_token() }}',
            },
            beforeSend: function () {
                console.log("Sending request...");
                $("#loading-overlay").show();
            },
            success: function (response) {
                console.log("Response received:", response);
                $("#loading-overlay").hide();

                if ($.fn.dataTable.isDataTable(tableId)) {
                    $(tableId).DataTable().clear().destroy();
                }

                if (response.success) {
                    initializeDataTable(response.data, tableId);
                } else {
                    $("#data-container").html("<p>Error fetching data.</p>");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error occurred:", error);
                $("#loading-overlay").hide();
            },
        });
    }

    // Function to initialize DataTable
    function initializeDataTable(data, tableId) {
        const columns = (tableId === '#datatable-buttons1') ?
            [
                'index + 1', 'item.bulan', 'formatCurrency(item.total_harga_modal)', 'formatCurrency(item.total_harga_barang)',
                'item.total_jumlah_beli + " Pieces"', 'formatCurrency(item.laba_kotor)'
            ] :
            [
                'index + 1', 'item.bulan', 'formatCurrency(item.total_harga_modal)', 'formatCurrency(item.jumlah_pembelian)', 'formatCurrency(item.jumlah_bayar_dp)',
                'formatCurrency(item.jumlah_sisa_dp)', 'formatCurrency(item.jumlah_lunas_dp)', 'item.total_jumlah_beli + " Pieces"',
                '"Laba Kotor Didapat :"+formatCurrency(item.laba_kotor) + "<br> Sisa Laba Kotor :" + formatCurrency(item.total_laba_koto_hutang)'
            ];

        const datatable = $(tableId).DataTable({
            responsive: true,
            searching: false,
            paging: true,
            info: true,
            lengthChange: false,
            pageLength: 12,
            autoWidth: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Export to Excel',
                    title: 'Data Export',
                    className: 'btn btn-success btn-sm mr-2'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                    title: 'Data Export',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    className: 'btn btn-danger btn-sm'
                }
            ],
        });

        data.forEach((item, index) => {
            datatable.row.add(columns.map(col => eval(col)));
        });

        datatable.draw();
    }


    // Panggil fungsi untuk menginisialisasi Year Picker
    $(document).ready(function () {
        initYearPicker();
    });
</script>
@endsection
