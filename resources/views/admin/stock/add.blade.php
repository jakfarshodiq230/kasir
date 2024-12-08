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
            <div class="x_title">
                <h2>FORM TAMBAH STOCK</h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-6 col-sm- ">
                    <div class="form-group row">
                        <input type="hidden" name="id_barang" id="id_barang" value=""> {{-- For update, this will hold the item ID --}}
                        <label class="col-form-label col-md-3 col-sm-3">Kode Barang</label>
                        <div class="col-md-9 col-sm-9 d-flex">
                            <input type="text" class="form-control " id="kode_produk" name="kode_produk" placeholder="kode barang">
                            <button type="button" class="btn btn-primary ml-2 search_btn" id="search_btn"><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Kategori Barang</label>
                        <div class="col-md-0 col-sm-9 ">
                            <input type="text" class="form-control" id="kategori_barang" name="kategori_barang" placeholder="kode barang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Gudang</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="nama_gudang" id="nama_gudang"  class="form-control" placeholder="Nama Gudang" readonly>
                            <input type="hidden" name="id_gudang" id="id_gudang" value="" class="form-control" placeholder="Nama Gudang" readonly>
                            <input type="hidden" name="id_user" id="id_user" value="{{ Auth::user()->id }}" class="form-control" placeholder="Nama Gudang" readonly>
                            <input type="hidden" name="id_toko" id="id_toko" value="{{ Auth::user()->id_toko }}" class="form-control" placeholder="Nama Gudang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Jumlah Barang</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control" placeholder="Jumlah Barang" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Suplaier</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="select2_single form-control" tabindex="-1" name="id_suplaier" id="id_suplaier">
                                <option selected>PILIH</option>
                                @foreach ($suplaier as $key => $value)
                                    <option value="<?= $value->id?>"><?= $value->nama_suplaier?></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6  bg-white">
                    <div class="form-group row">
                        <label class="col-form-label col-md-3 col-sm-3 ">Nama Barang*</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Nama Barang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Jenis Barang</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" placeholder="Jenis Barang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Type Barang</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="type_barang" id="type_barang" class="form-control" placeholder="Type Barang" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Jenis Transaksi</label>
                        <div class="col-md-9 col-sm-9 ">
                            <select class="select2_single form-control" tabindex="-1" name="jenis_transaksi_stock" id="jenis_transaksi_stock">
                                <option selected>PILIH</option>
                                <option value="masuk">Masuk</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-md-12 col-sm-12  bg-white">
                    <div class="form-group row">
                        <div class="col-md-12 col-sm-12 ">
                            <label class="col-form-label col-md-1 col-sm-1 ">R</label>
                            <input type="number" step="1" name="r_sph" id="r_sph" class="form-control col-md-2 mr-2" placeholder="SPH" readonly>
                            <input type="number" step="1" name="r_cyl" id="r_cyl" class="form-control col-md-2 mr-2" placeholder="CYL" readonly>
                            <input type="number" step="1" name="r_axs" id="r_axs" class="form-control col-md-2 mr-2" placeholder="AXS" readonly>
                            <input type="number" step="1" name="r_add" id="r_add" class="form-control col-md-2 mr-2" placeholder="ADD" readonly>
                            <input type="number" step="1" name="pd" id="pd" class="form-control col-md-2 mr-2" placeholder="PD" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 col-sm-12 ">
                            <label class="col-form-label col-md-1 col-sm-1 ">L</label>
                            <input type="number" step="1" name="l_sph" id="l_sph" class="form-control col-md-2 mr-2" placeholder="SPH" readonly>
                            <input type="number" step="1" name="l_cyl" id="l_cyl" class="form-control col-md-2 mr-2" placeholder="CYL" readonly>
                            <input type="number" step="1" name="l_axs" id="l_axs" class="form-control col-md-2 mr-2" placeholder="AXS" readonly>
                            <input type="number" step="1" name="l_add" id="l_add" class="form-control col-md-2 mr-2" placeholder="ADD" readonly>
                            <input type="number" step="1" name="pd2" id="pd2" class="form-control col-md-2 mr-2" placeholder="PD" readonly>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="d-flex justify-content-between align-items-center w-100">
                <span class="text-danger"><i><b>Pastikan setiap penginputan data benar atau sesuai di karenakan tidak bisa di kembalikan data tersebut</b></i></span>
                <button type="button" class="btn btn-success btn-sm simpan_btn" id="simpan_btn">Simpan</button>
            </div>

    </div>


</div>
    {{-- end isi conten --}}
</div>
@endsection

@section('scripts')
<script>

    $(document).ready(function() {

        $('#kode_produk').on('paste', function(e) {
            e.preventDefault();  // Prevent the paste action
            Swal.fire({
                title: 'Error',
                text: 'Paste is disabled! You must type the value.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });

        $('#search_btn').on('click', function () {
            var kodeProduk =  $('#kode_produk').val();

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
                url: '/admin-stock/sercing-admin-stock/' + kodeProduk,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    var product = response.data;
                    var detail = response.detail;

                    $('#id_barang').val(product.id);
                    $('#nama_produk').val(product.nama_produk);
                    $('#id_gudang').val(product.gudang['id']);
                    $('#nama_gudang').val(product.gudang['nama_gudang']);
                    $('#kategori_barang').val(product.kategori['nama_kategori']);
                    $('#jenis_barang').val(detail.jenis['jenis']);
                    $('#type_barang').val(detail.type['type']);

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
                    Swal.close();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
                        text: 'Your code is incorrect and the code was not found.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('.simpan_btn').on('click', function() {
            var jumlahBarang = $('#jumlah_barang').val();
            var jenis_transaksi_stock = $('#jenis_transaksi_stock').val();
            var id_gudang = $('#id_gudang').val();
            var id_barang = $('#id_barang').val();
            var id_user = $('#id_user').val();
            var id_toko = $('#id_toko').val();
            var id_suplaier = $('#id_suplaier').val();

            $.ajax({
                url: '/admin-stock/save-admin-stock',
                type: 'POST',
                data: {
                    jumlah_barang: jumlahBarang,
                    jenis_transaksi_stock: jenis_transaksi_stock,
                    id_gudang: id_gudang,
                    id_barang: id_barang,
                    id_user: id_user,
                    id_toko:id_toko,
                    id_suplaier: id_suplaier,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved Successfully!',
                            text: response.message || 'The data has been processed successfully.',
                        }).then(() => {
                            window.location.href = '/admin-stock';
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Display an error alert with SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.',
                    });
                }
            });
        });

    });




</script>
@endsection
