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
            <h2>List Pemesanan Barang</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="nav navbar-right panel_toolbox d-flex align-items-center">
                <div class="row g-2">
                    <div class="col-auto">
                        <input type="date" id="filter-tanggal-transaksi" class="form-control form-control-sm">
                    </div>
                    <div class="col-auto">
                        <select id="filter-cabang-transaksi" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <?php foreach ($cabang as $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->nama_toko_cabang ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select id="filter-jenis-transaksi" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <?php foreach ($kategori as $value) { ?>
                                <option value="<?= $value->id ?>"><?= $value->nama_kategori ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
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
                                    <th>Nomor Transaksi</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>QTY</th>
                                    <th>Jumlah Total</th>
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
</div>
    {{-- end isi conten --}}
</div>
@endsection

@section('scripts')
<script>
    // function
    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
    let table = $("#datatable-buttons2").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/owner-history/pemesanan-history-data",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: function(d) {
                d.tanggal_transaksi = $("#filter-tanggal-transaksi").val();
                d.jenis_transaksi = $("#filter-jenis-transaksi").val();
                d.cabang_transaksi = $("#filter-cabang-transaksi").val();
            },
            dataSrc: function (json) {
                return json.data;
            }
        },

        columns: [
            {
                data: null,
                title: "No",
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: null,
                title: "Nomor Transaksi",
                render: function(data, type, row) {
                    const nomor = row.nomor_transaksi;
                    const gudang = row.nama_gudang.toUpperCase();
                    return nomor + " <br> " + gudang;
                }
            },
            { data: "nama", title: "Nama" },
            {
                data: null,
                title: "Tanggal",
                render: function(data, type, row) {
                    let tanggal_transaksi = new Date(row.tanggal_transaksi).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    let tanggal_selesai = new Date(row.tanggal_selesai).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    let tanggal_ambil = new Date(row.tanggal_ambil).toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    return `
                        <ul>
                            <li><strong>Tanggal Transaksi:</strong> ${tanggal_transaksi}</li>
                            <li><strong>Tanggal Selesai:</strong> ${tanggal_selesai}</li>
                            <li><strong>Tanggal Ambil:</strong> ${tanggal_ambil}</li>
                        </ul>
                    `;
                }
            },
            {
                data: null,
                title: "Pembayaran" ,
                render: function(data, type, row) {
                    const pembayaran = row.pembayaran;
                    const status = row.jenis_transaksi === 'non_hutang' ? 'Tidak Hutang' : 'Hutang';
                    return '<span class="badge badge-info">'+pembayaran.toUpperCase()+'</span><br><span class="badge badge-warning">'+status.toUpperCase()+
                        '</span><br><span class="badge badge-primary">'+row.status_pemesanan.toUpperCase()+'</span>';
                }
            },
            {
                data: null,
                title: "Total Pembelian",
                render: function(data, type, row) {
                    // Format as Indonesian Rupiah
                    let formatter = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                    return `
                        <ul>
                            <li><strong>QTY:</strong> ${row.jumlah_barang}</li>
                            <li><strong>Harga:</strong> ${formatter.format(row.harga_barang)}</li>
                            <li><strong>Total:</strong> ${formatter.format(row.sub_total_transaksi)}</li>
                        </ul>
                    `;
                }
            },
        ],
        dom: "Blfrtip",
        buttons: [
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

    $("#filter-tanggal-transaksi, #filter-jenis-transaksi, #filter-cabang-transaksi").on("change", function() {
        let tanggal = $("#filter-tanggal-transaksi").val();
        let jenis = $("#filter-jenis-transaksi").val();
        let cabang = $("#filter-cabang-transaksi").val();
        table.ajax.reload(); // Reload table
    });

</script>
@endsection
