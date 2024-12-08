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
            <h2>Seting lensa</h2>
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
                                <th class="text-center">LENSA</th>
                                <th class="text-center">SPH</th>
                                <th class="text-center">CYL</th>
                                <th class="text-center">AXS</th>
                                <th class="text-center">ADD</th>
                            </tr>
                        </thead>


                        <tbody id="data-container">
                        </tbody>
                        </table>
                        <button class="btn btn-sm btn-primary save-btn" id="saveBtn" disabled>
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button class="btn btn-sm btn-success" id="updateBtn" onclick="enableInput()">
                            <i class="fas fa-edit"></i> Update
                        </button>
                    </div>
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
    function enableInput() {
        document.getElementById("saveBtn").disabled = false;
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.readOnly = false;
        });
    }


    function loadLensaData() {
        $.ajax({
            url: '/seting-lensa/data-seting-lensa-all', // Replace with your API endpoint
            method: 'GET',
            success: function (response) {
                console.log(response.data); // Check the full response to confirm the data structure

                if (response.data) {
                    // Clear existing content in the table body
                    $('#data-container').empty();

                    // Add "MULAI" row
                    let mulaiRow = `
                        <tr>
                            <td>MULAI</td>
                            <td>
                                <input type="hidden" class="form-control" value="${response.data.id}" id="data_id" name="data_id" required>
                                <input type="number" class="form-control" value="${response.data.sph_dari}" id="m_sph" name="m_sph" required readonly>
                            </td>
                            <td><input type="number" class="form-control" value="${response.data.cyl_dari}" id="m_cyl" name="m_cyl" required readonly></td>
                            <td><input type="number" class="form-control" value="${response.data.axs_dari}" id="m_axs" name="m_axs" required readonly></td>
                            <td><input type="number" class="form-control" value="${response.data.add_dari}" id="m_add" name="m_add" required readonly></td>
                        </tr>
                    `;

                    // Add "SAMPAI" row
                    let sampaiRow = `
                        <tr>
                            <td>SAMPAI</td>
                            <td><input type="number" class="form-control" value="${response.data.sph_sampai}" id="s_sph" name="s_sph" required readonly></td>
                            <td><input type="number" class="form-control" value="${response.data.cyl_sampai}" id="s_cyl" name="s_cyl" required readonly></td>
                            <td><input type="number" class="form-control" value="${response.data.axs_sampai}" id="s_axs" name="s_axs" required readonly></td>
                            <td><input type="number" class="form-control" value="${response.data.add_sampai}" id="s_add" name="s_add" required readonly></td>
                        </tr>
                    `;

                    // Append both rows to the table body
                    $('#data-container').append(mulaiRow);
                    $('#data-container').append(sampaiRow);
                } else {
                    console.error('No data found in the response.');
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
                alert('Failed to fetch data!');
            }
        });
    }

    $(document).ready(function () {
        loadLensaData();
    });

    $(document).on('click', '.save-btn', function (e) {
        e.preventDefault();

        var data = {
            id: $('#data_id').val(),
            m_sph: $('#m_sph').val(),
            m_cyl: $('#m_cyl').val(),
            m_axs: $('#m_axs').val(),
            m_add: $('#m_add').val(),
            s_sph: $('#s_sph').val(),
            s_cyl: $('#s_cyl').val(),
            s_axs: $('#s_axs').val(),
            s_add: $('#s_add').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '/seting-lensa/save-seting-lensa', // Endpoint untuk proses insert/update
            type: 'POST',
            data: data,
            success: function (response) {
                loadLensaData();
                document.getElementById("saveBtn").disabled = true;
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                });

            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: xhr.responseJSON.message || 'Terjadi kesalahan saat menyimpan data.',
                });
            }
        });
    });

</script>
@endsection
