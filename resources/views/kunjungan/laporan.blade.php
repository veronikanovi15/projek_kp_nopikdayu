<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kunjungan</title>
    <style>
        /* Tambahkan CSS jika diperlukan untuk format PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Kunjungan</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Kunjungan</th>
                <th>Pengunjung</th>
                <th>Kota Asal</th>
                <th>Penerima Kominfo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kunjungans as $kunjungan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($kunjungan->tanggal_kunjungan)->format('d-m-Y') }}</td>
                    <td>{{ $kunjungan->pengunjung }}</td>
                    <td>{{ $kunjungan->kota_asal }}</td>
                    <td>{{ $kunjungan->penerima }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>