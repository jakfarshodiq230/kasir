@extends('template.master')
@section('styles')
    <style>
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
            <form id="TambahBarang" action="" method="post">
            <div class="x_title">
                <h2>CETAK BARCODE ADMIN</h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-6 col-sm- ">
                    <div class="form-group row">
                        <input type="hidden" name="id_barang" id="id_barang" value="">
                        <label class="col-form-label col-md-3 col-sm-3">Kode Barang</label>
                        <div class="col-md-9 col-sm-9 d-flex">
                            <input type="text" class="form-control " id="kode_produk" name="kode_produk" placeholder="kode barang">
                            <button type="button" class="btn btn-primary ml-2 search_btn" id="search_btn"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Nama Barang*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang" readonly>
                            <input type="hidden" name="barcode" id="barcode" class="form-control" placeholder="Nama Barang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Harga Barang<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="select2_single form-control form-control-sm" tabindex="-1" name="harga_barang" id="harga_barang">
                                <option>PILIH</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Harga Lainya<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="number" name="harga_lainya" id="harga_lainya" class="form-control form-control-sm" value="0" placeholder="Ketikan Harga Lainya">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Jumlah Cetak *</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="number" min="1" max="4" name="jumlah_cetak" id="jumlah_cetak" class="form-control" placeholder="jumlah cetak">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 bg-white" id="barcode-preview-container" style="display:none;">
                    <div class="form-group row">
                        <!-- Barcode Image Container -->
                        <div class="col-md-12 col-sm-12 text-center">
                            <img id="barcode-img" src="" alt="Barcode" style="width: 300px; height: auto;">
                        </div>
                        <!-- Barcode Information Container -->
                        <div class="col-md-12 col-sm-12 mt-2 text-center">
                            <p id="barcode-kode" style="word-wrap: break-word; width: 300px; margin: 0 auto; text-align: center; letter-spacing: 21px; overflow: hidden; white-space: nowrap;"></p>
                            <p id="barcode-harga" style="word-wrap: break-word; width: 300px; margin: 0 auto; text-align: center; letter-spacing: 2px; overflow: hidden; white-space: nowrap; font-weight: bold;" ></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="d-flex justify-content-between align-items-center w-100">
                <span class="text-danger"><i><b>Cetak/Download PDF barcode barang</b></i></span>
                <div class="ml-auto"> <!-- Added div for aligning buttons to the right -->
                    <button type="button" class="btn btn-success btn-sm view-btn" id="view-btn">Privew Barcode</button>
                    <button type="button" class="btn btn-success btn-sm download-btn" id="download-btn" disabled>Download PDF</button>
                </div>
            </div>
        </form>
    </div>


</div>
    {{-- end isi conten --}}
</div>
@endsection

@section('scripts')
<script>
    // Ambil elemen tombol
    const viewBtn = document.getElementById('view-btn');
    const downloadBtn = document.getElementById('download-btn');

    // Tambahkan event listener untuk tombol view-btn
    viewBtn.addEventListener('click', function() {
        // Aktifkan tombol download-btn setelah tombol view-btn diklik
        downloadBtn.disabled = false;
    });
$('#harga_lainya').closest('.form-group').hide();
$(document).ready(function () {
    // Step 1: Search Product by Product Code
    $('#search_btn').on('click', function () {
        $('#harga_lainya').closest('.form-group').hide(); // Hide additional price field initially
        var kodeProduk = $('#kode_produk').val();

        // Show loading spinner
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait while we fetch the data.',
            icon: 'info',
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/admin-stock/sercing-barcode-barang/' + kodeProduk,
            type: 'GET',
            success: function (response) {
                console.log(response);
                var product = response.data;

                // Populate product details
                $('#id_barang').val(product.id);
                $('#nama_produk').val(product.barang.nama_produk);
                $('#barcode').val(product.barang.barcode);

                // Clear existing options
                $('#harga_barang').empty();
                $('#harga_barang').prop('disabled', false); // Enable the price dropdown

                // Check if there are prices and loop through them
                if (response.harga && response.harga.original.length > 0) {
                    // Loop through the harga.original array to populate options
                    response.harga.original.forEach(harga => {
                        const optionText = harga.price == 0
                            ? `${harga.Ket}`
                            : `${harga.Ket} - Rp ${parseFloat(harga.price).toLocaleString('id-ID')}`;

                        $('#harga_barang').append(
                            `<option value="${harga.price}" data-price="${harga.price}">${optionText}</option>`
                        );
                    });
                } else {
                    $('#harga_barang').prop('disabled', true); // Disable price dropdown if no prices found
                }

                // Close loading spinner
                Swal.close();
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.close();
                Swal.fire({
                    title: 'Error',
                    text: 'The product code was not found or an error occurred.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Step 2: Price Selection Change Event
    $('#harga_barang').on('change', function () {
        const selectedOption = $(this).find('option:selected');
        const selectedPrice = selectedOption.data('price');

        if (selectedPrice === 0) {
            $('#harga_lainya').closest('.form-group').show(); // Show "Harga Lainya" input if price is 0
        } else {
            $('#harga_lainya').closest('.form-group').hide(); // Hide "Harga Lainya" input if price is not 0
        }

        // Enable the preview barcode button after price selection
        $('#view-btn').show();
    });

    // Step 3: Preview Barcode
    $('#view-btn').click(function () {
        // Get the selected price and product code
        let selectedPrice = $('#harga_barang').val();
        if (selectedPrice == 0) {
            selectedPrice = $('#harga_lainya').val();
        }
        const selectedProductCode = $('#kode_produk').val();

        // Get the barcode URL (assuming barcode URL is available)
        var barcodeURL = "{{ url('storage') }}/" + $('#barcode').val(); // Adjust based on your response structure

        // Set the barcode image source
        $('#barcode-img').attr('src', barcodeURL);

        // Display Product Code and Price information
        $('#barcode-kode').html(`${selectedProductCode}`);
        $('#barcode-harga').html(`Rp. ${parseFloat(selectedPrice).toLocaleString('id-ID')}`);

        // Show the barcode preview container
        $('#barcode-preview-container').show();
    });
});

$('#download-btn').on('click', function (e) {
    e.preventDefault();
    let jumlah_cetak = $('#jumlah_cetak').val();

    // Check if values are valid
    if (!jumlah_cetak || jumlah_cetak < 1) {
        Swal.fire({
            title: 'Error',
            text: 'Please enter valid jumlah cetak.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Prepare data to send to the backend
    let requestData = {
        kode_produk: $('#kode_produk').val(),
        nama_produk: $('#nama_produk').val(),
        barcode: $('#barcode').val(),
        harga_barang: $('#harga_barang').val(),
        harga_lainya: $('#harga_lainya').val(),
        jumlah_cetak: jumlah_cetak,
    };

    // Send data to the backend via AJAX for PDF generation
    $.ajax({
        url: '/admin-stock/pdf-barcode-barang/',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: requestData,
        success: function (response) {
            // Handle the PDF download response
            if (response.success) {
                // Assuming the server returns a PDF URL or content
                window.location.href = response.pdf_url;  // Redirect to the generated PDF URL
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error generating the PDF.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function () {
            Swal.fire({
                title: 'Error',
                text: 'An unexpected error occurred.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
});


</script>
@endsection
