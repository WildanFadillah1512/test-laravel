<!DOCTYPE html>
<html>
<head>
    <title>Cetak Kategori</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 30px; }
        .footer {
            position: fixed; 
            bottom: 0px; 
            left: 0px; 
            right: 0px;
            height: 30px; 
            text-align: right;
            font-size: 12px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Detail Kategori</h2>
        <p><strong>Nama Kategori:</strong> {{ $data->nama }}</p>
        <p><strong>Kode Kategori:</strong> {{ $data->kode }}</p>
    </div>

    <h3>Daftar Item</h3>
    @if($data->items->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Item</th>
                    <th>Nama Item</th>
                    <th>Jenis</th>
                    <th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada item dalam kategori ini.</p>
    @endif

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}
    </div>

</body>
</html>
