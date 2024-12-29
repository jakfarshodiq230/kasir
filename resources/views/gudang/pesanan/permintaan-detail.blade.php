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
    <div class="col-md- col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>DATA PERMINTAAN BARANG</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-6 col-sm- ">
                        <div class="form-group row">
                            <input type="hidden" name="id" id="barang_id" value="">
                            <label class="col-form-label col-md-3 col-sm-3 ">Nomor Transaksi</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" class="form-control form-control-sm" id="nomor_transaksi" name="nomor_transaksi" value="<?= $permintaan_barang->nomor_transaksi ?>" placeholder="Nomor Transaksi" readonly>
                                <input type="hidden" class="form-control form-control-sm" id="id_pemesanan" name="id_pemesanan" value="<?= $permintaan_barang->id ?>" placeholder="Nomor Transaksi" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 ">Diamater</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="number" name="diameter" id="diameter" value="<?= $permintaan_barang->diameter ?>" class="form-control form-control-sm" placeholder="Diamater" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 ">Warna</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="text" name="warna" id="warna" value="<?= $permintaan_barang->warna ?>" class="form-control form-control-sm" placeholder="Warna" readonly>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-sm-6  bg-white">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Tanggal Transaksi*</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" value="<?= $permintaan_barang->tanggal_transaksi ?>" class="form-control form-control-sm" placeholder="Harga Grosir" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Tanggal Selesai*</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="<?= $permintaan_barang->tanggal_selesai ?>" class="form-control form-control-sm" placeholder="Harga Grosir" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 ">Tanggal Ambil*</label>
                            <div class="col-md-9 col-sm-9 ">
                                <input type="date" name="tanggal_ambil" id="tanggal_ambil" value="<?= $permintaan_barang->tanggal_ambil ?>" class="form-control form-control-sm" placeholder="Tanggal Ambil" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row mt-2">
                            <div class="col-md-12 col-sm-12 p-0">
                                <label class="col-form-label col-md-1 col-sm-1 ">R</label>
                                <input type="number" step="1" name="r_sph" id="r_sph" value="<?= $permintaan_barang->R_SPH ?>"  class="form-control form-control-sm col-md-2 mr-1" placeholder="SPH" readonly>
                                <input type="number" step="1" name="r_cyl" id="r_cyl" value="<?= $permintaan_barang->R_CYL ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="CYL" readonly>
                                <input type="number" step="1" name="r_axs" id="r_axs" value="<?= $permintaan_barang->R_AXS ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="AXS" readonly>
                                <input type="number" step="1" name="r_add" id="r_add" value="<?= $permintaan_barang->R_ADD ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="ADD" readonly>
                                <input type="number" step="1" name="pd" id="pd" value="<?= $permintaan_barang->PD ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="PD" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 p-0">
                                <label class="col-form-label col-md-1 col-sm-1 ">L</label>
                                <input type="number" step="1" name="l_sph" id="l_sph" value="<?= $permintaan_barang->L_SPH ?>"  class="form-control form-control-sm col-md-2 mr-1" placeholder="SPH" readonly>
                                <input type="number" step="1" name="l_cyl" id="l_cyl" value="<?= $permintaan_barang->L_CYL ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="CYL" readonly>
                                <input type="number" step="1" name="l_axs" id="l_axs" value="<?= $permintaan_barang->L_AXS ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="AXS" readonly>
                                <input type="number" step="1" name="l_add" id="l_add" value="<?= $permintaan_barang->L_ADD ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="ADD" readonly>
                                <input type="number" step="1" name="pd2" id="pd2" value="<?= $permintaan_barang->PD2 ?>" class="form-control form-control-sm col-md-2 mr-1" placeholder="PD" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Tindakan Permintaan Barang</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Tindakan</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <select class="select2_single form-control form-control-sm" tabindex="-1" name="tindakan_status" id="tindakan_status" required>
                                            <option>PILIH</option>
                                            <option value="proses">PROSES</option>
                                            <option value="tolak">TOLAK</option>
                                            <option value="kirim">KIRIM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Diskripsi</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <textarea name="tindakan_diskripsi" id="tindakan_diskripsi" class="form-control form-control-sm" placeholder="Diskripsi tindakan" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="text-align: right; padding: 0px;">
                                <button class="btn btn-sm btn-primary save-btn" id="cetak-btn" onclick="window.location.href='/gudang-permintaan/permintaan-ceatk-kirim/<?= $permintaan_barang->nomor_transaksi ?>'">Print Nota</button>
                                <button class="btn btn-sm btn-success save-btn" id="save-btn"> Simpan</button>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-8">
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Rincian</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($permintaan_detail as $key => $item) {
                                        $no++;
                                    ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $item->barang->nama_produk ?></td>
                                            <td><?= $item->jumlah_barang ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <span class="text-danger " style="font-weight: bold; font-style: italic;">*
                                Pengerjaan selesai harus pada tanggal selesai jangan sampai lewat di karenakan menunggu waktu pengiriman sangat lama
                                <ul>
                                    <li>Proses, merupakan pesanan dikerjakan atau sedang tahap penyiapan.</li>
                                    <li>Kirim, merupakan pesanan sudah selesai dan siap di kirim atau sedang pengiriman.</li>
                                    <li>Tolak, merupakan pesanan tidak bisa di proses (mungkin karena stok tidak mencukupi).</li>
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- swal alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#save-btn').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        let tindakanStatus = $('#tindakan_status').val();
        let tindakanDiskripsi = $('#tindakan_diskripsi').val();
        let nomor_transaksi = $('#nomor_transaksi').val();
        let id_pemesanan = $('#id_pemesanan').val();

        $.ajax({
            url: '/gudang-permintaan/permintaan-status-update', // Replace with your backend endpoint
            type: 'POST',
            data: {
                status_log: tindakanStatus,
                keterangan_log: tindakanDiskripsi,
                nomor_transaksi:nomor_transaksi,
                id_pemesanan:id_pemesanan,
                _token: '{{ csrf_token() }}',
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Data successfully saved!',
                    text: response.message || 'The data has been saved successfully.',
                });
                $('#tindakan_status').val('PILIH');
                $('#tindakan_diskripsi').val('');
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseText
                        ? "Kesalahan terjadi: " + xhr.responseText
                        : 'An error occurred while deleting data.',
                });
            }
        });
    });
});

</script>
@endsection
