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
            <h2>List Kas</h2>
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
                        <input type="text" id="filter-nomor-transaksi" class="form-control form-control-sm">
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
                                    <th>QTY</th>
                                    <th>QTY</th>
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
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addDataForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDataModalLabel">Tambah Data </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                            <select class="select2_single form-control" tabindex="-1" name="jenis_transaksi" id="jenis_transaksi" required>
                                <option>PILIH</option>
                                <option value="debit">DEBIT</option>
                                <option value="kredit">KREDIT</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="jumlah_transaksi" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah_transaksi" name="jumlah_transaksi" required></input>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="keterangan_transaksi" class="form-label">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan_transaksi" name="keterangan_transaksi" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm btn-save" id="btn-save">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    function formatRupiah(amount) {
        if (amount === null || amount === undefined) return "-";
        return "Rp " + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    let table = $("#datatable-buttons2").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/admin-kas/kas-data-all", // Replace with the Laravel route URL that returns JSON
            data: function(d) {
                // Get filter values and pass them in the request data
                d.tanggal_transaksi = $("#filter-tanggal-transaksi").val();
                d.nomor_transaksi = $("#filter-nomor-transaksi").val();
            },
            dataSrc: function(json) {
                return json.data;
            }
        },
        columns: [
            {
                data: null,
                title: "Nomor",
                orderable: false,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "kode_transaksi", title: "Kode Transaksi" },
            { data: "tanggal", title: "Tanggal" },
            { data: "keterangan", title: "Keterangan" },
            {
                data: "debit",
                title: "Debit",
                render: function(data) {
                    return (data === 0 || data === "0") ? "-" : formatRupiah(data);
                }
            },
            {
                data: "kredit",
                title: "Kredit",
                render: function(data) {
                    return (data === 0 || data === "0") ? "-" : formatRupiah(data);
                }
            },
            {
                data: "saldo",
                title: "Saldo",
                render: function(data) {
                    return (data === 0 || data === "0") ? "-" : formatRupiah(data);
                }
            },
            {
                data: null,
                title: "Action",
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}" data-kode="${row.id_cabang}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}" data-kode="${row.id_cabang}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[2, "DESC"]],
        dom: "Blfrtip",
        buttons: [
            {
                text: '<i class="fas fa-plus icon"></i> Tambah Data',
                className: "dt-button btn-sm btn-success mr-2",
                action: function(e, dt, node, config) {
                    $('#addDataModalLabel').text('FORM TAMBAH TRANSAKSI');
                    $('#addDataModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
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

    $("#filter-tanggal-transaksi, #filter-nomor-transaksi").on("change", function() {
        table.ajax.reload();
    });

    $(document).on('click', '.delete-btn', function() {
        var dataId = $(this).data('id');
        var dataKode = $(this).data('kode');
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
                    url: '/admin-kas/kas-data-delete/' + dataId + '/' + dataKode,
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

    $('#addDataForm').on('submit', function(event) {
        event.preventDefault();

        var jenis_transaksi = $('#jenis_transaksi').val();
        var jumlah_transaksi = $('#jumlah_transaksi').val();
        var keterangan_transaksi = $('#keterangan_transaksi').val();
        var dataId = $(this).data('id');


        var url = '/admin-kas/kas-data-save';
        var method = 'POST';
        var data = {
            jenis_transaksi: jenis_transaksi,
            jumlah_transaksi: jumlah_transaksi,
            keterangan_transaksi: keterangan_transaksi,
            _token: '{{ csrf_token() }}'
        };

        if (dataId) {
            url = '/admin-kas/kas-data-update/' + dataId;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json',
            success: function(response) {
                // Handle the response
                if (response.success) {
                    $('#addDataModal').modal('hide');
                    $('#addDataForm')[0].reset();
                    $('#addDataForm').removeData('id'); // Clear the data-id attribute
                    Swal.fire({
                        icon: 'success',
                        title: 'Data successfully saved!',
                        text: response.message || 'The data has been saved successfully.',
                    }).then((result) => {
                        // Reload the DataTable after the action
                        $("#datatable-buttons2").DataTable().ajax.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'An error occurred while saving data.',
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurred!',
                    text: error || 'Something went wrong with the request.',
                });
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        var dataId = $(this).data('id');
        var kode = $(this).data('kode');

        $('#addDataForm').data('id', dataId);

        $.ajax({
            url: '/admin-kas/kas-data-get/' + dataId +'/'+kode,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    if (response.data.debit != 0) {
                        $('#jenis_transaksi').val('debit');
                        $('#jumlah_transaksi').val(response.data.debit);
                    } else {
                        $('#jenis_transaksi').val('kredit');
                        $('#jumlah_transaksi').val(response.data.kredit);
                    }
                    $('#keterangan_transaksi').val(response.data.keterangan);
                    $('#addDataModalLabel').text('EDIT DATA TRANSAKSI');
                    var modal = new bootstrap.Modal(document.getElementById('addDataModal'));
                    modal.show();
                } else {
                    console.log('Failed to fetch data');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX error:', error);
                console.log('An error occurred. Please try again.');
            }
        });
    });


</script>
@endsection
