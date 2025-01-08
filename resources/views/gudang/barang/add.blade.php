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
                <?= $id === null ? '<h2>FORM TAMBAH BARANG</h2>' : '<h2>FORM EDIT BARANG</h2>' ; ?>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-6 col-sm- ">
                    <div class="form-group row">
                        <input type="hidden" name="id" id="barang_id" value=""> {{-- For update, this will hold the item ID --}}
                        <label class="col-form-label col-md-3 col-sm-3 ">Kode Barang</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" class="form-control" id="kode_produk" name="kode_produk" placeholder="kode barang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Kategori Barang</label>
                        <div class="col-md-0 col-sm-9 ">
                            <select class="select2_single form-control" tabindex="-1" name="kategori_barang" id="kategori_barang">
                                <option>PILIH</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Gudang</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text"  value="{{ session('gudang_nama')}}" class="form-control" placeholder="Nama Gudang" readonly>
                            <input type="hidden" name="id_gudang" id="id_gudang" value="{{ session('gudang_id')}}" class="form-control" placeholder="Nama Gudang" readonly>
                            <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}" class="form-control" placeholder="Nama Gudang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Ketrangan Barang<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 ">
                            <textarea type="text" name="keterangan_barang" id="keterangan_barang" class="form-control" placeholder="Keterangan barang"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Harga Grosir 1*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="harga_grosir_1" id="harga_grosir_1" class="form-control" placeholder="Harga Grosir">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Harga Grosir 2*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="harga_grosir_2" id="harga_grosir_2" class="form-control" placeholder="Harga Grosir">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6  bg-white">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Nama Barang*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Jenis Barang*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="select2_single form-control" tabindex="-1" name="jenis_barang" id="jenis_barang">
                                <option>PILIH</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Type Barang*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="select2_single form-control" tabindex="-1" name="type_barang" id="type_barang">
                                <option>PILIH</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Harga Modal*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="harga_modal" id="harga_modal" class="form-control" placeholder="Harga Modal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Harga Jual Umum*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="harga_jual" id="harga_jual" class="form-control" placeholder="Harga Jual">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Harga Grosir 3*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="harga_grosir_3" id="harga_grosir_3" class="form-control" placeholder="Harga Grosir">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12  bg-white">
                    <div class="form-group row">
                        <div class="col-md-12 col-sm-12 ">
                            <label class="col-form-label col-md-1 col-sm-1 ">R</label>
                            <input type="number" step="1" name="r_sph" id="r_sph" class="form-control col-md-2 mr-2" placeholder="SPH">
                            <input type="number" step="1" name="r_cyl" id="r_cyl" class="form-control col-md-2 mr-2" placeholder="CYL">
                            <input type="number" step="1" name="r_axs" id="r_axs" class="form-control col-md-2 mr-2" placeholder="AXS">
                            <input type="number" step="1" name="r_add" id="r_add" class="form-control col-md-2 mr-2" placeholder="ADD">
                            <input type="number" step="1" name="pd" id="pd" class="form-control col-md-2 mr-2" placeholder="PD">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 col-sm-12 ">
                            <label class="col-form-label col-md-1 col-sm-1 ">L</label>
                            <input type="number" step="1" name="l_sph" id="l_sph" class="form-control col-md-2 mr-2" placeholder="SPH">
                            <input type="number" step="1" name="l_cyl" id="l_cyl" class="form-control col-md-2 mr-2" placeholder="CYL">
                            <input type="number" step="1" name="l_axs" id="l_axs" class="form-control col-md-2 mr-2" placeholder="AXS">
                            <input type="number" step="1" name="l_add" id="l_add" class="form-control col-md-2 mr-2" placeholder="ADD">
                            <input type="number" step="1" name="pd2" id="pd2" class="form-control col-md-2 mr-2" placeholder="PD">
                        </div>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="d-flex justify-content-between align-items-center w-100">
                <span class="text-danger"><i><b>Pastikan setiap penginputan data benar atau sesuai di karenakan tidak bisa di kembalikan data tersebut</b></i></span>
                <button type="button" class="btn btn-success btn-sm btn-save" id="simpan_btn">Simpan</button>
            </div>
        </form>
    </div>


</div>
    {{-- end isi conten --}}
</div>
@endsection

@section('scripts')
<script>
const id_edit = '<?= $id ?>';

function fetchCategoriesAndInitAutocomplete() {
    $.ajax({
        url: '/gudang-barang/kode-gudang-barang',
        method: 'GET',
        success: function(response) {
            // Populate the kategori select dropdown
            var kategoriOptions = response.kategori.map(function(category) {
                return '<option value="' + category.id + '">' + category.nama_kategori.toUpperCase() +' [ PESANAN : '+category.pesanan.toUpperCase() +' ]' + '</option>';
            }).join('');
            var selectOptions = '<option value="" disabled selected>PILIH</option>' + kategoriOptions;
            $('#kategori_barang').html(selectOptions);

            // Populate the jenis select dropdown
            var jenisOptions = response.jenis.map(function(jenis) {
                return '<option value="' + jenis.id + '">' + jenis.jenis.toUpperCase() + '</option>';
            }).join('');
            var jenisOptions1 = '<option value="" disabled selected>PILIH</option>' + jenisOptions;
            $('#jenis_barang').html(jenisOptions1);

            // Populate the type select dropdown
            var typeOptions = response.type.map(function(type) {
                return '<option value="' + type.id + '">' + type.type.toUpperCase()  + '</option>';
            }).join('');
            var typeOptions1 = '<option value="" disabled selected>PILIH</option>' + typeOptions;
            $('#type_barang').html(typeOptions1);

            $('#kode_produk').val(response.productCode);

            // Update lens settings for r_sph, l_sph, r_cyl, l_cyl, r_axs, l_add
            $('#r_sph, #l_sph').attr({
                min: response.seting_lensa.sph_dari,
                max: response.seting_lensa.sph_sampai
            }).val(response.default_sph || '');

            $('#r_cyl, #l_cyl').attr({
                min: response.seting_lensa.cyl_dari,
                max: response.seting_lensa.cyl_sampai
            }).val(response.default_sph || '');

            $('#r_axs, #l_add').attr({
                min: response.seting_lensa.axs_dari,
                max: response.seting_lensa.axs_sampai
            }).val(response.default_sph || '');

            $('#r_add, #l_add').attr({
                min: response.seting_lensa.add_dari,
                max: response.seting_lensa.add_sampai
            }).val(response.default_sph || '');
        },
        error: function(error) {
            console.log('Error fetching categories:', error);
        }
    });
}

function fetchItemForUpdate(itemId) {
    $.ajax({
        url: `/gudang-barang/get-gudang-data/${itemId}`,
        method: 'GET',
        success: function(response) {

            if (response.success) {
                var product = response.data[0];
                var detail = response.detail[0];


                $('#barang_id').val(product.id);
                $('#kode_produk').val(product.kode_produk);
                $('#nama_produk').val(product.nama_produk);
                $('#keterangan_produk').val(product.keterangan_produk);

                // Set the category, ensure it is correctly selected
                const pesanKategori = product.kategori['id'] || ''; // Ensure you use the correct field for comparison
                $('#kategori_barang').val(pesanKategori).trigger('change');

                if (!$('#kategori_barang option[value="' + pesanKategori + '"]').length) {
                    $('#kategori_barang').val('PILIH');
                }

                const jenis = detail.jenis['id'] || ''; // Ensure you use the correct field for comparison
                $('#jenis_barang').val(jenis).trigger('change');

                if (!$('#jenis_barang option[value="' + jenis + '"]').length) {
                    $('#jenis_barang').val('PILIH');
                }

                const type = detail.type['id'] || ''; // Ensure you use the correct field for comparison
                $('#type_barang').val(type).trigger('change');

                if (!$('#type_barang option[value="' + type + '"]').length) {
                    $('#type_barang').val('PILIH');
                }

                $('#keterangan_barang').val(product.keterangan_produk);

                $('#r_sph').val(detail['R_SPH']);
                $('#r_cyl').val(detail['R_CYL']);
                $('#r_axs').val(detail['R_AXS']);
                $('#r_add').val(detail['R_ADD']);
                $('#pd').val(detail['PD']);

                $('#l_sph').val(detail['L_SPH']);
                $('#l_cyl').val(detail['L_CYL']);
                $('#l_axs').val(detail['L_AXS']);
                $('#l_add').val(detail['L_ADD']);
                $('#pd2').val(detail['PD2']);

                $('#harga_modal').val(product.harga['harga_modal']);
                $('#harga_jual').val(product.harga['harga_jual']);
                $('#harga_grosir_1').val(product.harga['harga_grosir_1']);
                $('#harga_grosir_2').val(product.harga['harga_grosir_2']);
                $('#harga_grosir_3').val(product.harga['harga_grosir_3']);

                // Populate other fields as necessary
            } else {
                Swal.fire('Error', response.message || 'Failed to fetch item data.', 'error');
            }
        },
        error: function(error) {
            Swal.fire('Error', 'Failed to fetch item data.', 'error');
        }
    });
}

$(document).ready(function () {
    fetchCategoriesAndInitAutocomplete();
    if (id_edit && id_edit !== "") {
        fetchItemForUpdate(id_edit);
    }


    $('.btn-save').click(function (e) {
        e.preventDefault();

        var formData = $('#TambahBarang').serialize();
        formData += '&_token=' + '{{ csrf_token() }}';

        var itemId = $('#barang_id').val();
        var url = itemId
            ? `/gudang-barang/update-gudang-barang/${itemId}` // Update endpoint
            : '/gudang-barang/save-gudang-barang';           // Save endpoint
        var method = itemId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#TambahBarang')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: itemId ? 'Updated Successfully!' : 'Saved Successfully!',
                        text: response.message || 'The data has been processed successfully.',
                    }).then(() => {
                        window.location.href = '/gudang-barang';
                        fetchCategoriesAndInitAutocomplete();
                    });
                } else {
                    Swal.fire('Error', response.message || 'An error occurred.', 'error');
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'An error occurred with the request.', 'error');
            }
        });
    });
});


</script>
@endsection
