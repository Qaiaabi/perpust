<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Peminjaman</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
            line-height: 1.5;
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
    <h2>Laporan Data Peminjaman</h2>
    <p>Tanggal: {{ now()->format('d-m-Y') }}</p>

    <!-- Tabel -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrows as $index => $borrow)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $borrow->user->name ?? 'Tidak Diketahui' }}</td>
                <td>{{ $borrow->book->title ?? 'Tidak Diketahui' }}</td>
                <td>{{ ucfirst($borrow->status) }}</td>
                <td>{{ $borrow->created_at->format('d-m-Y') }}</td>
                <td>
                    {{ $borrow->returned_at ? \Carbon\Carbon::parse($borrow->returned_at)->format('d-m-Y') : 'Belum Dikembalikan' }}
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak Ada Data Peminjaman</td>
            </tr>
            @endforelse
        </tbody>
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