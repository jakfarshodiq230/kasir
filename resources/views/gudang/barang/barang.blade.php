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
            <h2>List Barang</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
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
                                    <th>Kode gudang-barang</th>
                                    <th>Nama gudang-barang</th>
                                    <th>Kategori</th>
                                    <th>Pesanan</th>
                                    <th>Keterangan</th>
                                    <th>Keterangan</th>
                                    <th>Keterangan</th>
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
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div class="modal" id="kodeProdukModal" tabindex="-1" aria-labelledby="kodeProdukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="kodeProdukModalLabel">Detail Barang</h5>
            </div>
            <div class="modal-body">
                <div id="kodeProdukDetails">
                    <!-- Dynamic content will be inserted here -->
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

</div>
    {{-- end isi conten --}}
</div>
@endsection

@section('scripts')
<script>
    // function
    $("#datatable-buttons2").DataTable({
        responsive: true,
        processing: true,
        ajax: {
            url: "/gudang-barang/data-gudang-barang-all", // Replace with the Laravel route URL that returns JSON
            dataSrc: "data"
        },
        columns: [
            { data: "id", title: "ID" },
            {
                data: "barcode", // Assuming 'barang.kode_produk' contains the product code
                title: "Barcode",
                orderable: false,
                render: function(data, type, row) {
                    const barcodeUrl = `{{ url('storage') }}/${row.barcode}`;
                    return `<img src="${barcodeUrl}" alt="Barcode" style="width: 300px; height: auto;"> `;
                }
            },
            { data: "kode_produk", title: "Kode Barang" },
            { data: "nama_produk", title: "Nama Barang" },
            { data: "gudang.nama_gudang", title: "Lokasi" },
            { data: "kategori.nama_kategori", title: "Kategori" },
            { data: "kategori.pesanan", title: "Pesanan" },
            {
                data: null,
                title: "Harga",
                render: function(data, type, row) {
                    function formatRupiah(value) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                    }
                    if (row.harga) {
                        let harga = row.harga;
                        return `
                            <ul>
                                <li><strong>Harga Modal:</strong> ${formatRupiah(harga.harga_modal)}</li>
                                <li><strong>Harga Jual:</strong> ${formatRupiah(harga.harga_jual)}</li>
                                <li><strong>Harga Grosir 1:</strong> ${formatRupiah(harga.harga_grosir_1)}</li>
                                <li><strong>Harga Grosir 2:</strong> ${formatRupiah(harga.harga_grosir_2)}</li>
                                <li><strong>Harga Grosir 3:</strong> ${formatRupiah(harga.harga_grosir_3)}</li>
                            </ul>
                        `;
                    } else {
                        return '<ul><li>Harga tidak tersedia</li></ul>';
                    }
                }

            },

            {
                data: null,
                title: "Action",
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <a href="gudang-barang/edit-gudang-barang/${row.id}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],
        dom: "Blfrtip",
        buttons: [
            {
                text: '<i class="fas fa-plus icon"></i> Tambah Data',
                className: "dt-button btn-sm btn-success mr-2",
                action: function(e, dt, node, config) {
                    window.location.href = '/gudang-barang/add-gudang-barang';
                },
            },
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


    $('#datatable-buttons2 tbody').on('click', 'td:nth-child(2)', function () {  // 2nd column (kode_produk)
        var rowData = $("#datatable-buttons2").DataTable().row(this).data(); // Get the data for the clicked row
        var id_barang = rowData.id; // Get the kode_produk value from the clicked row

        // Fetch additional data related to kode_produk
        $.ajax({
            url: "/gudang-barang/get-gudang-data/" + id_barang,  // URL to fetch the details, replace with the actual route
            method: "GET",
            success: function(response) {

                    var product = response.data[0];
                    var detail = response.detail[0];

                    // Update modal content
                    $('#kodeProdukDetails').html(`
                        <div class="x_content">
                            <div class="col-md-6 col-sm-">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 ">Kode Barang</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" class="form-control" id="kode_produk" name="kode_produk" placeholder="kode barang" value="${product.kode_produk}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Kategori Barang</label>
                                    <div class="col-md-0 col-sm-9 ">
                                       <input type="text" class="form-control" id="kode_produk" name="kode_produk" placeholder="kode barang" value="${product.kategori['nama_kategori']}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 ">Gudang</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text"  value="${product.gudang['nama_gudang']}" class="form-control" placeholder="Nama Gudang" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 ">Keterangan Barang<span class="required">*</span></label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <textarea type="text" name="keterangan_barang" id="keterangan_barang" class="form-control" placeholder="Keterangan barang" readonly>${product.keterangan_produk || ''}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 bg-white">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3 col-sm-3 ">Nama Barang*</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang" value="${product.nama_produk || ''}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Jenis Barang</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang" value="${detail.jenis['jenis'] || ''}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Type Barang</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang" value="${detail.type['type'] || ''}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 bg-white">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 ">
                                        <label class="col-form-label col-md-1 col-sm-1 ">R</label>
                                        <input type="number" step="1" name="r_sph" id="r_sph" class="form-control col-md-2 mr-2" placeholder="SPH" value="${detail['R_SPH'] || ''}" readonly>
                                        <input type="number" step="1" name="r_cyl" id="r_cyl" class="form-control col-md-2 mr-2" placeholder="CYL" value="${detail['R_CYL'] || ''}" readonly>
                                        <input type="number" step="1" name="r_axs" id="r_axs" class="form-control col-md-2 mr-2" placeholder="AXS" value="${detail['R_AXS'] || ''}" readonly>
                                        <input type="number" step="1" name="r_add" id="r_add" class="form-control col-md-2 mr-2" placeholder="ADD" value="${detail['R_ADD'] || ''}" readonly>
                                        <input type="number" step="1" name="pd" id="pd" class="form-control col-md-2 mr-2" placeholder="PD" value="${detail['PD'] || ''}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 ">
                                        <label class="col-form-label col-md-1 col-sm-1 ">L</label>
                                        <input type="number" step="1" name="l_sph" id="l_sph" class="form-control col-md-2 mr-2" placeholder="SPH" value="${detail['L_SPH'] || ''}" readonly>
                                        <input type="number" step="1" name="l_cyl" id="l_cyl" class="form-control col-md-2 mr-2" placeholder="CYL" value="${detail['L_CYL'] || ''}" readonly>
                                        <input type="number" step="1" name="l_axs" id="l_axs" class="form-control col-md-2 mr-2" placeholder="AXS" value="${detail['L_AXS'] || ''}" readonly>
                                        <input type="number" step="1" name="l_add" id="l_add" class="form-control col-md-2 mr-2" placeholder="ADD" value="${detail['L_ADD'] || ''}" readonly>
                                        <input type="number" step="1" name="pd2" id="pd2" class="form-control col-md-2 mr-2" placeholder="PD" value="${detail['PD2'] || ''}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    // Show the modal
                    $('#kodeProdukModal').modal('show');
            },
            error: function() {
                alert("Failed to fetch data for the selected kode barang.");
            }
        });
    });

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let url = `gudang-barang/delete-gudang-barang/${id}`;

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data successfully saved!',
                            text: response.message || 'The data has been saved successfully.',
                        }).then((result) => {
                            $("#datatable-buttons2").DataTable().ajax.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong while deleting the data.',
                            'error'
                        );
                    }
                });
            }
        });
    });

</script>
@endsection
