@extends('template.master')
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
@endsection

@section('konten')
<div class="right_col" role="main">
    {{-- isi conten --}}
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>List Penjualan Barang</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="nav navbar-right panel_toolbox d-flex align-items-center">
                <div class="row g-2">
                    <div class="col-auto">
                        <input type="date" id="filter-tanggal-transaksi" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <select id="filter-jenis-transaksi" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <option value="hutang">Hutang</option>
                            <option value="non_hutang">Non Hutang</option>
                        </select>
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
                                    <th>Nomor Transaksi</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>QTY</th>
                                    <th>Jumlah Total</th>
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
                        <button type="button" class="btn btn-primary btn-sm print-btn" id="print-btn">Print</button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" id="hapus-btn">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    {{-- end isi conten --}}
</div>
@endsection

@section('scripts')
<script>
    // function
    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
    let table =$("#datatable-buttons2").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin-transaksi/transaksi-data-all",
            data: function(d) {
                d.tanggal_transaksi = $("#filter-tanggal-transaksi").val();
                d.jenis_transaksi = $("#filter-jenis-transaksi").val();
            },
            dataSrc: function (json) {
                return json.data;
            }
        },
        columns: [
            {
                data: null,
                title: "No",
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "nomor_transaksi", title: "Nomor Transaksi" },
            { data: "nama", title: "Nama" },
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
                title: "Pembayaran" ,
                render: function(data, type, row) {
                    const pembayaran = row.pembayaran;
                    const status = row.jenis_transaksi === 'non_hutang' ? 'Tunai' : 'Hutang';
                    let status_penjualan = ''; // Declare with 'let' since it's being updated
                            switch (row.status_transaksi) {
                                case 'lunas':
                                    status_penjualan = 'Selesai';
                                    break;
                                case 'belum_lunas':
                                    status_penjualan = 'Belum Selesai';
                                    break;
                                case 'pending':
                                    status_penjualan = 'Pending';
                                    break;
                                case 'dibatalkan':
                                    status_penjualan = 'Dibatalkan';
                                    break;
                                default:
                                    status_penjualan = 'Status Tidak Diketahui';
                            }
                    return '<span class="badge badge-info">'+pembayaran.toUpperCase()+
                        '</span><br><span class="badge badge-warning">'+status.toUpperCase()+'</span>'+
                        '</span><br><span class="badge badge-danger">'+status_penjualan.toUpperCase()+'</span>';
                }
            },
            {
                data: "total_beli",
                title: "Total Pembelian",
                render: function(data, type, row) {
                    // Format as Indonesian Rupiah
                    let formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    return formatter.format(data);
                }
            },

            {
                data: null,
                title: "Action",
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info view-btn" data-id="${row.nomor_transaksi}">
                            <i class="fas fa-eye"></i>
                        </button>
                    `;
                }
            }
        ],
        dom: "Blfrtip",
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
        initComplete: function() {
            $(".dataTables_length").css("margin-right", "20px");
            $(".dataTables_filter").css("margin-left", "20px");
            $(".dataTables_wrapper .dt-buttons").css("margin-top", "10px");
        }
    });

    $("#filter-tanggal-transaksi, #filter-jenis-transaksi").on("change", function() {
        let tanggal = $("#filter-tanggal-transaksi").val();
        let jenis = $("#filter-jenis-transaksi").val();
        console.log("Filter Params:", { tanggal_transaksi: tanggal, jenis_transaksi: jenis }); // Debugging
        table.ajax.reload(); // Reload table
    });


    $(document).on('click', '.view-btn', function() {
        var dataId = $(this).data('id');
        $('#addDataForm').data('id', dataId);
        $('#addDataForm').data('jenis', 'pemesanan');
        $('#addDataModalLabel').text('DETAIL TRANSAKSI ' + dataId);
        $('#detail-penjualan tbody').empty();
        $.ajax({
            url: '/admin-transaksi/transaksi-data-detail/' + dataId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log(response);

                let totalSubTotal = 0;
                let no =0;

                const data = response.data[0]; // Assuming the first item in the response is the relevant one

                // Loop melalui data dan tambahkan baris ke tabel
                response.data.forEach(item => {
                    const subTotal = parseFloat(item.sub_total_transaksi) || 0;
                    const rincian = `${item.kode_produk} <br> ${item.barang.nama_produk} <br>
                    PESAN : <spans class="badge badge-warning"> ${item.pemesanan.toUpperCase()} </spans>
                                <spans class="badge badge-danger"> ${item.status_pemesanan.toUpperCase()} </spans>`;
                    const row = `
                    <tr>
                        <td>${no + 1}</td>
                        <td>${rincian}</td>
                        <td class="${item.status_pemesanan === 'dibatalkan' ? 'text-decoration-line-through text-danger' : ''}">${formatRupiah(item.harga_barang)}</td>
                        <td class="${item.status_pemesanan === 'dibatalkan' ? 'text-decoration-line-through text-danger' : ''}">${item.jumlah_barang}</td>
                        <td class="${item.status_pemesanan === 'dibatalkan' ? 'text-decoration-line-through text-danger' : ''}">${formatRupiah(item.sub_total_transaksi)}</td>
                    </tr>
                    `;
                    $('#detail-penjualan tbody').append(row);
                    if (item.status_pemesanan != 'dibatalkan') {
                        totalSubTotal += subTotal;
                    }
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

    $(document).on('click', '.delete-btn', function () {
        const dataId = $('#addDataForm').data('id'); // Retrieve the dataId from the modal's data attribute

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'This transaction will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, send the delete request
                $.ajax({
                    url: '/admin-laporan/penjualan/delete/' + dataId, // Your delete endpoint
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token:"{{ csrf_token() }}" // Add CSRF token manually
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The transaction has been deleted successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            $('#addDataModal').modal('hide'); // Hide the modal
                            location.reload(); // Refresh the page to reflect changes
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Failed!',
                            text: 'An error occurred while deleting the transaction.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    },
                });
            }
        });
    });



</script>
@endsection
