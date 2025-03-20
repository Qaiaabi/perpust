<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Arsip Peminjaman</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
            line-height: 1.5;
            margin: 20px;
        }

        h2 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 8px 12px;
            border: 1px solid #555;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: capitalize;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <h2>Laporan Arsip Peminjaman</h2>
    <p>Tanggal: {{ now()->format('d-m-Y') }}</p>

    @if($archives->isNotEmpty())
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Judul Buku</th>
                <th>Genre</th>
                <th>Tanggal Pengambilan</th>
                <th>Tanggal Pengembalian</th>
                <th>Durasi Pinjam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archives as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->email }}</td>
                <td>{{ $item->book->judul }}</td>
                <td>{{ $item->book->category->cat_title }}</td>
                <td>{{ $item->borrow_at ? \Carbon\Carbon::parse($item->borrow_at)->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->returned_at ? \Carbon\Carbon::parse($item->returned_at)->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->durasi_pinjam }} hari</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    @else
    <p>Data arsip tidak tersedia.</p>
    @endif


    </table>

    <!-- Footer -->
    <div class="footer">
        Halaman
        <script type="text/php">
            if (isset($pdf)) {
                echo $pdf->get_page_number() . ' dari ' . $pdf->get_page_count();
            }
        </script>
    </div>

</body>

</html>