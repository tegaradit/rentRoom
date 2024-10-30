@extends('layouts.page')

@section('page-content')
    <div class="pagetitle">
        <h1>Data Laporan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Laporan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <form method="GET" action="{{ route('laporan.index') }}" class="mb-3">
            <div class="row">
                <!-- Tanggal Awal -->
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}">
                </div>

                <!-- Tanggal Akhir -->
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <!-- Tombol Filter dan Bersihkan -->
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-danger">
                        <i class="bi bi-eraser me-1"></i> Bersihkan
                    </a>
                </div>
            </div>
        </form>

        <!-- Tombol Export ke Excel -->
        <button class="btn btn-success" onclick="exportTableToExcel()">Export to Excel</button>
        
        <!-- Tabel Laporan -->
        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table id="tableID" class="table datatable table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Keperluan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->user->nama_lengkap }}</td>
                            <td>{{ $data->ruangan->nama_ruangan }}</td>
                            <td>{{ $data->tgl_peminjaman }}</td>
                            <td>{{ $data->waktu_mulai }}</td>
                            <td>{{ $data->waktu_selesai }}</td>
                            <td>{{ $data->keperluan }}</td>
                            <td>
                                @if ($data->status == 'diterima')
                                    <span class="badge bg-success">{{ $data->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $data->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center alert alert-danger">Data Laporan masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Script untuk Export ke Excel -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
        <script>
            function exportTableToExcel() {
                var table = document.getElementById("tableID");
                var tableData = [];

                // Kop surat berdasarkan gambar
                var kopSurat = [
                    ['PEMERINTAH PROVINSI JAWA TENGAH'],
                    ['DINAS PENDIDIKAN DAN KEBUDAYAAN'],
                    ['SEKOLAH MENENGAH KEJURUAN NEGERI 1 KEBUMEN'],
                    ['Jalan Cemara No.37 Karangsari Kebumen Kode Pos 54351 Telepon 0287-381132'],
                    ['Faksimile 0287-381132 Surat Elektronik smkn1.kebumen@yahoo.com'],
                    ['']
                ];

                var namaPemakai = [
                    ['Nama Peminjam: ' + document.querySelector("#tableID tbody tr td:nth-child(2)").innerText],
                    ['']
                ];

                // Menambahkan kop surat dan nama pemakai ke dalam data yang akan diekspor
                tableData = tableData.concat(kopSurat);
                tableData = tableData.concat(namaPemakai);

                // Mengambil data dari tabel
                for (var i = 0, row; row = table.rows[i]; i++) {
                    var rowData = [];
                    for (var j = 0, col; col = row.cells[j]; j++) {
                        rowData.push(col.innerText);
                    }
                    tableData.push(rowData);
                }

                // Membuat worksheet dari data
                var ws = XLSX.utils.aoa_to_sheet(tableData);

                // Membuat workbook baru
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Laporan");

                // Ekspor workbook ke file Excel
                XLSX.writeFile(wb, "Laporan_Peminjaman.xlsx");
            }
        </script>

    </section>
@endsection
