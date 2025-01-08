<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang ke Sistem Kasir</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kasir.png')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('build/css/utama.css') }}">
</head>

<body>
    <div class="floating-buttons shake-truck">
        <a href="https://wa.me/1234567890?text=Hello%saya akan join menggunakan sistem ini, bagaimana cara mendaftarnya!" target="_blank" class="floating-button">
            <i class="fa fa-whatsapp"></i> <span></span>
        </a>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12">
                <div class="card border-success shadow" style="height: 90vh;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">

                        <!-- Card Header -->
                        <h4 class="card-title text-success mb-4">
                            SELAMAT DATANG KE SISTEM KASIR
                        </h4>

                        <!-- User Icon -->
                        <div class="mb-0">
                            <img src="{{ asset('images/kasir.png') }}" alt="Kasir Icon" height="300px;">
                        </div>

                        <!-- Description -->
                        <p class="text-muted mb-2 text-center">
                            Dengan sistem ini, Anda dapat melacak pesanan dengan mudah, mengelola transaksi, dan meningkatkan efisiensi operasional.
                        </p>

                        <!-- Buttons -->
                        <div>
                            @if (Route::has('login'))
                                @auth
                                    @php
                                        $redirectUrl = '#';
                                        switch (Auth::user()->level_user) {
                                            case 'kasir':
                                                $redirectUrl = route('kasir.index');
                                                break;
                                            case 'admin':
                                                $redirectUrl = route('admin-dashboard.index');
                                                break;
                                            case 'gudang':
                                                $redirectUrl = route('gudang-dashboard.index');
                                                break;
                                            case 'owner':
                                                $redirectUrl = route('owner-dashboard.index');
                                                break;
                                            default:
                                                $redirectUrl = url('/');
                                        }
                                    @endphp
                                    <a href="{{ $redirectUrl }}" class="btn btn-success">
                                        Kembali ke Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        Login
                                    </a>
                                @endauth
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>
