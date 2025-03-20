<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Data Buku</title>
    <style>
        /* Styling umum */
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

        /* Styling tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
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

        /* Header dan Footer */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #888;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>Laporan Data Buku</h2>
        <p>Tanggal: {{ now()->format('d-m-Y') }}</p>
    </div>

    <!-- Tabel Data Buku -->
    <table>
        <thead>
            <tr>
                @foreach($books->first()->getAttributes() as $key => $value)
                    <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    @foreach($book->getAttributes() as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        Halaman <script type="text/php">
            if (isset($pdf)) {
                echo $pdf->get_page_number() . ' dari ' . $pdf->get_page_count();
            }
        </script>
    </div>

</body>

</html>
