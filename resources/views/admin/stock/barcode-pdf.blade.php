<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4 Baris 4 Kolom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .barcode-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 columns */
            gap: 10px; /* Space between items */
            margin: 0 auto;
            padding: 5px;
        }
        .barcode-item {
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .barcode-item img {
            width: 100%;
            max-width: 150px; /* Adjust the image size */
            height: auto;
        }
        .barcode-item p {
            margin: 5px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>BARCODE {{ strtoupper($nama_produk) }}</h2>
    <table>
        @for ($i = 0; $i < $jumlah_cetak; $i++)
            @if ($i % 4 == 0) {{-- Mulai baris baru setiap 4 gambar --}}
            <tr>
            @endif

            <td>
                <div class="barcode-item">
                    {{-- Barcode Image --}}
                    <img src="{{ public_path('storage/barcode_barang/BRG20240006.png') }}" alt="Barcode">
                    {{-- Barcode Code --}}
                    <p>{{ $kode_produk }}</p>
                    {{-- Product Price --}}
                    <p>Rp. {{ number_format($harga_barang, 0, ',', '.') }}</p>
                </div>
            </td>

            @if ($i % 4 == 3) {{-- Tutup baris setelah 4 gambar --}}
            </tr>
            @endif
        @endfor
    </table>
</body>
</html>
