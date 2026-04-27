<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian Perkara</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .table-container {
            margin-top: 50px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container table-container flex-grow-1 mb-5">
        <h2 class="mb-4 text-center">Data Riwayat Perkara</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 5%">Nomor</th>
                        <th style="width: 25%">Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Jika response JSON dibungkus dalam key 'data' atau sejenisnya
                        $listData = $dataperkara;
                        if(isset($dataperkara['data']) && is_array($dataperkara['data'])) {
                            $listData = $dataperkara['data'];
                        } elseif(isset($dataperkara['status']) && is_array($dataperkara['status'])) {
                            $listData = $dataperkara['status'];
                        }
                    @endphp

                    @if(isset($listData) && is_array($listData) && count($listData) > 0)
                        @foreach($listData as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    @if(isset($item['tgl_status']))
                                        {{ $item['tgl_status'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item['status_perkara'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="btn btn-secondary px-4">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
