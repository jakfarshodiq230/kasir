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
                  <div class="count"><?= $barangCount?:0 ?></div>

                  <h3>Barang</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i>
                  </div>
                  <div class="count">0</div>

                  <h3>Penjualan</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i>
                  </div>
                  <div class="count"><?= $pesananCount?:0 ?></div>

                  <h3>Pemesanan</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i>
                  </div>
                  <div class="count"><?= $selesaiCount?:0 ?></div>

                  <h3>Selesai</h3>
                </div>
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
              <h2>Permintaan Terbanyak</h2>
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
                            @foreach ($lowestStockItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->stock_akhir ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
      </div>
</div>

@endsection
