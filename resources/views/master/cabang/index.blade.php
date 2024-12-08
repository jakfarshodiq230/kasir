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
            <h2>List Cabang</h2>
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
                                <th>Nama Cabang</th>
                                <th>Alamat</th>
                                <th>Phone</th>
                                <th>Email</th>
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
                        <h5 class="modal-title" id="addDataModalLabel">Tambah Data Cabang</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="id_toko" id="id_toko" value="{{ Auth::user()->id_toko }}">
                            <label for="nama_toko_cabang" class="form-label">Nama Cabang</label>
                            <input type="text" class="form-control" id="nama_toko_cabang" name="nama_toko_cabang" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_cabang" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat_cabang" name="alamat_cabang" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_cabang" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone_cabang" name="phone_cabang" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_cabang" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_cabang" name="email_cabang" required>
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
$("#datatable-buttons2").DataTable({
    responsive: true,
    processing: true,
    ajax: {
        url: "/cabang/data-cabang-all", // Replace with the Laravel route URL that returns JSON
        dataSrc: "data"
    },
    columns: [
        { data: "id", title: "ID" },
        { data: "nama_toko_cabang", title: "Cabang" },
        { data: "alamat_cabang", title: "Alamat" },
        { data: "phone_cabang", title: "Phone" },
        { data: "email_cabang", title: "Email" },
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
                    <button class="btn btn-sm ${row.status_cabang == 0? 'btn-secondary' : 'btn-success'} toggle-status-btn" data-id="${row.id}" data-status="${ row.status_cabang == 0 ? 1 : 0}">
                        <i class="fas ${row.status_cabang == 0 ? 'fa-ban' : 'fa-check'}"></i> ${row.status_cabang == 0 ? 'Deactivate' : 'Activate'}
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

        var nama_toko_cabang = $('#nama_toko_cabang').val();
        var alamat_cabang = $('#alamat_cabang').val();
        var email_cabang = $('#email_cabang').val();
        var phone_cabang = $('#phone_cabang').val();
        var id_toko = $('#id_toko').val();
        var dataId = $(this).data('id');

        var url = '/cabang/save-cabang';
        var method = 'POST';
        var data = {
            nama_toko_cabang: nama_toko_cabang,
            alamat_cabang: alamat_cabang,
            email_cabang: email_cabang,
            phone_cabang:phone_cabang,
            id_toko: id_toko,

            _token: '{{ csrf_token() }}'
        };

        if (dataId) {
            url = '/cabang/update-cabang/' + dataId;
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
                let responseMessage;
                try {
                    // Attempt to parse the JSON response
                    const response = JSON.parse(xhr.responseText);
                    responseMessage = response.message || 'An unknown error occurred.';

                    // If there are validation errors, concatenate all messages
                    if (response.errors) {
                        responseMessage += '\n' + Object.values(response.errors)
                            .flat() // Flatten arrays of messages
                            .join('\n'); // Join all messages with new lines
                    }
                } catch (e) {
                    // Fallback for non-JSON response
                    responseMessage = xhr.responseText || 'Something went wrong!';
                }

                Swal.fire({
                    icon: 'error',
                    title: `Error ${xhr.status}: ${xhr.statusText}`,
                    text: responseMessage,
                });
            }

        });
    });

    // Edit button click event to open the modal and fill the form
    $(document).on('click', '.edit-btn', function() {
        var dataId = $(this).data('id');
        $('#addDataForm').data('id', dataId);
        $('#addDataModalLabel').text('Edit Data cabang');

        // Fetch additional details for the specific dataId if necessary
        $.ajax({
            url: '/cabang/get-data/' + dataId, // Replace with your endpoint for fetching data
            type: 'GET',
            success: function(response) {
                console.log(response);

                $('#nama_toko_cabang').val(response.data.nama_toko_cabang);
                $('#alamat_cabang').val(response.data.alamat_cabang);
                $('#phone_cabang').val(response.data.phone_cabang);
                $('#email_cabang').val(response.data.email_cabang);

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
                    url: '/cabang/delete-cabang/' + dataId,
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

    $(document).on('click', '.toggle-status-btn', function() {
        var button = $(this);
        var dataId = button.data('id');
        var newStatus = button.data('status');

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to ${newStatus === 1 ? 'activate' : 'deactivate'} this item.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to update the status
                $.ajax({
                    url: '/cabang/status-cabang/' + dataId,  // Your endpoint for updating the status
                    type: 'PUT',  // Use PUT for updating data
                    data: {
                        _token: '{{ csrf_token() }}',  // CSRF token for Laravel
                        status_cabang: newStatus,  // The new status to update
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $("#datatable-buttons2").DataTable().ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Status changed!',
                                text: response.message || 'The status has been updated successfully.',
                            }).then(() => {
                                // Update the button classes and text based on the new status
                                button.toggleClass('btn-success btn-secondary');
                                button.find('i').toggleClass('fa-check fa-ban');
                                button.text(newStatus === 1 ? 'Deactivate' : 'Activate');
                                button.data('status', newStatus);  // Update the status data attribute
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'An error occurred while changing the status.',
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
