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
    </style>
@endsection

@section('konten')
<div class="right_col" role="main">
    {{-- isi conten --}}
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel dashboard_graph">
          <div class="x_title">
            <div class="col-md-6">
                <h3><small>Kas Cabang</small></h3>
              </div>
              <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center" style="background: #fff; padding: 5px 10px; border: 1px solid #ccc">
                    <select class="form-control form-control-sm" id="id_cabang" name="id_cabang" style="width: auto;">
                        <option selected >PILIH</option>
                        @foreach ( $cabang as $item )
                            <option value="{{ $item->id }}">{{ $item->nama_toko_cabang }}</option>
                        @endforeach
                    </select>

                  <div id="reportrange" style="cursor: pointer;">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                  </div>
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
                                    <th>Kode Transaksi</th>
                                    <th>Cabang</th>
                                    <th>Petugas</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
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
    function init_daterangepicker_ajax() {
    if ($.fn.daterangepicker) {
        console.log("Initializing Date Range Picker");

        function updateDisplay(start, end) {
        $("#reportrange span").html(
            start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
        );
        }

        // Configure date range picker
        var options = {
        startDate: moment().subtract(29, "days"),
        endDate: moment(),
        minDate: "01/01/2012",
        maxDate: moment(),
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
            moment().subtract(1, "month").startOf("month"),
            moment().subtract(1, "month").endOf("month"),
            ],
        },
        locale: {
            applyLabel: "Submit",
            cancelLabel: "Clear",
            fromLabel: "From",
            toLabel: "To",
            customRangeLabel: "Custom",
            daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
            monthNames: [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
            ],
            firstDay: 1,
        },
        };

        // Initialize the date range picker
        $("#reportrange").daterangepicker(options, updateDisplay);
        $("#reportrange").on("apply.daterangepicker", function (event, picker) {
            const startDate = picker.startDate.format("YYYY-MM-DD");
            const endDate = picker.endDate.format("YYYY-MM-DD");
            const id_cabang = $('#id_cabang').val();

            console.log(`Selected range: ${startDate} to ${endDate}`);

            $.ajax({
                url: "/laporan-kas/kas-data", // Replace with your server endpoint
                method: "POST",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    id_cabang:id_cabang,
                _token: '{{ csrf_token() }}',
                },
                beforeSend: function () {
                console.log("Sending request...");
                    $("#loading-overlay").show();
                },
                success: function (response) {
                console.log("Response received:", response);
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
                        pageLength: 10, // Set default number of rows displayed
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
                    response.data.forEach((item, index) => {
                        datatable.row.add([
                            index + 1,
                            item.kode_transaksi,
                            item.cabang ? item.cabang.nama_toko_cabang : "-",
                            item.users ? item.users.name : "-",
                            item.tanggal,
                            item.keterangan,
                            formatCurrency(item.debit) || "-",
                            formatCurrency(item.kredit) || "-",
                            formatCurrency(item.saldo) || "-",
                        ]);
                    });
                    datatable.draw();
                } else {
                    $("#data-container").html("<p>Error fetching data.</p>");
                }
                },
                error: function (xhr, status, error) {
                console.error("Error occurred:", error);
                $("#data-container").html(
                    "<p>Failed to fetch data. Please try again later.</p>"
                );
                },
            });
        });
    } else {
        console.warn("Date Range Picker plugin not loaded.");
    }
    }

    $(document).ready(function () {
    init_daterangepicker_ajax();
    });


</script>
@endsection
