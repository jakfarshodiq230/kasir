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
                    <h3><small>Rekap Kas</small></h3>
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
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
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

        // Isi dropdown dengan tahun mulai dari 2015 hingga tahun ini
        for (let year = startYear; year <= currentYear; year++) {
            yearSelect.append(`<option value="${year}">${year}</option>`);
        }

        // Set nilai default ke tahun saat ini
        yearSelect.val(currentYear);

        // Event untuk tombol apply
        $('#applyYearFilter').on('click', function () {
            const selectedYear = yearSelect.val();
            const id_cabang = $('#id_cabang').val();

            console.log(`Selected year: ${selectedYear}`);

            // Kirim AJAX untuk memuat data berdasarkan tahun
            $.ajax({
                url: "/laporan-kas/kas-rekap-data",
                method: "POST",
                data: {
                    tahun: selectedYear,
                    id_cabang: id_cabang,
                    _token: '{{ csrf_token() }}',
                },
                beforeSend: function () {
                    console.log("Sending request...");
                    $("#loading-overlay").show();

                },
                success: function (response) {
                    console.log("Response received:", response);
                    // Handle response Anda di sini
                    $("#loading-overlay").hide();
                    if ($.fn.dataTable.isDataTable('#datatable-buttons2')) {
                        $('#datatable-buttons2').DataTable().clear().destroy();
                    }

                    if (response.success) {
                        let datatable = $("#datatable-buttons2").DataTable({
                            responsive: true, // Enable responsive design
                            searching: false, // Disable the search bar
                            paging: true, // Enable pagination
                            info: true, // Show table info (e.g., "Showing 1 to 10 of 50 entries")
                            lengthChange: false, // Allow the user to change the number of rows displayed
                            pageLength: 12, // Set default number of rows displayed
                            autoWidth: false, // Disable auto-sizing column widths
                            dom: 'Bfrtip',  // B for Buttons, r for processing, t for table, i for table info, p for pagination
                            buttons: [
                                {
                                    extend: 'excelHtml5', // Excel export
                                    text: '<i class="fas fa-file-excel"></i> Export to Excel', // Button text
                                    title: 'Data Export',  // Title for the Excel file
                                    className: 'btn btn-success btn-sm mr-2' // Button class for styling
                                },
                                {
                                    extend: 'pdfHtml5', // PDF export
                                    text: ' <i class="fas fa-file-pdf"></i> Export to PDF', // Button text
                                    title: 'Data Export',  // Title for the PDF file
                                    orientation: 'portrait', // PDF orientation
                                    pageSize: 'A4', // PDF page size
                                    className: 'btn btn-danger btn-sm' // Button class for styling
                                }
                            ],
                        });
                        datatable.clear();
                        const bulanIndo = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        response.data.forEach((item, index) => {
                            datatable.row.add([
                                index + 1,
                                bulanIndo[item.bulan - 1] || '',
                                formatCurrency(item.total_debit) || 0,
                                formatCurrency(item.total_kredit) || 0,
                                formatCurrency(item.total_saldo) || 0,
                            ]);
                        });
                        datatable.draw();
                    } else {
                        $("#data-container").html("<p>Error fetching data.</p>");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error occurred:", error);
                    $("#loading-overlay").hide();
                },
            });
        });
    }

    // Panggil fungsi untuk menginisialisasi Year Picker
    $(document).ready(function () {
        initYearPicker();
    });
</script>
@endsection
