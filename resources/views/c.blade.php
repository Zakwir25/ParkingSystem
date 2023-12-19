<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
        <form action="{{ url('/admin/laporan') }}" method="get">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Filter Laporan</button>
        </form>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Kode Unik</th>
                    <th>Nomor Polisi</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Biaya Parkir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $data)
                    <tr>
                        <td>{{ $data->kode_unik }}</td>
                        <td>{{ $data->nomor_polisi }}</td>
                        <td>{{ $data->waktu_masuk }}</td>
                        <td>{{ $data->waktu_keluar }}</td>
                        <td>{{ $data->biaya_parkir }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ url('/admin/export-laporan') }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}" class="btn btn-success">Export Laporan</a>
    </div>
    
</body>
</html>