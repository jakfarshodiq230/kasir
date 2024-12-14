@extends('template.master')

@section('konten')
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12">
        <div class="">
          <div class="x_content">
            <div class="row">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-users"></i>
                  </div>
                  <div class="count"><?= $user ? $user : 0 ?></div>

                  <h3>Pengguna</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                  </div>
                  <div class="count"><?= $countBarang->total_penjualan_barang ? $countBarang->total_penjualan_barang : 0 ?> </div>

                  <h3>Penjualan</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-asc"></i>
                  </div>
                  <div class="count"><?= $countPesanan->total_pesanan_barang ? $countPesanan->total_pesanan_barang : 0 ?> </div>

                  <h3>Pemesanan</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i>
                  </div>
                  <div class="count"><?= $countSelesai ? $countSelesai : 0 ?> </div>

                  <h3>Selesai</h3>
                </div>
              </div>
            </div>

            <div class="row top_tiles" style="margin: 10px 0;">
                <div class="col-md-3 tile">
                  <span>Pmesanan</span>
                  <h2>Rp. <?= number_format($countPesanan->total_pesanan, 0, ',', '.') ?></h2>
                  <span class="sparkline_two" style="height: 160px;">Bulan Ini</span>
                </div>
                <div class="col-md-3 tile">
                  <span>Hutang</span>
                  <h2>Rp. <?= number_format($penjualan->total_sisa_dp, 0, ',', '.') ?></h2>
                  <span class="sparkline_two" style="height: 160px;">Bulan Ini</span>
                </div>
                <div class="col-md-3 tile">
                  <span>Saldo Kas</span>
                  <h2>Rp. <?= number_format($totalSaldo, 0, ',', '.') ?></h2>
                  <span class="sparkline_three" style="height: 160px;">Bulan Ini</span>
                </div>
                <div class="col-md-3 tile">
                  <span>Penjualan</span>
                  <h2>Rp. <?= number_format($penjualan->total_penjualan, 0, ',', '.') ?></h2>
                  <span class="sparkline_two" style="height: 160px;">Bulan Ini</span>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

        <div class="col-md-6 ">
          <div class="x_panel">
            <div class="x_title">
              <h2>Penjualan Terbanyak</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="card-box table-responsive">
                    <table id="datatable-buttons2" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>QTY</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($topSellingItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->total_terjual }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
          </div>
        </div>

        <div class="col-md-6 ">
            <div class="x_panel">
              <div class="x_title">
                <h2>Stock terendah</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="card-box table-responsive">
                    <table id="datatable-buttons2" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>QTY</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowestStockItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->stock_akhir ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center">No low-stock items</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
      </div>
</div>

@endsection
