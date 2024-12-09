@extends('template.master')
@section('konten')
<div class="right_col" role="main">
    {{-- isi conten --}}
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Info Toko</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <form id="updateForm" method="post" novalidate>
                            @csrf
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Name Toko<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" class="form-control" name="nama_toko" value="<?= $owner->nama_toko ?>" placeholder="ex. John f. Kennedy" required="required" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Owner<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" name="nama_pemilik" value="<?= $owner->nama_pemilik ?>" type="text" required="required" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Phone<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" name="phone_toko" value="<?= $owner->phone_toko ?>" type="text" required="required" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Email<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <input class="form-control" type="email" name="email_toko" value="{{ old('email_toko', $owner->email_toko) }}" required="required" />
                                </div>
                            </div>
                            <div class="field item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align">Alamat<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6">
                                    <textarea class="form-control" name="alamat_toko" required="required" > <?= $owner->alamat_toko ?></textarea>
                                </div>
                            </div>
                            <div class="field item form-group">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </div>
                            </div>
                        </form>
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
    $(document).ready(function() {
    $('#updateForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the page from reloading

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: '/owner-toko/update-toko/{{ $owner->id }}', // Endpoint for the update
            type: 'PUT',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            success: function(response) {
                // Show SweetAlert on success
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message, // Display the success message from the response
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Optionally, you can reload the page or redirect the user to another page
                        window.location.href = '/owner-toko'; // Example: Redirect to the list of toko
                    }
                });
            },
            error: function(xhr, status, error) {
                // Show SweetAlert on error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan: ' + xhr.responseText, // Display the error message
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

</script>
@endsection
