@extends('template.master')

@section('konten')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
        <div class="title_left">
            <h3>Grafik</h3>
        </div>
        <div class="title_right">
            <div class="form-group d-flex justify-content-between align-items-center">
                <!-- Dropdown for Cabang -->
                <select class="form-control form-control-sm col-md-5 me-1" id="id_cabang" name="id_cabang">
                    <option selected>PILIH CABANG</option>
                    @foreach ($cabang as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_toko_cabang }}</option>
                    @endforeach
                </select>
                <!-- Dropdown for Tahun -->
                <select class="form-control form-control-sm col-md-3 me-1" id="id_tahun" name="id_tahun">
                    <option selected>PILIH TAHUN</option>
                    @php
                        $currentYear = date('Y');
                    @endphp
                    @for ($year = 2020; $year <= $currentYear; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
                <button id="tampilkanCart" class="btn btn-primary btn-sm">Tampilkan</button>
            </div>
        </div>

        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Barang</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="loading-indicator" style="text-align: center; margin-top: 20px; font-size: 16px; color: #333;">Loading...</div>
                        <canvas id="PenjulanCart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pendapatan (Kas)</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="loading-indicator-pendapatan" style="text-align: center; margin-top: 20px; font-size: 16px; color: #333;">Loading...</div>
                        <canvas id="PendapatanCart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Transaksi</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="loading-indicator-utang" style="text-align: center; margin-top: 20px; font-size: 16px; color: #333;">Loading...</div>
                        <canvas id="UtangCart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6  ">
                <div class="x_panel">
                <div class="x_title">
                    <h2>Donut Graph <small>Sessions</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <canvas id="canvasDoughnut"></canvas>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- page content -->
@endsection

@section('scripts')
    <script>
        var lineChart;
        $('#PenjulanCart').hide();

        if ($("#PenjulanCart").length) {
            var e = document.getElementById("PenjulanCart");
            lineChart = new Chart(e, {
                type: "line",
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [
                        {
                        label: "Pemesanan (YA)",
                        backgroundColor: "rgba(38, 185, 154, 0.31)",
                        borderColor: "rgba(38, 185, 154, 0.7)",
                        pointBorderColor: "rgba(38, 185, 154, 0.7)",
                        pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointBorderWidth: 1,
                        data: [], // Empty initially
                        },
                        {
                        label: "Pemesanan (TIDAK)",
                        backgroundColor: "rgba(3, 88, 106, 0.3)",
                        borderColor: "rgba(3, 88, 106, 0.70)",
                        pointBorderColor: "rgba(3, 88, 106, 0.70)",
                        pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(151,187,205,1)",
                        pointBorderWidth: 1,
                        data: [], // Empty initially
                        },
                    ],
                },
            });
        }

        // Fetch chart data
        function fetchChartData(id_cabang, tahun) {
            $('#loading-indicator').show();
            $('#PenjulanCart').hide();

            $.ajax({
                url: '/owner-grafik/data-json',
                type: 'GET',
                data: {
                    id_cabang: id_cabang,
                    tahun: tahun
                },
                success: function(response) {
                    // Hide loading indicator
                    $('#loading-indicator').hide();
                    $('#PenjulanCart').show();

                    // Ensure that the response is valid
                    if (response && response.success && response.data) {
                        var chartData = response.data;
                        if (chartData.labels && chartData.dataset1 && chartData.dataset2) {
                            // Update chart data with response data
                            lineChart.data.labels = chartData.labels;
                            lineChart.data.datasets[0].data = chartData.dataset1;
                            lineChart.data.datasets[1].data = chartData.dataset2;
                            lineChart.update(); // Update the chart
                        } else {
                            console.error("Missing required data in response:", chartData);
                            $('#loading-indicator').text("Error: Missing data in response.");
                        }
                    } else {
                        console.error("Invalid response format:", response);
                        $('#loading-indicator').text("Error: Invalid data format.");
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading-indicator').text("Error loading data. Please try again.");
                    console.error("Error fetching chart data:", error);
                }
            });
        }


        // pendapatan
        var lineChart2;
        $('#PendapatanCart').hide();
        if ($("#PendapatanCart").length) {
            var e2 = document.getElementById("PendapatanCart");
            lineChart2 = new Chart(e2, {
                type: "line",
                data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                    label: "Pendapatan",
                    backgroundColor: "rgba(38, 185, 154, 0.31)",
                    borderColor: "rgba(38, 185, 154, 0.7)",
                    pointBorderColor: "rgba(38, 185, 154, 0.7)",
                    pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    pointBorderWidth: 1,
                    data: [], // Empty initially
                    },
                ],
                },
            });
        }

        // Fetch chart data
        function fetchChartDataPendapatan(id_cabang, tahun) {
            $('#loading-indicator-pendapatan').show();
            $('#PendapatanCart').hide();

            $.ajax({
                url: '/owner-grafik/data-json-pendapatan',
                type: 'GET',
                data: {
                    id_cabang: id_cabang,
                    tahun: tahun
                },
                success: function(response) {
                    // Hide loading indicator
                    $('#loading-indicator-pendapatan').hide();
                    $('#PendapatanCart').show();

                    // Ensure that the response is valid
                    if (response && response.success && response.data) {
                        var chartData2 = response.data;
                        if (chartData2.labels && chartData2.dataset1) {
                            // Update chart data with response data
                            lineChart2.data.labels = chartData2.labels;
                            lineChart2.data.datasets[0].data = chartData2.dataset1;
                            lineChart2.update(); // Update the chart
                        } else {
                            console.error("Missing required data in response:", chartData2);
                            $('#loading-indicator-pendapatan').text("Error: Missing data in response.");
                        }
                    } else {
                        console.error("Invalid response format:", response);
                        $('#loading-indicator-pendapatan').text("Error: Invalid data format.");
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading-indicator-pendapatan').text("Error loading data. Please try again.");
                    console.error("Error fetching chart data:", error);
                }
            });
        }

        // Hide the chart initially
        $('#UtangCart').hide();

        if ($("#UtangCart").length) {
            var e3 = document.getElementById("UtangCart");
            lineChart3 = new Chart(e3, {
                type: "line",
                data: {
                    labels: [], // Empty initially
                    datasets: [
                        {
                            label: "Utang",
                            backgroundColor: "rgba(38, 185, 154, 0.31)",
                            borderColor: "rgba(38, 185, 154, 0.7)",
                            pointBorderColor: "rgba(38, 185, 154, 0.7)",
                            pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointBorderWidth: 1,
                            data: [], // Empty initially
                        },
                        {
                            label: "Non Utang",
                            backgroundColor: "rgba(3, 88, 106, 0.3)",
                            borderColor: "rgba(3, 88, 106, 0.70)",
                            pointBorderColor: "rgba(3, 88, 106, 0.70)",
                            pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(151,187,205,1)",
                            pointBorderWidth: 1,
                            data: [], // Empty initially
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    let value = tooltipItem.raw; // Access the raw data value
                                    return `${tooltipItem.dataset.label}: Rp ${value.toLocaleString('id-ID')}`;
                                },
                            },
                        },
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: function (value) {
                                    return `Rp ${value.toLocaleString('id-ID')}`;
                                },
                            },
                        },
                    },
                },
            });
        }

        // Fetch chart data
        function fetchChartDataUtang(id_cabang, tahun) {
            $('#loading-indicator-utang').show();
            $('#UtangCart').hide();

            $.ajax({
                url: '/owner-grafik/data-json-utang',
                type: 'GET',
                data: {
                    id_cabang: id_cabang,
                    tahun: tahun
                },
                success: function(response) {
                    $('#loading-indicator-utang').hide();
                    $('#UtangCart').show();

                    if (response && response.success && response.data) {
                        var chartData3 = response.data;

                        if (chartData3.labels && chartData3.dataset1 && chartData3.dataset2) {
                            // Ensure data is numeric
                            const dataset1 = chartData3.dataset1.map(Number);
                            const dataset2 = chartData3.dataset2.map(Number);

                            // Update chart data
                            lineChart3.data.labels = chartData3.labels;
                            lineChart3.data.datasets[0].data = dataset1;
                            lineChart3.data.datasets[1].data = dataset2;
                            lineChart3.update();
                        } else {
                            console.error("Missing required data in response:", chartData3);
                            $('#loading-indicator-utang').text("Error: Missing data in response.");
                        }
                    } else {
                        console.error("Invalid response format:", response);
                        $('#loading-indicator-utang').text("Error: Invalid data format.");
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading-indicator-utang').text("Error loading data. Please try again.");
                    console.error("Error fetching chart data:", error);
                }
            });
        }


        // Trigger the fetchChartData function when the button is clicked
        $('#tampilkanCart').on('click', function() {
            var id_cabang = $('#id_cabang').val(); // Replace with dynamic value if needed
            var tahun = $('#id_tahun').val(); // Replace with dynamic value if needed
            fetchChartData(id_cabang, tahun);
            fetchChartDataPendapatan(id_cabang, tahun);
            fetchChartDataUtang(id_cabang, tahun);
        });
    </script>
@endsection
