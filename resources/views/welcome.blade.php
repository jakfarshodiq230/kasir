<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMLINE PESANAN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/css/utama.css')}}">
</head>

<body>
    <div class="floating-buttons shake-truck">
        <a href="https://wa.me/1234567890?text=Hello%20there!" target="_blank" class="floating-button">
            <i class="fa fa-whatsapp "></i> <span></span>
        </a>
    </div>
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-12 col-sm-12">
                <div class="card border-success shadow" style="height: 90vh;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="card-title text-success mb-0">
                                TRACKING PESANAN
                            </h4>
                            <a href="{{ route('login') }}" class="d-flex align-items-center text-decoration-none">
                                <i class="fa fa-sign-in fa-lg"></i>
                            </a>
                        </div>

                        <!-- Search form centered and responsive -->
                        <div class="row justify-content-center align-items-center " >
                            <div class="col-md-4">
                                <form class="mb-4">
                                    <div class="input-group border-success shadow">
                                        <input type="text" class="form-control form-control-sm" id="nomor_transaksi" name="nomor_transaksi" placeholder="202403XXXXX01" aria-label="Search events" required>
                                        <button class="btn btn-primary btn-sm searchButton" id="searchButton" type="button" id="searchBtn">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="hori-timeline" dir="ltr">
                            <ul class="list-inline events" id="timelineEvents"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    $('#searchButton').on('click', function() {
        var nomor_transaksi = $('#nomor_transaksi').val().toLowerCase();

        if (nomor_transaksi.trim() !== "") {
            $('#timelineEvents').html(`
            <div class="text-center">
                <p class="text-dark mb-2" style="text-align:justify;">Mohon tunggu...</p>
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `);


            $.ajax({
                url: '/sercing-data-pesanan',
                method: 'GET',
                data: { nomor_transaksi: nomor_transaksi },
                success: function(response) {

                    $('#timelineEvents').empty(); // Hapus konten sebelumnya

                    if (response.success) {
                        response.data.forEach(function(event) {
                            var eventDescription = '';
                            var warnaEvent ='';
                            var warnaDescription = '';

                            // Tentukan deskripsi berdasarkan status_log
                            if (event.status_log === 'pesan') {
                                warnaEvent ='text-primary';
                                warnaDescription = 'text-dark';
                                eventDescription = "Pilih barang yang kamu inginkan dan lakukan pemesanan dengan mudah. Mulai langkah pertama menuju kebutuhanmu terpenuhi.";
                            } else if (event.status_log === 'proses') {
                                warnaEvent ='text-warning';
                                warnaDescription = 'text-muted';
                                eventDescription = "Pesananmu sedang kami siapkan dengan hati-hati.";
                            } else if (event.status_log === 'kirim') {
                                warnaEvent ='text-danger';
                                warnaDescription = 'text-primary';
                                eventDescription = "Pesananmu sedang dalam perjalanan, ditangani dengan aman.";
                            } else if (event.status_log === 'selesai') {
                                warnaEvent ='text-success';
                                warnaDescription = 'text-dark';
                                eventDescription = "Pesananmu telah diterima, terima kasih atas kepercayaanmu.";
                            }

                            // Membuat HTML untuk setiap event dengan deskripsi dinamis
                            var eventHTML = `
                                <li class="list-inline-item event-list">
                                    <div class="px-4">
                                        <h5 class="font-size-16 ${warnaEvent}">${event.status_log.toUpperCase()}</h5>
                                        <p class="${warnaDescription}" style="text-align:justify;">
                                            ${eventDescription}
                                        </p>
                                    </div>
                                </li>
                            `;

                            // Menambahkan event ke timeline
                            $('#timelineEvents').append(eventHTML);
                        });
                    }else {
                        $('#timelineEvents').html(`<li>${response.message}</li>`); // Tampilkan pesan "data tidak ditemukan"
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        $('#timelineEvents').html('<li>Data tidak ditemukan untuk nomor transaksi ini.</li>');
                    } else {
                        $('#timelineEvents').html('<li>Terjadi kesalahan saat mengambil data.</li>');
                    }
                }
            });
        } else {
            resetTimeline(); // Reset jika input kosong
        }
    });

    function resetTimeline() {
        $('#timelineEvents').html(`
            <div class="text-center">
                <p class="text-danger mb-4" style="text-align:justify;">Tidak boleh kosong nomor transaksi.</p>
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `);
}
});

</script>
</body>

</html>
