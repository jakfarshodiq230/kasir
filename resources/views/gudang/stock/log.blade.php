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
            <h2>List Riwayat Stock</h2>
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
                                    <th>Kode gudang-stock</th>
                                    <th>Nama gudang-stock</th>
                                    <th>Kategori</th>
                                    <th>Pesanan</th>
                                    <th>Keterangan</th>
                                    <th>Keterangan</th>
                                    <th>Keterangan</th>
                                    <th>Keterangan</th>
                                    <th>Keterangan</th>
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
            <h5 class="modal-title" id="kodeProdukModalLabel">Detail stock</h5>
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
            url: "/gudang-stock/gudang-stock-log-all", // Replace with the Laravel route URL that returns JSON
            dataSrc: "data"
        },
        columns: [
            { data: "id", title: "ID" },
            { data: "barang.kode_produk", title: "Kode Barang" },
            { data: "barang.nama_produk", title: "Nama Barang" },
            { data: "suplaier.nama_suplaier", title: "Suplaier" },
            { data: "suplaier.nama_instansi_suplaier", title: "Instansi/PT/CV" },
            { data: "stock_masuk", title: "Masuk" },
            { data: "stock_keluar", title: "Keluar" },
            { data: "stock_akhir", title: "Stock Akhir" },
            { data: "keterangan_stock_gudang", title: "Keterangan" },
            {
                data: null,
                title: "Action",
                orderable: false,
                render: function(data, type, row) {
                    return `
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
                    window.location.href = '/gudang-stock/add-gudang-stock';
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

    $(document).on('click', '.delete-btn', function() {
        var dataId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete the record
                $.ajax({
                    url: '/gudang-stock/gudang-stock-log-delete/' + dataId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message || 'The data has been deleted.',
                            }).then(() => {
                                $("#datatable-buttons2").DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'An error occurred while deleting data.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred!',
                            text: error || 'Something went wrong with the request.',
                        });
                    }
                });
            }
        });
    });

</script>
@endsection
