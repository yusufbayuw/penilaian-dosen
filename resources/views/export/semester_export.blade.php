<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Penilaian Dosen - {{ $semester->nama }} </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        table {
            font-size: 1rm;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 5px 5px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3182ce;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        tr:hover {
            background-color: #edf2f7;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .table-footer {
            font-weight: bold;
            background-color: #3182ce;
            color: white;
        }
    </style>
</head>

<body>
    <div>
        <h1>Data Penilaian Semester {{ $semester->nama ? " - " . $semester->nama : null }}<</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>MATAKULIAH</th>
                <th>KELAS</th>
                <th>DOSEN</th>
                <th class="text-right">TOTAL NILAI</th>
                <th class="text-right">JUMLAH PENILAI</th>
                <th class="text-right">RATA-RATA</th>
                <th class="text-right">PERSENTASE</th>
            </tr>
        </thead>
        <tbody>
            @if ($data ?? false)
                @foreach ($data as $key => $d)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $d->nama_mata_kuliah }}</td>
                        <td>{{ $d->nama_kelas }}</td>
                        <td>{{ $d->nama_dosen }}</td>
                        <td class="text-right">{{ $d->total_nilai }}</td>
                        <td class="text-right">{{ $d->jumlah_penilai }}</td>
                        <td class="text-right">{{ number_format($d->rata_rata, 2) }}</td>
                        <td class="text-right">{{ number_format($d->rata_rata/48, 2) . " %" }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>
