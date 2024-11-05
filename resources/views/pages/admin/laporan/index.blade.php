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
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}">
                </div>
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

        <button class="btn btn-danger" onclick="exportToPDF()"><i class="bi bi-filetype-pdf"></i> Export to PDF</button>

        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            <table id="tableID" class="table datatable table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Ruangan</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->nama_peminjam }}</td>
                            <td>{{ $data->ruangan->nama_ruangan }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_peminjaman)->format('d-m-Y') }}</td>
                            <td>{{ $data->waktu_mulai }}</td>
                            <td>{{ $data->waktu_selesai }}</td>
                            <td>{{ $data->keperluan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center alert alert-danger">Data Laporan masih Kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- jsPDF dan autoTable -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.21/jspdf.plugin.autotable.min.js"></script>
        <script>
            async function exportToPDF() {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                // URL gambar
                const imageUrl = '{{ asset('assets/themes/nice/img/logo smenza.png') }}';
                const imgBase64 = await getBase64ImageFromUrl(imageUrl);
                doc.addImage(imgBase64, 'PNG', 22, 10, 25, 25);

                // Kop surat di kanan
                doc.setFontSize(12);
                doc.setFont("times", "bold");

                //untuk center teks
                const pageWidth = doc.internal.pageSize.width;
                const centerX = pageWidth / 2;

                function centerText(text, yPosition, offsetX = 0) {
                    const textWidth = doc.getTextWidth(text);
                    doc.text(text, centerX - textWidth / 2 + offsetX, yPosition);
                }

                const offsetX = 10;

                centerText('PEMERINTAH PROVINSI JAWA TENGAH', 15, offsetX);
                centerText('DINAS PENDIDIKAN DAN KEBUDAYAAN', 21, offsetX);
                centerText('SEKOLAH MENENGAH KEJURUAN NEGERI 1 KEBUMEN', 27, offsetX);

                doc.setFontSize(11);
                doc.setFont("times", "normal");
                centerText('Jalan Cemara No.37 Karangsari Kebumen Kode Pos 54351 Telepon 0287-381132', 33, offsetX);
                centerText('Faksimile 0287-381132 Surat Elektronik: smkn1.kebumen@yahoo.com', 37, offsetX);

                // Menambahkan garis bawah ganda
                const lineYPosition1 = 40; // Posisi Y untuk garis atas

                doc.setLineWidth(0.5); // Lebar garis pertama
                doc.line(20, lineYPosition1, pageWidth - 20, lineYPosition1); // Garis pertama (atas)

                // Menambahkan judul laporan
                doc.setFontSize(12);
                doc.setFont("times", "bold");
                doc.text('Laporan Peminjaman Ruangan', 105, 55, null, null, 'center');

                // Mengambil data tabel
                const table = document.getElementById("tableID");
                const data = [];
                for (var i = 1, row; row = table.rows[i]; i++) {
                    const rowData = [];
                    for (var j = 0, col; col = row.cells[j]; j++) {
                        rowData.push(col.innerText);
                    }
                    data.push(rowData);
                }

                // Menambahkan tabel ke PDF menggunakan autoTable
                doc.autoTable({
                    head: [
                        ['No', 'Peminjam', 'Ruangan', 'Tanggal Peminjaman', 'Waktu Mulai', 'Waktu Selesai',
                            'Keperluan'
                        ]
                    ],
                    body: data,
                    startY: 63,
                    theme: 'striped',
                    margin: {
                        top: 10
                    },
                    styles:{
                        halign:'center'
                    },
                    headStyles:{
                        halign:'center'
                    }
                });

                // Simpan PDF
                doc.save('Laporan_Peminjaman.pdf');
            }

            // Fungsi untuk mengkonversi gambar ke base64
            function getBase64ImageFromUrl(url) {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.src = url;
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        const dataURL = canvas.toDataURL('image/png');
                        resolve(dataURL);
                    };
                    img.onerror = error => reject(error);
                });
            }
        </script>
    </section>
@endsection
