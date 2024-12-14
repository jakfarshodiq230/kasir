<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .barcode-container {
            display: grid;
            grid-template-columns: repeat({{ $colom }}, 1fr);
            gap: 10px;
        }
        .barcode-item {
            text-align: center;
            margin-bottom: 10px;
        }
        .barcode-item img {
            width: 100%;
            max-width: 150px;
        }
    </style>
</head>
<body>
    <h2>Barcode for {{ $nama_produk }}</h2>
    <div class="barcode-container">
        @for ($i = 0; $i < $row; $i++)
            @for ($j = 0; $j < $colom; $j++)
                <div class="barcode-item">
                    <img src="{{ asset('storage/barcode_barang/BRG20240006.png') }}" alt="Barcode">
                    <p>{{ $kode_produk }}</p>
                    <p>Rp. {{ number_format($harga_barang, 0, ',', '.') }}</p>
                </div>
            @endfor
        @endfor
    </div>
</body>
</html>
