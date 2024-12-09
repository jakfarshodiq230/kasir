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
                <h3><small>Divace Users</small></h3>
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
                                    <th>Nama User</th>
                                    <th>IP</th>
                                    <th>Divace</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
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
</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bowser@2.11.0/es5.js"></script>
<script>
function dataDivace() {
    $.ajax({
        url: "/divace/login-data", // Ganti dengan endpoint server Anda
        method: "GET",
        beforeSend: function () {
            console.log("Sending request...");
            $("#loading-overlay").show(); // Tampilkan overlay loading
        },
        success: function (response) {
            console.log("Response received:", response);

            // Hapus DataTable jika sudah ada
            if ($.fn.dataTable.isDataTable('#datatable-buttons2')) {
                $('#datatable-buttons2').DataTable().clear().destroy();
            }

            if (response.success) {
                let datatable = $("#datatable-buttons2").DataTable({
                    responsive: true,
                    searching: false,
                    paging: true,
                    info: true,
                    lengthChange: false,
                    pageLength: 10,
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

                datatable.clear();
                response.data.forEach((item, index) => {
                    const lastActivity = new Date(item.last_activity * 1000); // Konversi timestamp ke Date

                    const currentTime = new Date();
                    const timeDifference = currentTime - lastActivity;
                    const isActive = timeDifference < 30 * 60 * 1000; // 30 menit

                    const formattedDate = lastActivity.toLocaleDateString("en-GB", {
                        year: "numeric",
                        month: "2-digit",
                        day: "2-digit"
                    });

                    const formattedTime = lastActivity.toLocaleTimeString("en-GB", {
                        hour: "2-digit",
                        minute: "2-digit",
                        second: "2-digit"
                    });

                    // Deteksi browser menggunakan bowser
                    const browser = bowser.getParser(item.user_agent);
                    const browserName = browser.getBrowserName(); // Nama browser

                    const status = isActive ? 'Aktif' : 'Logout';

                    // Tambahkan baris dengan status dan nama browser
                    datatable.row.add([
                        index + 1,
                        item.user ? item.user.name : "-",
                        item.ip_address,
                        browserName, // Nama browser
                        formattedDate,
                        formattedTime,
                        status
                    ]);
                });
                datatable.draw();
            } else {
                $("#data-container").html("<p>Error fetching data.</p>");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error occurred:", error);
            $("#data-container").html("<p>Failed to fetch data. Please try again later.</p>");
        },
        complete: function () {
            $("#loading-overlay").hide();
        }
    });
}

// Panggil fungsi untuk menampilkan data
dataDivace();

</script>
@endsection
