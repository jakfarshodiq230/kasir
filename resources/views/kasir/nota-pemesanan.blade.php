<!DOCTYPE html>
<html lang="en" >

<head>

  <meta charset="UTF-8">
  <style>
@media print {
    .page-break { display: block; page-break-before: always; }
}
      #invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 44mm;
  background: #FFF;
}
#invoice-POS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoice-POS h2 {
  font-size: .9em;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoice-POS p {
  font-size: .7em;
  color: #666;
  line-height: 1.2em;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}
#invoice-POS #top {
  min-height: 100px;
}
#invoice-POS #mid {
  min-height: 80px;
}
#invoice-POS #bot {
  min-height: 50px;
}
#invoice-POS .info {
  display: block;
  margin-left: 0;
}
#invoice-POS .title {
  float: right;
}
#invoice-POS .title p {
  text-align: right;
}
#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}
#invoice-POS .tabletitle {
  font-size: .5em;
  background: #EEE;
}
#invoice-POS .service {
  border-bottom: 1px solid #EEE;
}
#invoice-POS .item {
  width: 24mm;
}
#invoice-POS .itemtext {
  font-size: .5em;
}
#invoice-POS #legalcopy {
  margin-top: 5mm;
  text-align: justify;
}
.invoice-details table {
  border-spacing: 10px 15px; /* Mengatur jarak antar sel */
}

.invoice-details td {
  vertical-align: top;
  padding-right: 10px; /* Jarak kanan kolom kiri */
  font-size: 9px;
}
.payment {
    display: inline-block;
    padding-left: 2px;
    white-space: nowrap; /* Prevents wrapping of the currency and number */
}
#invoice-POS .payment {
  padding-left: 2px;  /* Keep left padding */
  padding-right: 10px; /* Add padding to the right */
  text-align: right;
  white-space: nowrap;  /* Ensure the content stays on one line */
}


    </style>

  <script>
  window.console = window.console || function(t) {};
</script>

  <script>
  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
  window.print();
</script>


</head>

<body translate="no" >


  <div id="invoice-POS">

    <center id="top">
      {{-- <div class="logo"></div> --}}
      <div class="info">
        <h2><?=$penjualan->cabang->nama_toko_cabang?></h2>
        <p>
            <?=$penjualan->cabang->alamat_cabang?></br>
            <?=$penjualan->cabang->email_cabang?></br>
            <?=$penjualan->cabang->phone_cabang?></br>
         </p>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->

    <div id="mid">
        <div class="invoice-details">
          <table>
            <tr>
              <td><strong>Nomor Invoice</strong></td>
              <td><?=$penjualan->nomor_transaksi?></td>
            </tr>
            <tr>
              <td><strong>Kasir</strong></td>
              <td><?=$penjualan->user->name?></td>
            </tr>
            <tr>
              <td><strong>Tanggal Transaksi</strong></td>
              <td><?=$penjualan->tanggal_transaksi?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Selesai</strong></td>
                <td><?=$penjualan->tanggal_selesai?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Ambil</strong></td>
                <td><?=$penjualan->tanggal_ambil?></td>
            </tr>
            <tr>
              <td><strong>Pembayaran</strong></td>
              <td><?=$penjualan->pembayaran?><?php $penjualan->jenis_transaksi ==='non_hutang' ? ' ' : '/ Hutang' ?></td>
            </tr>
          </table>
        </div>
      </div>


    <div id="bot">

        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2>Item</h2></td>
                    <td class="Hours"><h2>Qty</h2></td>
                    <td class="Hours"><h2>Harga</h2></td>
                    <td class="Rate"><h2>Sub Total</h2></td>
                </tr>
                <?php
                $total = 0;
                    foreach ($detailenjulan as $key => $value) {
                        $total = $value->jumlah_barang * $value->harga_barang;
                ?>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext"><?= $value->barang->nama_produk .'<br> PESAN : <span class="badge badge-warning">'.strtoupper($value->pemesanan).'</spans>' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $value->jumlah_barang ?></p></td>
                        <td class="tableitem"><p class="itemtext">Rp <?= number_format($value->harga_barang, 0, ',', '.') ?>,-</p></td>
                        <td class="tableitem"><p class="itemtext">Rp <?= number_format($total, 0, ',', '.') ?>,-</p></td>
                    </tr>
                <?php
                    }
                ?>

                <tr class="tabletitle" style="line-height: 0;">
                    <td colspan="3" class="Rate" style="white-space: normal; word-wrap: break-word; text-align: right;"><h2>Total :</h2></td>
                    <td class="payment" style="padding-left: 2px;" width="30px;"><h2>Rp <?= number_format($penjualan->total_beli, 0, ',', '.') ?>,-</h2></td>
                </tr>

                <tr class="tabletitle" style="line-height: 0;">
                    <td colspan="3" class="Rate" style="white-space: normal; word-wrap: break-word; text-align: right;"><h2>Diskon :</h2></td>
                    <td class="payment" style="padding-left: 2px;"><h2><?=$penjualan->diskon?> %</h2></td>
                </tr>
                <?php if ($penjualan->jenis_transaksi == 'non_hutang'): ?>
                    <tr class="tabletitle" style="line-height: 0;">
                        <td colspan="3" class="Rate" style="white-space: normal; word-wrap: break-word; text-align: right;">
                            <h2>Jumlah Bayar :</h2>
                        </td>
                        <td class="payment" style="padding-left: 2px;" >
                            <h2>Rp <?= number_format($penjualan->jumlah_bayar, 0, ',', '.') ?>,-</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle" style="line-height: 0;">
                        <td colspan="3" class="Rate" style="white-space: normal; word-wrap: break-word; text-align: right;">
                            <h2>Kembalian :</h2>
                        </td>
                        <td class="payment" style="padding-left: 2px;">
                            <h2>Rp <?= number_format($penjualan->sisa_bayar, 0, ',', '.') ?>,-</h2>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr class="tabletitle" style="line-height: 0;">
                        <td colspan="3" class="Rate" style="white-space: normal; word-wrap: break-word; text-align: right;">
                            <h2>Jumlah Bayar DP :</h2>
                        </td>
                        <td class="payment"  style="padding-left: 2px;" width="30px;">
                            <h2>Rp. <?= number_format($penjualan->jumlah_bayar_dp, 0, ',', '.') ?>,-</h2>
                        </td>
                    </tr>

                    <tr class="tabletitle" style="line-height: 0;">
                        <td colspan="3" class="Rate" style="white-space: normal; word-wrap: break-word; text-align: right;">
                            <h2>Sisa Pembayaran :</h2>
                        </td>
                        <td class="payment" style="padding-left: 2px;">
                            <h2>Rp <?= number_format($penjualan->jumlah_sisa_dp, 0, ',', '.') ?>,-</h2>
                        </td>
                    </tr>
                <?php endif; ?>

            </table>
        </div>
        <h5 style="text-align: center;">RESEP ANDA</h5>
        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="Hours"><h2>POSISI</h2></td>
                    <td class="Hours"><h2>SPH</h2></td>
                    <td class="Hours"><h2>CYL</h2></td>
                    <td class="Hours"><h2>AXS</h2></td>
                    <td class="Hours"><h2>ADD</h2></td>
                    <td class="Hours"><h2>PD</h2></td>
                </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">R</p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->R_SPH ? $penjualan->R_SPH : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->R_CYL ? $penjualan->R_CYL : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->R_AXS ? $penjualan->R_AXS : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->R_ADD ? $penjualan->R_ADD : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->PD ? $penjualan->PD : '-' ?></p></td>
                    </tr>
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">L</p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->L_SPH ? $penjualan->L_SPH : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->L_CYL ? $penjualan->L_CYL : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->L_AXS ? $penjualan->L_AXS : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->L_ADD ? $penjualan->L_ADD : '-' ?></p></td>
                        <td class="tableitem"><p class="itemtext"><?= $penjualan->PD2 ? $penjualan->PD2 : '-' ?></p></td>
                    </tr>

            </table>
        </div>

        <div id="legalcopy">
            <p class="legal"><strong>Terimakasih Telah Berbelanja!</strong>  Barang yang sudah dibeli tidak dapat dikembalikan. Jangan lupa berkunjung kembali
            </p>
        </div>

    </div>
  </div>

</body>
</html>
