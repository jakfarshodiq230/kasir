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
            <h2>List Produk</h2>
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
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Pesanan</th>
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
                        <h5 class="modal-title" id="addDataModalLabel">Tambah Data Produk</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode_produk" class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" id="kode_produk" name="kode_produk" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_produk" class="form-label">Kategori Produk</label>
                            <select class="form-control" name="kategori_produk" id="kategori_produk">
                                <option >--PILIH--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan_produk" class="form-label">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan_produk" name="keterangan_produk" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="addDataForm" class="btn btn-primary btn-sm">Submit</button>
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
    function fetchCategories() {
        $.ajax({
            url: '/produk/data-produk-all',
            method: 'GET',
            success: function(response) {
                let options = '<option>--PILIH--</option>';
                response.kategori.forEach(function(category) {
                    options += `<option value="${category.id}"> ${category.nama_kategori}</option>`;
                });
                $('#kategori_produk').html(options);
                $('#kode_produk').val(response.productCode);
            },
            error: function(error) {
                console.log('Error fetching categories:', error);
            }
        });
    }
    fetchCategories();

    $("#datatable-buttons2").DataTable({
        responsive: true,
        processing: true,
        ajax: {
            url: "/produk/data-produk-all", // Replace with the Laravel route URL that returns JSON
            dataSrc: "data"
        },
        columns: [
            { data: "id", title: "ID" },
            { data: "kode_produk", title: "Kode Produk" },
            { data: "nama_produk", title: "Nama Produk" },
            { data: "kategori.nama_kategori", title: "Kategori" },
            { data: "kategori.pesanan", title: "Pesanan" },
            { data: "keterangan_produk", title: "Keterangan" },
            {
                data: null,
                title: "Action",
                orderable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary edit-btn" data-id="${row.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">
                            <i class="fas fa-trash-alt"></i> Delete
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

    $(document).ready(function() {
        // Submit the form for adding or editing data
        $('#addDataForm').on('submit', function(event) {
            event.preventDefault();

            var kode_produk = $('#kode_produk').val();
            var nama_produk = $('#nama_produk').val();
            var kategori_produk = $('#kategori_produk').val();
            var keterangan_produk = $('#keterangan_produk').val();

            var dataId = $(this).data('id');

            var url = '/produk/save-produk';
            var method = 'POST';

            var data = {
                kode_produk: kode_produk,
                nama_produk: nama_produk,
                kategori_produk: kategori_produk,
                keterangan_produk:keterangan_produk,
                _token: '{{ csrf_token() }}'
            };

            if (dataId) {
                url = '/produk/update-produk/' + dataId;
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
                        $('#addDataForm').removeData('id');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data successfully saved!',
                            text: response.message || 'The data has been saved successfully.',
                        }).then((result) => {
                            $("#datatable-buttons2").DataTable().ajax.reload();
                            fetchCategories();
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

        // Edit button click event to open the modal and fill the form
        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');
            $('#addDataForm').data('id', dataId);
            $('#addDataModalLabel').text('Edit Data produk');

            // Fetch additional details for the specific dataId if necessary
            $.ajax({
                url: '/produk/get-data/' + dataId, // Replace with your endpoint for fetching data
                type: 'GET',
                success: function(response) {

                    $('#kode_produk').val(response.data.kode_produk);
                    $('#nama_produk').val(response.data.nama_produk);
                    $('#keterangan_produk').val(response.data.keterangan_produk);
                    const pesanproduk = response.data.id_kategori || '';
                    $('#kategori_produk').val(pesanproduk);

                    if (!$('#kategori_produk option[value="' + pesanproduk + '"]').length) {
                        $('#kategori_produk').val('PILIH');
                    }
                    var modal = new bootstrap.Modal(document.getElementById('addDataModal'));
                    modal.show();
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred!',
                        text: error || 'Something went wrong with the request.',
                    });
                }
            });
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
                        url: '/produk/delete-produk/' + dataId,
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
                                    fetchCategories();
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
    });

</script>
@endsection
