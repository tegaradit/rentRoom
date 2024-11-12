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
                        <td colspan="7" class="text-center alert alert-danger">Data Laporan masih Kosong</td>
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

            // Untuk center teks
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
            const lineYPosition1 = 40 // Posisi Y untuk garis atas
            doc.setLineWidth(0.5) // Lebar garis pertama
            doc.line(20, lineYPosition1, pageWidth - 20, lineYPosition1) // Garis pertama (atas)

            // Menambahkan judul laporan
            doc.setFontSize(12)
            doc.setFont("times", "bold")
            doc.text('Laporan Peminjaman Ruangan', 105, 55, null, null, 'center')

            // Mengambil data tabel
            // const data = JSON.parse('{!! $datas !!}').map((item, ix) => {
            //     return [`${ix + 1}`, item.nama_peminjam, item.ruangan.nama_ruangan, item.tgl_peminjaman, item.waktu_mulai, item.waktu_selesai, item.keperluan]
            // })

            const data = [
                ['1', 'lklkmlkmqlkmlkml', 'indoor', '2024-01-03', '07:00:00', '11:00:00', 'kjnkjnjknk'],
                ['2', 'knjkn', 'indoor', '2024-01-05', '07:00:00', '07:00:00', 'kjnjkn'],
                ['3', 'kjjknkj', 'indoor', '2024-01-08', '07:00:00', '10:00:00', 'nkjnkjn'],
                ['4', 'kjjnjk', 'indoor', '2024-01-05', '11:00:00', '11:00:00', 'knkjnkj'],
                ['5', 'pak khabib', 'indoor', '2024-11-05', '07:00:00', '10:00:00', 'jhasdasdj'],
                ['6', 'nugroho', 'ruang sidang', '2024-11-11', '07:00:00', '08:00:00', 'rapat'],
                ['7', 'nugroho', 'ruang sidang', '2024-11-11', '11:00:00', '13:00:00', 'rapat'],
                ['8', 'nugroho', 'tribun', '2024-11-08', '13:00:00', '13:00:00', 'kombel'],
                ['9', 'nugroho', 'tribun', '2024-11-15', '13:00:00', '13:00:00', 'binroh'],
                ['10', 'nugroho', 'tribun', '2024-11-22', '13:00:00', '13:00:00', 'kurikulum'],
                ['11', 'nugroho', 'tribun', '2024-11-05', '07:00:00', '16:00:00', 'muk'],
                ['12', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['13', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['14', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['15', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['16', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['17', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['18', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['19', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['20', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['21', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['22', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk'],
                ['23', 'lkmlkmlmlm', 'ruang sidang', '2024-11-13', '08:26:26', '12:57:37', 'knjknjk']
            ]
            // Menambahkan tabel ke PDF menggunakan autoTable dengan auto-pagination
            doc.autoTable({
                head: [
                    ['No', 'Peminjam', 'Ruangan', 'Tanggal Peminjaman', 'Waktu Mulai', 'Waktu Selesai',
                        'Keperluan'
                    ]
                ],
                body: data,
                startY: 63, // Posisi awal tabel
                theme: 'striped',
                margin: {
                    top: 10
                },
                styles: {
                    halign: 'center'
                },
                headStyles: {
                    halign: 'center'
                },
                // pageBreak:'auto';
                // Halaman otomatis
                didDrawPage: function (data) {
                    // Jika halaman baru, tambahkan kop surat di setiap halaman
                    if (data.pageNumber > 1) {
                        doc.addImage(imgBase64, 'PNG', 22, 10, 25, 25);
                        doc.setFontSize(12);
                        doc.setFont("times", "bold");
                        centerText('PEMERINTAH PROVINSI JAWA TENGAH', 15, offsetX);
                        centerText('DINAS PENDIDIKAN DAN KEBUDAYAAN', 21, offsetX);
                        centerText('SEKOLAH MENENGAH KEJURUAN NEGERI 1 KEBUMEN', 27, offsetX);

                        doc.setFontSize(11);
                        doc.setFont("times", "normal");
                        centerText(
                            'Jalan Cemara No.37 Karangsari Kebumen Kode Pos 54351 Telepon 0287-381132',
                            33, offsetX);
                        centerText('Faksimile 0287-381132 Surat Elektronik: smkn1.kebumen@yahoo.com', 37,
                            offsetX);

                        const lineYPosition1 = 40; // Posisi Y untuk garis atas di halaman baru
                        doc.setLineWidth(0.5); // Lebar garis pertama
                        doc.line(20, lineYPosition1, pageWidth - 20,
                            lineYPosition1); // Garis pertama (atas)
                    }
                },
            });

            // Menambahkan tanda tangan di pojok kanan bawah halaman terakhir
            const pageHeight = doc.internal.pageSize.height;
            const signatureX = pageWidth - 70;
            doc.setFontSize(12);
            doc.text('Kebumen, ........................', signatureX, pageHeight - 67);
            doc.text('Mengetahui:', signatureX + 10, pageHeight - 60);
            doc.text('(......................................)', signatureX, pageHeight - 30);

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